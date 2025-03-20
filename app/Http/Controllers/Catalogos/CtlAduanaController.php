<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CatalogoRequest;
use App\Services\CtlAduanaService;
use App\Http\Requests\Request;

class CtlAduanaController extends Controller
{
    protected $ctlAduanaService;

    public function __construct(CtlAduanaService $ctlAduanaService)
    {
        $this->ctlAduanaService = $ctlAduanaService;
    }

    public function getAduanas(Request $request)
    {
        $listarAduanas = $this->ctlAduanaService->ListarAduanas($request);
        return response()->json($listarAduanas['data'])
        ->header('total_rows', $listarAduanas['total']);
    }

    public function createAduana(CatalogoRequest $request)
    {
        $crear = $this->ctlAduanaService->createAduana($request);
        return response($crear,201);
    }

    public function editAduana(CatalogoRequest $request,$id)
    {
        $editar = $this->ctlAduanaService->editAduana($request,$id);
        return response($editar);
    }

    public function changeState($id)
    {
        $estado = $this->ctlAduanaService->changeStateAduana($id);
        return response($estado);
    }
}
