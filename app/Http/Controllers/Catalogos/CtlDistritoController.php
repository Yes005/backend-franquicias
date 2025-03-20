<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Services\CtlDistritoService;

class CtlDistritoController extends Controller
{
    protected $CtlDistritoService;

    public function __construct(CtlDistritoService $CtlDistritoService)
    {
        $this->CtlDistritoService = $CtlDistritoService;
    }

    public function getDistritos(Request $request){
        $listar_distritos = $this->CtlDistritoService->getDistritos($request);

        return response($listar_distritos);
    }
}
