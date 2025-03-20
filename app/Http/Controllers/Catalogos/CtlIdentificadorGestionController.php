<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Http\Requests\v1\CtlIdentificadorGestionRequest;
use App\Services\CtlIdentificadorGestionService;

class CtlIdentificadorGestionController extends Controller
{
    protected $ctlIdentificadorGestion;

    public function __construct(CtlIdentificadorGestionService $ctlIG)
    {
        $this->ctlIdentificadorGestion = $ctlIG;
    }

    public function getIdentifiacionGestion(Request $request)
    {
        $data = $this->ctlIdentificadorGestion->ListarGestiones($request);
        return response()->json($data['data'])
        ->header('total_rows', $data['total']);
    }

    public function createIndentificador(CtlIdentificadorGestionRequest $request)
    {
        $data = $this->ctlIdentificadorGestion->createIdentificador($request);
        return response($data,201);
    }

    public function editIdentificador(CtlIdentificadorGestionRequest $request, $id)
    {
        $data = $this->ctlIdentificadorGestion->editIdentificador($request, $id);
        return response($data);
    }


}
