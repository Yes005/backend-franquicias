<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CtlFirmanteRequest;
use App\Services\CtlFirmanteService;

class CtlFirmanteController extends Controller
{
    protected $CtlFirmanteService;

    public function __construct(CtlFirmanteService $CtlFirmanteService)
    {
        $this->CtlFirmanteService = $CtlFirmanteService;
    }

    public function getFirmantes(Request $request){
        $listarFirmantes = $this->CtlFirmanteService->getFirmantes($request);

        return response($listarFirmantes['data'])->header('total_rows', $listarFirmantes['total']);
    }

    public function createFirmante(CtlFirmanteRequest $request){
        $crear = $this->CtlFirmanteService->createFirmante($request);

        return response($crear, 201);
    }

    public function editFirmante(CtlFirmanteRequest $request, $id){
        $editar = $this->CtlFirmanteService->editFirmante($request, $id);

        return response($editar);
    }
}
