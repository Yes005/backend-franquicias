<?php

namespace App\Services;

use App\Models\Franquicia;
use App\Enum\EstadoFranquiciaEnum;
use App\Http\Requests\v1\CtlFilterEntidadRequest;
use App\Models\VisitaCampo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlFiltroVisitaService
{


    public function entidades(): mixed
    {

        return Franquicia::with(['institucion:id,nombre', 'oficial:id,nombre'])
            ->select('oficial_id', 'institucion_id', 'tipo')
            ->whereIn('estado', [EstadoFranquiciaEnum::APROBADA, EstadoFranquiciaEnum::FIRMADA])
            ->groupBy('institucion_id', 'oficial_id', 'tipo')
            ->get()->map(function ($item) {
                return  [
                    'institucion_id' =>  $item?->institucion_id,
                    'oficial_id' => $item?->oficial_id,
                    'nombre' => $item?->entidad?->nombre,
                ];
            });
    }

    public function codigoFranquicias(CtlFilterEntidadRequest $request): mixed
    {

        $codigos =  Franquicia::select('id', 'codigo_franquicia', 'institucion_id', 'oficial_id', 'estado')
            ->whereIn('estado', [EstadoFranquiciaEnum::APROBADA, EstadoFranquiciaEnum::FIRMADA])
            ->when($request->institucion_id, function ($query, $institucion_id) {
                return $query->where('institucion_id', $institucion_id);
            })
            ->when($request->oficial_id, function ($query, $oficial_id) {
                return $query->where('oficial_id', $oficial_id);
            })
            ->get()->pluck('codigo_franquicia');

        if ($codigos->isEmpty()) {
            throw new NotFoundHttpException('No se encontraron codigos de franquicias');
        }

        return $codigos;
    }


    public function numeroSeguimiento(): mixed
    {
        return VisitaCampo::select('numero_seguimiento')
            ->distinct()->pluck('numero_seguimiento');
    }
}
