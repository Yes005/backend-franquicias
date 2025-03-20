<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Utils;
use App\Enum\DocumentEnum;

class ReporteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $codigo = $this->resource?->estados?->nombre === 'Revisión' ?
            $this->resource->codigo_provisional : $this->resource->codigo_franquicia;

        if ($request->has('dia')) {
            return [
                'codigo_solicitud' => $codigo,
                'cantidad_bultos' => $this->resource->bultos,
                'contenido' => $this->resource->comentario,
                'documentos_transporte' => Utils::documentos($this->resource),
                'nombre_solicitante' => $this->resource?->institucion?->nombre ??
                $this->resource?->oficial?->nombre,


            ];
        }
        return [
            'codigo_solicitud' => $codigo,
            'nombre_solicitante' => $this->resource?->institucion?->nombre ??
                $this->resource?->oficial?->nombre,
            'contenido' => $this->resource->comentario,
            'estado' => (isset($this->resource->fecha_despacho)) ? 'Entregada' : 'Pendiente',
            'fecha_ingreso' => $this->resource->fecha,
            'fecha_despacho' => $this->resource->fecha_despacho,
        ];
    }
}
