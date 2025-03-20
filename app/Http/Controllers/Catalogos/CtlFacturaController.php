<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Http\Requests\v1\CtlFacturaRequest;
use App\Services\CtlFacturaService;

class CtlFacturaController extends Controller
{
    protected $ctlFacturaService;

    public function __construct(CtlFacturaService $ctlFacturaService)
    {
        $this->ctlFacturaService = $ctlFacturaService;
    }

    public function getFacturas(Request $request)
    {
        $listarFacturas = $this->ctlFacturaService->ListarFacturas($request);

        return response()->json($listarFacturas['data'])->header('total_rows',$listarFacturas['total']);
    }

    public function createFactura(CtlFacturaRequest $request)
    {
        $factura =$this->ctlFacturaService->createFactura($request);
        return response($factura,201);
    }

    public function editFactura(CtlFacturaRequest $request,$id)
    {
        $factura = $this->ctlFacturaService->editFactura($request,$id);
        return response($factura);
    }

    public function changeState($id)
    {
        $factura = $this->ctlFacturaService->changeStateFactura($id);
        return response($factura);
    }
}
