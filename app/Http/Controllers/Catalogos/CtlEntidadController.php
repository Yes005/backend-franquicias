<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Services\CtlEntidadService;
use App\Http\Requests\Request;

class CtlEntidadController extends Controller
{
    protected $CtlEntidadService;

    public function __construct(CtlEntidadService $CtlEntidadService)
    {
        $this->CtlEntidadService = $CtlEntidadService;
    }

    public function getEntidades(Request $request){
        $listarEntidades = $this->CtlEntidadService->getEntidades($request);

        return response($listarEntidades);
    }
}
