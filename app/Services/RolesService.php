<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Models\Catalogos\CtlPermiso;
use App\Models\Catalogos\CtlRole;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Class RolesService
{
    public function listarRoles(Request $request)
    {
        $data = CtlRole::with([
            'user' => function ($query) {
                $query->select('id', 'name','last_name');
            },
        ])
        ->select('id', 'nombre','id_usuario','created_at','activo')
        ->orderBy('id','desc')
        ->when(isset($request->nombre), function ($query)use ($request){
            $query->search($request->nombre,['id','nombre','name','last_name'],['user']);
        })
        ->paginateData($request);

        return $data;
    }

    public function listarRolesSelect()
    {
        $user = Auth::user();
        if(!$user)
            throw new AuthorizationException('Debes estar autenticado para realizar esta acción');
        $data = CtlRole::select('id', 'nombre')->where('activo',true)->get();
        return $data;
    }


    public function crearRol(Request $request)
    {
        $request->validate([
            "nombre" => ['required','min:4','max:150','string'],
            "permisos" => ['array', 'required','min:1'],
            "permisos.*" => ['integer', 'required','exists:ctl_permisos,id']
        ]);

        $user = Auth::user();
        if(!$user)
            throw new AuthorizationException('Debes estar autenticado para realizar esta acción');
        DB::beginTransaction();
        //creando el rol
        $rol = CtlRole::create([
            'nombre' => $request->nombre,
            'activo' => true,
            'created_at' => Carbon::now(),
            'id_usuario' => $user->id
        ]);
        //asignando los permisos
        foreach ($request->permisos as $permiso) {
            $new = CtlPermiso::find($permiso);
            $rol->permisos()->attach($new);
            $rol->permisos->created_at = Carbon::now();
        }
        DB::commit();

        return ['message' => 'Rol creado y permisos asignados con éxito'];
    }

    public function editRol(Request $request,$id)
    {
        $rol = CtlRole::find($id);
        if(!$rol)
            throw new NotFoundHttpException('No se encontró el rol');

        $request->validate([
            "nombre" => ['nullable','min:4','max:150','string'],
            "permisos" => ['array', 'nullable','min:1'],
            "permisos.*" => ['integer', 'nullable','exists:ctl_permisos,id']
        ]);

        $user = Auth::user();
        if(!$user)
            throw new AuthorizationException('Debes estar autenticado para realizar esta acción');

        if($request->has('nombre'))
            $rol->nombre = $request->nombre;

        if($request->has('permisos'))
            $rol->permisos()->sync($request->permisos);

        $rol->id_usuario = $user->id;
        $rol->updated_at = Carbon::now();
        $rol->save();

        return ['message' => 'Rol y permisos actualizados con éxito'];
    }

    public function changeState($id)
    {
        $rol = CtlRole::find($id);
        if(!$rol)
            throw new NotFoundHttpException('No se encontró el rol');
        $rol->activo = !$rol->activo;
        $rol->updated_at = Carbon::now();
        $rol->save();

        return ['message' =>  'Se cambió el estado del rol exitosamente'];
    }
}
