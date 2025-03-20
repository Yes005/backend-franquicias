<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Mocks\FilterVisitaMock;
use App\Http\Requests\v1\CtlFilterEntidadRequest;
use App\Services\CtlFiltroVisitaService;
use Illuminate\Http\JsonResponse;
use Laravel\Swagger\Attributes\SwaggerResponse;
use Laravel\Swagger\Attributes\SwaggerSection;

#[SwaggerSection('Catalogos')]
class CtlFiltroVisitaController extends Controller
{

    private CtlFiltroVisitaService $ctlFiltroVisitaService;

    public function __construct(CtlFiltroVisitaService $ctlFiltroVisitaService)
    {
        $this->ctlFiltroVisitaService = $ctlFiltroVisitaService;
    }


    #[SwaggerResponse(FilterVisitaMock::ENTIDADES)]
    public function entidades(): JsonResponse
    {

        $entidades = $this->ctlFiltroVisitaService->entidades();

        return response()->json($entidades);
    }


    #[SwaggerResponse(FilterVisitaMock::CODIGOS_ENTIDAD)]
    public function codigoFranquicias(CtlFilterEntidadRequest $request): JsonResponse
    {

        $codigosFranquicias = $this->ctlFiltroVisitaService->codigoFranquicias($request);

        return response()->json([
            'message' => 'Codigos de franquicias',
            'codigos' => $codigosFranquicias
        ]);
    }

    #[SwaggerResponse(FilterVisitaMock::SEGUIMIENTOS_ENTIDAD)]
    public function numeroSeguimiento(): JsonResponse
    {

        $numeroSeguimientos = $this->ctlFiltroVisitaService->numeroSeguimiento();

        return response()->json([
            'message' => 'Numero de seguimientos de visitas',
            'seguimientos' => $numeroSeguimientos
        ]);
    }
}
