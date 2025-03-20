<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitaCampoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource->only([
            'id',
            'numero_seguimiento',
            'correlativo',
            'fecha_visita',
            'codigo_franquicia',
            'estado',
        ]) + [
            'entidad' => $this->resource->franquicia->entidad
        ];
    }
}
