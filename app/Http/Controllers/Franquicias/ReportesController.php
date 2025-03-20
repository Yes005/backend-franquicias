<?php

namespace App\Http\Controllers\Franquicias;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\ReporteRequest;
use App\Services\ReporteService;
use Symfony\Component\HttpFoundation\Response;

class ReportesController extends Controller
{

    private ReporteService $reporteService;

    public function __construct(ReporteService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    public function index(ReporteRequest $request)
    {
        $franquicias = $this->reporteService->listar($request);

        return response($franquicias->content, Response::HTTP_OK, $franquicias->headers);
    }

    public function franquicias(ReporteRequest $request)
    {
        $templatePath = $request->dia ? 'TEMPLATE_REPORTE_DIARIO' : 'TEMPLATE_REPORTE';

        $documento = $this->reporteService->generateDocFranquicias(
            $request,
            env($templatePath)
        );

        return $this->reporteService->download($documento, 'franquicias.docx');
    }


    public function franquiciaById(Request $request)
    {
        $request->validatePath([
            'id' => ['required', 'integer']
        ]);

        $documento = $this->reporteService->generateDocFranquciaById($request->id);

        return $this->reporteService->download($documento, 'franquicia.docx');
    }
}
