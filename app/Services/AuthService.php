<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Requests\v1\AuthRequest;
use App\Jobs\EnvioCorreo;
use App\Mail\BloqueoUsuario;
use App\Models\User;
use App\Models\Catalogos\CtlRole;
use Illuminate\Support\Facades\Auth;
use App\Models\Rutas;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AuthService
{
    /**
     * Login para un usuario
     * @param AuthRequest $request
     * @return object
     */
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user)
            throw new UnauthorizedException('Error las credenciales no son válidas');

        if((bool) $user->activo === false)
            throw new UnauthorizedException('El usuario no tiene permitido iniciar sesión');

        $token = JWTAuth::attempt($request->validated());

        if (!$token) {
            $user->increment('login_attempts');

            $intentosRestantes = 5 - $user->login_attempts;


            if ($user->login_attempts >= 5) {
                DB::beginTransaction();
                $user->update(['activo' => false]);
                DB::commit();

                $correo = new BloqueoUsuario($user);
                EnvioCorreo::dispatch($user->email, $correo);

                throw new UnauthorizedException('Contraseña incorrecta, usuario bloqueado');
            }

            if ($intentosRestantes === 1) {
                throw new UnauthorizedException("Contraseña incorrecta, le queda $intentosRestantes intento");
            } else {
                throw new UnauthorizedException("Contraseña incorrecta, le quedan $intentosRestantes intentos");
            }
        }

        // Reseteo de intentos fallidos si el usuario inicia sesión correctamente
        DB::beginTransaction();
        $user->update(['login_attempts' => 0]);
        DB::commit();

        $refresh = $this->generateRefreshToken($user);

        return $this->responseWithToken($token, $refresh);
    }
    /**
     * refrescar la sesion de un usuario
     * @param Request $request
     * @return object
     */
    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => ['required', 'string']
        ]);

        $user = User::WhereHas('personalAccessToken', function ($query) use ($request) {
            $query->where('name', 'refresh')
                ->where('expires_at', '>', now())
                ->where('token', $request->refresh_token);
        })->first();

        if (!$user)
            throw new BadRequestException('Error la sesión no es válida');

        $user->personalAccessToken()
            ->where('name', 'refresh')
            ->where('token', $request->refresh_token)
            ->delete();

        $token = JWTAuth::fromUser($user);
        $refresh = $this->generateRefreshToken($user);
        return $this->responseWithToken($token, $refresh);
    }
    /**
     * Cerrar la sesion de un usuario
     * @return array
     * @throws NotFoundHttpException
     */
    public function logout()
    {


        $user = JWTAuth::parseToken()->user();

        if (!$user)
            throw new NotFoundHttpException('Error no se encontro el usuario');
        $user->personalAccessToken()->delete();
        JWTAuth::parseToken()->invalidate();
        return ['message' => 'Sesion cerrada correctamente'];
    }
    /**
     * Genera un token de refresco
     * @param User $user
     * @return string
     */
    public function generateRefreshToken(User $user)
    {
        return DB::transaction(function () use ($user) {
            $user->personalAccessToken()->delete();
            $token  = Uuid::uuid4();
            $user->personalAccessToken()->create([
                'name' => 'refresh',
                'token' => $token,
                'abilities' => 'refresh_token',
                'expires_at' => now()->addMinutes(env('JWT_REFRESH', 10))
            ]);
            return $token;
        });
    }
    /**
     * Cambiar la contraseña de un usuario
     * @param Request $request
     * @return array
     * @throws NotFoundHttpException
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password_old' => ['required', 'string', 'min:8', 'different:password'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        $user = JWTAuth::user();
        if (!$user)
            throw new NotFoundHttpException('Error no se encontro el usuario');
        if (!password_verify($request->password_old, $user->password))
            throw new BadRequestException('Error la contraseña actual no es válida');
        $user->update([
            'password' => bcrypt($request->password),
            'temp_password' => false
        ]);
        return ['message' => 'Contraseña actualizada correctamente'];
    }
    private function responseWithToken($token, $refresh)
    {
        return [
            'token' => $token,
            'refresh_token' => $refresh,
        ];
    }
    /**
     * Verifica datos del usuario que ha iniciado sesion
     * @return array
     */
    public function verifyUser()
    {
        $userRol = User::with('roles')->find(Auth::user()->id);
        $rolPermiso = CtlRole::with('permisos')->find($userRol->roles->first()->id);
        $dataUsuario = [
            "nombre" => $userRol->name,
            "rol" => $userRol->roles->first()->nombre,
            "permisos" => $rolPermiso->permisos->pluck('nombre'),
            'temp_pwd' => (bool) $userRol->temp_password,
        ];
        return $dataUsuario;
    }

    public function getRutas()
    {
        $permisos = User::with(['roles.permisos'])
            ->find(Auth::user()->id)
            ->roles->pluck('permisos')
            ->flatten();
        $rutasPadre = Rutas::with(['permisos'])->whereHas('permisos', function ($query) use ($permisos) {
            $query->whereIn('permiso_id', $permisos->pluck('id')->toArray());
        })->where('ruta_padre_id')->orderBy('orden', 'asc')->get();
        $rutasWithChilds = $rutasPadre->map(function ($item, $key) use ($permisos) {
            return [
                ...collect($item)->except('permisos')->toArray(),
                'childs' => Rutas::with(['permisos:id'])
                    ->whereHas('permisos', function ($query) use ($permisos) {
                        $query->whereIn('permiso_id', $permisos->pluck('id')->toArray());
                    })->where('ruta_padre_id', $item->id)->orderBy('orden','asc')->get()->makeHidden(['permisos'])

            ];
        });
        return $rutasWithChilds;
    }
}
