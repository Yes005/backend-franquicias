<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Services\CtlOficialService;

class CtlOficialController extends Controller
{
    protected $CtlOficialService;

    public function __construct(CtlOficialService $CtlOficialService)
    {
        $this->CtlOficialService = $CtlOficialService;
    }

    public function getOficiales(Request $request){
        $listarOficiales = $this->CtlOficialService->getOficiales($request);

        return response($listarOficiales['data'])->header('total_rows', $listarOficiales['total']);
    }

    public function createOficial(CatalogoRequest $request){
        $crear = $this->CtlOficialService->createOficial($request);

        return response($crear);
    }

    public function editOficial(CatalogoRequest $request, $id){
        $editar = $this->CtlOficialService->editOficial($request,$id);

        return response($editar);
    }

    public function changeStateOficial($id){
        $estado = $this->CtlOficialService->changeStateOficial($id);

        return response($estado);
    }
}
