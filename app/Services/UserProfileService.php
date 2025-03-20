<?php

namespace App\Services;

use App\Enum\RoutesEmailEnum;
use App\Http\Requests\Request;
use App\Http\Requests\v1\UserProfileRequest;
use App\Jobs\EnvioCorreo;
use App\Mail\CredencialesUsuario;
use App\Mail\DesbloqueoUsuario;
use App\Mail\RecuperarAcceso;
use App\Models\Catalogos\CtlDistrito;
use App\Models\Catalogos\CtlRole;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserProfileService
{
    public function listarUsers(Request $request)
    {
        $template = User::with([
            'roles' => function($query) {
                $query->select('rol_id', 'usuario_id','ctl_roles.nombre');
            },
            'profile' => function($query){
                $query->select('id','id_distrito','id_usuario', 'cod_colaborador','titulo','cargo','firmador');
            },
            'profile.distrito' => function ($query){
                $query->select('id','id_municipio','nombre');
            },
            'profile.distrito.municipio' => function ($query){
                $query->select('id','id_departamento','nombre');
            },
            'profile.distrito.municipio.departamento'
        ])
        ->select('id','name', 'last_name','email','created_at','activo','login_attempts')
        ->when(isset($request->valor), function ($query)use ($request){
            $query->search($request->valor,
                ['CONCAT(name," ",last_name)','nombre','cod_colaborador'],
                ['profile','profile.distrito','profile.distrito.municipio','profile.distrito.municipio.departamento']
            );
        })->whereNot('id', Auth::user()->id)
        ->paginateData($request);
        $data = collect($template['data'])->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'last_name' => $user->last_name ?? '',
                'email' => $user->email,
                'activo' => $user->activo,
                'is_blocked' => $user->login_attempts >= 5,
                'distrito' => isset($user->profile->distrito) ? [
                    'id' => $user->profile->distrito->id,
                    'nombre' => $user->profile->distrito->nombre,
                ] : null,
                'municipio' => isset($user->profile->distrito->municipio) ? [
                    'id' => $user->profile->distrito->municipio->id,
                    'nombre' => $user->profile->distrito->municipio->nombre,
                ] : null,
                'departamento' => isset($user->profile->distrito->municipio->departamento) ? [
                    'id' => $user->profile->distrito->municipio->departamento->id,
                    'nombre' => $user->profile->distrito->municipio->departamento->nombre
                ] : null,
                'fecha_creacion' => $user->created_at->format('d/m/Y'),
                'cod_colaborador' => $user->profile->cod_colaborador ?? '',
                'titulo' => $user->profile->titulo ?? '',
                'cargo' => $user->profile->cargo ?? '',
                'firmador' => isset($user?->profile->firmador) ? (bool) $user->profile->firmador : false,
                'roles' => $user?->roles->map(function($rol){
                    return [
                        'rol_id' => $rol->rol_id,
                        'nombre' => $rol->nombre
                    ];
                }),
            ];
        });
        return [
            'data' => $data,
            'total' => $template['total'],
        ];
    }

    public function createUser(UserProfileRequest $request)
    {
        $url = RoutesEmailEnum::LOGIN->getUrl();
        $request->validate([
            'email' => [Rule::unique('users','email')],
            'cod_colaborador' => [Rule::unique('profile', 'cod_colaborador')],
        ]);
        $temp_password = Str::random(20);
        $distrito = CtlDistrito::find($request->id_distrito);
        $roles = $request->roles;

        DB::beginTransaction();
        //creando usuario
        $user = User::create(
            array_merge(
                $request->only(['name','last_name','email']),
                [
                    'password' => bcrypt($temp_password),
                    'temporal_password' => true,
                    'created_at' => Carbon::now()
                ]
            )
        );


        //asignando roles
        foreach ($roles as $rol) {
            $bRol = CtlRole::find($rol);
            $user->roles()->attach($bRol);
        }

        //creando perfil de usuario
        $user->profile()->create(
            array_merge(
                $request->only(['cod_colaborador', 'titulo', 'cargo', 'firmador']),
                [
                    'id_distrito' => $distrito->id,
                    'created_at' => Carbon::now()
                ]
            )
        );

        if($request->firmador === true)
        {
            $last_firmador = Profile::where('firmador', true)
            ->where('id', '!=', $user->profile->id)
            ->first();

            if ($last_firmador) {
                $last_firmador->firmador = false;
                $last_firmador->save();
            }
        }


        DB::commit();
        //envio de correo al usuario

        $correo = new CredencialesUsuario($user, $temp_password, $url);
        EnvioCorreo::dispatch($user->email, $correo);

        return ['message' => 'Usuario creado con éxito'];
    }

    public function editUser(UserProfileRequest $request,$id)
    {
        $user = User::find($id);
        
        $distrito = CtlDistrito::find($request->id_distrito);
  
        $roles = $request->roles;

       

        if(!$user)
            throw new NotFoundHttpException('No se encontró el usuario');
        $request->validate([
            'email' => [Rule::unique('users','email')->ignore($id)],
        ]);

        if ($user->profile){
            $request->validate([
                'cod_colaborador' => [Rule::unique('profile', 'cod_colaborador')->ignore($user->profile->id)],
            ]);
        }
        DB::beginTransaction();
       
        $user->update(
            $request->only(['name', 'last_name', 'email'])
        );

     

        if(!empty($roles))
        {
            $user->roles()->detach();
            foreach ($roles as $rol) {
                $bRol = CtlRole::find($rol);
                $user->roles()->attach($bRol);
            }
        }
        $user->profile()->updateOrCreate(['id' => $user?->profile?->id] ,
            array_merge(
                $request->only(['cod_colaborador', 'titulo', 'cargo', 'firmador']),
                [
                    'id_distrito' => $distrito->id ?? $user->profile->id_distrito,
                    'updated_at' => Carbon::now()
                ]
            )
        );



        if($request->firmador === true)
        {

            $last_firmador = Profile::where('firmador', true)
           
            ->where('id', '!=', $user?->profile?->id)
        
            ->first();
             
            if ($last_firmador) {
                $last_firmador->firmador = false;
                $last_firmador->save();
            }
        }
        DB::commit();
        return ['message' => 'Información del usuario actualizada con éxito'];
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => ['required', 'min:8','max:200']
        ]);
        $user = User::find(Auth::user()->id);
        DB::beginTransaction();
        $user->update([
            'password' => bcrypt($request->new_password),
            'temp_password' => false,
            'updated_at' => Carbon::now()
        ]);
        DB::commit();
        return ['message' => 'Contraseña actualizada éxitosamente'];
    }

    public function recoverPassword(Request $request)
    {
        $url = RoutesEmailEnum::LOGIN->getUrl();

        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->activo == false)
            throw new NotFoundHttpException('No se encontró el usuario');

        if ($user->login_attempts == 5 && $user->activo == false)
            throw new NotFoundHttpException('El usuario se encuentra bloqueado');

        $temp_password = Str::random(20);

        DB::beginTransaction();
        $user->update([
            'password' => bcrypt($temp_password),
            'temp_password' => true,
            'updated_at' => Carbon::now()
        ]);
        DB::commit();

        $correo = new RecuperarAcceso($user, $temp_password, $url);
        EnvioCorreo::dispatch($user->email, $correo);

        return ['message' => 'Contraseña restablecida con éxito'];
    }

    public function changeState($id)
    {
        $user =  User::find($id);
        if (!$user) {
            throw new NotFoundHttpException('No se encontró el usuario');
        }
        return DB::transaction(function () use ($user) {
            $user->activo = !$user->activo; // Cambiar el estado de activo
            $user->updated_at = Carbon::now();
            $user->save(); // Guardar los cambios
            return [
                'message' => 'Estado del usuario actualizado con éxito',
            ];
        });
    }

    public function unblockedUser($id)
    {
        $url = RoutesEmailEnum::LOGIN->getUrl();

        $user = User::find($id);

        if (!$user) {
            throw new NotFoundHttpException('No se encontró el usuario');
        }

        $temp_password = Str::random(20);

        return DB::transaction(function () use ($user, $temp_password, $url) {
            $user->login_attempts = 0;
            $user->activo = true;
            $user->password = bcrypt($temp_password);
            $user->temp_password = true;
            $user->updated_at = Carbon::now();
            $user->save();

            $correo = new DesbloqueoUsuario($user, $temp_password, $url);
            EnvioCorreo::dispatch($user->email, $correo);

            return [
                'message' => 'Usuario desbloqueado con éxito',
            ];
        });
    }
}
