<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CtlInstitucionRequest;
use App\Services\CtlInstitucionService;

class CtlInstitucionController extends Controller
{
    protected $CtlInstitucionService;

    public function __construct(CtlInstitucionService $CtlInstitucionService)
    {
        $this->CtlInstitucionService = $CtlInstitucionService;
    }

    public function getInstituciones(Request $request){
        $listarInstituciones = $this->CtlInstitucionService->getInstituciones($request);

        return response($listarInstituciones['data'])->header('total_rows', $listarInstituciones['total']);
    }

    public function createInstitucion(CtlInstitucionRequest $request){
        $crear = $this->CtlInstitucionService->createInstitucion($request);

        return response($crear, 201);
    }

    public function editInstitucion(CtlInstitucionRequest $request, $id){
        $editar = $this->CtlInstitucionService->editInstitucion($request, $id);

        return response($editar);
    }

    public function changeStateInstitucion($id){
        $estado = $this->CtlInstitucionService->changeStateInstitucion($id);

        return response($estado);
    }
}
