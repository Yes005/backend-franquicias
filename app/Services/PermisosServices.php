<?php

namespace App\Services;

use App\Enum\TagsEnum;
use App\Models\Catalogos\CtlPermiso;
use App\Models\Catalogos\CtlRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PermisosServices
{
    public function listarPermisos()
    {
        // Obtener y transformar los permisos
        $data = CtlPermiso::select('id', 'tag','descripcion')->get()->map(function ($permiso) {
            return $permiso;
        });
        $grouped = $data->groupBy('tag');
        return $grouped;
    }

    public function getPermisosbyRol($id)
    {
        $user = Auth::user();
        if (!$user) {
            throw new AuthorizationException('Debes estar autenticado');
        }

        // Obtener todos los permisos
        $lstPermisos = CtlPermiso::select('id','tag', 'descripcion')->get();

        // Obtener permisos asociados al rol especificado
        $role = CtlRole::with(['permisos' => function ($query) {
            $query->select('ctl_permisos.id', 'ctl_permisos.tag','ctl_permisos.descripcion');
        }])
        ->find($id);

        if (!$role) {
            throw new NotFoundHttpException('Rol no encontrado');
        }

        $permisosByRol = $role->permisos;

        // Encontrar la intersección de los permisos
        $intersectedPermisos = $lstPermisos->intersect($permisosByRol);

        $data = [
            'id' => $role->id,
            'nombre' => $role->nombre,
            'permisos' => $intersectedPermisos,
        ];

        return $data;
    }

    //para convertir los permisos de formato PERMISO_VALOR en 'Permiso Valor'
    private function convertToTitleCase($name)
    {
        $words = explode('_', $name);
        $formattedWords = array_map(function ($word){
            return ucfirst(strtolower($word));
        }, $words);

        return implode(' ', $formattedWords);
    }
}
