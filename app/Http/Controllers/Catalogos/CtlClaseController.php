<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Services\CtlClaseService;

class CtlClaseController extends Controller
{
    protected $ctlClaseService;

    public function __construct(CtlClaseService $ctlClaseService)
    {
        $this->ctlClaseService = $ctlClaseService;
    }

    public function getClases(Request $request)
    {
        $listar = $this->ctlClaseService->ListarClases($request);
        return response()->json($listar['data'])->header('total_rows', $listar['total']);
    }

    public function createClase(CatalogoRequest $request)
    {
        $crear = $this->ctlClaseService->createClase($request);
        return response($crear,201);
    }

    public function editClase(CatalogoRequest $request,$id)
    {
        $editar = $this->ctlClaseService->editClase($request,$id);
        return response($editar);
    }

    public function changeState($id)
    {
        $estado = $this->ctlClaseService->changeStateClase($id);
        return response($estado);
    }
}
