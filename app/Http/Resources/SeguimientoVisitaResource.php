<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeguimientoVisitaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource?->franquicia?->entidad?->id,
            'entidad_id' => $this->resource?->franquicia?->id,
            'codigo_franquicia' => $this->resource?->codigo_franquicia,
            'numero_seguimiento' => $this->resource?->numero_seguimiento,
            'entidad' => $this->resource?->franquicia?->entidad?->nombre,
        ];
    }
}
