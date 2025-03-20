<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Services\RolesService;


class RolesController extends Controller
{
    protected $rolesService;

    public function __construct(RolesService $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function getRoles(Request $request)
    {
        $roles = $this->rolesService->listarRoles($request);
        return response()->json($roles['data'])->header('total_rows', $roles['total']);
    }

    public function listarRolesSelect()
    {
        $listar = $this->rolesService->listarRolesSelect();
        return response()->json($listar);
    }

    public function crearRol(Request $request)
    {
        $rol = $this->rolesService->crearRol($request);
        return response()->json($rol,201);
    }

    public function actualizarRol(Request $request,$id)
    {
        $rol = $this->rolesService->editRol($request,$id);
        return response()->json($rol);
    }

    public function cambiarEstado($id)
    {
        $rol = $this->rolesService->changeState($id);
        return response()->json($rol);
    }
}
