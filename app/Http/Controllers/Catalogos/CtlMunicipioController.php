<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Services\CtlMunicipioService;

class CtlMunicipioController extends Controller
{
    protected $CtlMunicipioService;

    public function __construct(CtlMunicipioService $CtlMunicipioService)
    {
        $this->CtlMunicipioService = $CtlMunicipioService;
    }

    public function getMunicipios(Request $request){
        $listar_municipios = $this->CtlMunicipioService->getMunicipios($request);

        return response($listar_municipios);

    }
}
