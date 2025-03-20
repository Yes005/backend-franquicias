<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PermisosServices;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    protected $permisosService;
    public function __construct(PermisosServices $permisosServices)
    {
        $this->permisosService = $permisosServices;
    }

    public function listarPermisos()
    {
        $permisos = $this->permisosService->listarPermisos();
        return response()->json($permisos);
    }

    public function getPermisosbyRol($id)
    {
        $permisos = $this->permisosService->getPermisosbyRol($id);
        return response()->json($permisos);
    }
}
