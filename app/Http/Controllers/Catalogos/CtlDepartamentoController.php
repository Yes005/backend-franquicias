<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Services\CtlDepartamentoService;

class CtlDepartamentoController extends Controller
{
    protected $CtlDepartamentoService;

    public function __construct(CtlDepartamentoService $CtlDepartamentoService)
    {
        $this->CtlDepartamentoService = $CtlDepartamentoService;
    }

    public function getDepartamentos()
    {
        $listar_departamentos = $this->CtlDepartamentoService->getDepartamentos();

        return response($listar_departamentos);
    }
}
