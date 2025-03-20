<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Mocks\CategoriaVisitaMock;
use App\Services\CtlCategoriaVisitaService;
use Illuminate\Http\JsonResponse;
use Laravel\Swagger\Attributes\SwaggerResponse;
use Laravel\Swagger\Attributes\SwaggerSection;

#[SwaggerSection('Catalogos')]
class CtlCategoriaVisitaController extends Controller
{

    private CtlCategoriaVisitaService $ctlCategoriaVisitaService;

    public function __construct(CtlCategoriaVisitaService $ctlCategoriaVisitaService)
    {
        $this->ctlCategoriaVisitaService = $ctlCategoriaVisitaService;
    }


    #[SwaggerResponse(CategoriaVisitaMock::INDEX)]
    public function index(): JsonResponse {

        $categorias = $this->ctlCategoriaVisitaService->listarAll();

        return response()->json($categorias);
    }
}
