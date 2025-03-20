<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Services\CtlEstadoService;
use Illuminate\Http\Request;

class CtlEstadoController extends Controller
{
    protected $CtlEstadoService;

    public function __construct(CtlEstadoService $CtlEstadoService)
    {   
        $this->CtlEstadoService = $CtlEstadoService;
    }

    public function getEstados(){

        $listado_estados = $this->CtlEstadoService->getEstados();

        return response($listado_estados);
    }


}
