<?php

namespace App\Services;

use App\Enum\EstadoFranquiciaEnum;
use App\Models\Catalogos\CtlEstado;

class CtlEstadoService {
    /**
     * Obtiene el listado de estados
     * @return array
     */

     public function getEstados(){
        $data = CtlEstado::select('id','nombre','activo')
            ->where('activo', true)
            ->where('id','!=',EstadoFranquiciaEnum::FINALIZADO)
            ->orderBy('id','asc')->get();

        return $data;
     }
}