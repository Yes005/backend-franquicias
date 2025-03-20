<?php

namespace App\Http\Controllers\Franquicias;

use App\Http\Controllers\Controller;
use App\Http\Mocks\VisitaCampoMock;
use App\Http\Requests\v1\FilterSeguimientoVisitaRequest;
use App\Http\Requests\v1\FilterVisitaCampoRequest;
use App\Http\Requests\v1\VisitaCampoRequest;
use App\Http\Resources\SeguimientoVisitaResource;
use App\Http\Resources\VisitaCampoResource;
use App\Services\PdfVisitaCampoService;
use App\Services\SeguimientoVisitaCampoService;
use App\Services\VisitaCampoService;
use Illuminate\Http\JsonResponse;
use Laravel\Swagger\Attributes\SwaggerContent;
use Laravel\Swagger\Attributes\SwaggerResponse;
use Laravel\Swagger\Attributes\SwaggerSection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

#[SwaggerSection('Franquicias')]
class VisitaCampoController extends Controller
{
    private VisitaCampoService $visitaCampoService;
    private SeguimientoVisitaCampoService $seguimientoService;
    private PdfVisitaCampoService $pdfVisitaCampoService;

    public function __construct(
        VisitaCampoService $visitaCampoService,
        SeguimientoVisitaCampoService $seguimientoService,
        PdfVisitaCampoService $pdfVisitaCampoService
    ) {
        $this->visitaCampoService = $visitaCampoService;
        $this->seguimientoService = $seguimientoService;
        $this->pdfVisitaCampoService = $pdfVisitaCampoService;
    }

    #[SwaggerResponse(VisitaCampoMock::INDEX)]
    public function index(FilterVisitaCampoRequest $request): JsonResponse
    {

        $visitas = $this->visitaCampoService->listar($request);

        $visitasCollection = VisitaCampoResource::collection($visitas->data);

        return response()->json($visitasCollection)->header('total_rows', $visitas->total);
    }

    #[SwaggerContent('multipart/form-data')]
    #[SwaggerResponse(VisitaCampoMock::STORE, Response::HTTP_CREATED)]
    public function store(VisitaCampoRequest $request): JsonResponse
    {
        $visita = $this->visitaCampoService->crear($request);

        return response()->json($visita->makeHidden('file_name', 'correlativo_file'), Response::HTTP_CREATED);
    }


    #[SwaggerContent('multipart/form-data')]
    #[SwaggerResponse(VisitaCampoMock::UPDATE)]

    public function update(VisitaCampoRequest $request, mixed $id): JsonResponse
    {
        $visita = $this->visitaCampoService->actualizar($request, $id);

        return response()->json($visita->makeHidden('file_name', 'correlativo_file'));
    }

    #[SwaggerResponse(VisitaCampoMock::DELETE)]
    public function delete(mixed $id): JsonResponse
    {
        $this->visitaCampoService->eliminar($id);

        return response()->json(['message' => 'Visita eliminada correctamente']);
    }

    #[SwaggerResponse(VisitaCampoMock::SEGUIMIENTO_INDEX)]
    public function seguimiento(FilterSeguimientoVisitaRequest $request): JsonResponse
    {
        $seguimientos =  $this->seguimientoService->listar($request);

        $seguimientosCollection = SeguimientoVisitaResource::collection($seguimientos->data);

        return response()->json($seguimientosCollection)->header('total_rows', $seguimientos->total);
    }

    #[SwaggerResponse(VisitaCampoMock::DETALLE_VISITA)]
    public function detalleVisitaCampo(mixed $id): JsonResponse
    {

        $visita = $this->visitaCampoService->detalleVisita($id);

        return response()->json($visita);
    }


    #[SwaggerResponse(VisitaCampoMock::DETALLE_SEGUIMIENTO_VISITA_CAMPO)]
    public function detalleSeguimiento(mixed $id): JsonResponse
    {
        $seguimiento = $this->seguimientoService->detalle($id);

        return response()->json($seguimiento);
    }

    public function generarReporteVisita(int $id): BinaryFileResponse
    {
        $pdf = $this->pdfVisitaCampoService->generarReporteVisita($id);

        return response()->file($pdf);
    }

    public function generarReportesVisita(int $franquiciaId): BinaryFileResponse
    {
        $pdf = $this->pdfVisitaCampoService->generarReportesVisita($franquiciaId);

        return response()->file($pdf);
    }
}
