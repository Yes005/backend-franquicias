<?php

namespace App\Services;

use App\Http\Requests\v1\FilterSeguimientoVisitaRequest;
use App\Models\Franquicia;
use App\Models\VisitaCampo;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Enum\EstadoFranquiciaEnum;
use App\Enum\EstadosEnum;

class SeguimientoVisitaCampoService
{


    public function listar(FilterSeguimientoVisitaRequest $request): object
    {
        $visitas =  VisitaCampo::with([
            'franquicia:id,tipo,institucion_id,oficial_id,codigo_franquicia',
        ])
            ->select('numero_seguimiento', 'entidad_id', DB::raw('max(updated_at) as updated_at', 'estado_id'))
            ->where('estado_id', EstadoFranquiciaEnum::FINALIZADO)
            ->search($request->numero_seguimiento, 'numero_seguimiento', [])
            ->whereHas('franquicia', function ($query) use ($request) {
                $query->when($request->institucion_id, fn($query,$value) => $query->where('institucion_id', $value))
                ->when($request->oficial_id, fn($query, $value) => $query->where('oficial_id', $value));
            })
            ->search($request->numero_franquicia, 'codigo_franquicia', ['franquicia'])
            ->groupBy('numero_seguimiento', 'entidad_id')
            ->orderBy('updated_at', 'desc')
            ->paginateData($request);

        return (object) $visitas;
    }

    public function detalle($id)
    {
        $franquicia = Franquicia::find($id);

        if (!$franquicia) {
            throw new NotFoundHttpException('No se encontró la franquicia');
        }

        $visitas = VisitaCampo::with(['franquicia', 'estado', 'archivos', 'nombres'])
            ->where('entidad_id', $franquicia->id)->where('estado_id', EstadoFranquiciaEnum::FINALIZADO)
            ->orderByRaw('fecha_visita DESC, TIME(created_at) DESC')
            ->get();

        $totalReportes = $visitas->count();
        $totalConObservaciones = $visitas->where('categoria_visita_id', 2)->count();
        $totalSinObservaciones = $totalReportes - $totalConObservaciones;

        $reportes = $visitas->map(function ($reporte) {
            return [
                'id' => $reporte->id,
                'franquicia' => $reporte->franquicia?->entidad?->nombre,
                'numero_seguimiento' => $reporte->numero_seguimiento,
                'fecha_visita' => $reporte->fecha_visita?->format('Y-m-d'),
                'detalle' => $reporte->detalle,
                'categoria_visita' => $reporte->categoria_visita_id == 1 ? 'Sin observaciones' : 'Con observaciones',
            ];
        });

        return [
            'numero_seguimiento' => $visitas->first()->numero_seguimiento ?? null,
            'entidad' => $franquicia->entidad?->nombre,
            'codigo_franquicia' => $franquicia->codigo_franquicia,
            'totales' => [
                'total_reportes' => $totalReportes,
                'total_con_observaciones' => $totalConObservaciones,
                'total_sin_observaciones' => $totalSinObservaciones,
            ],
            'reportes' => $reportes,
        ];
    }
}
