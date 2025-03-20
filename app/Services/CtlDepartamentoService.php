<?php

namespace App\Services;

use App\Models\Catalogos\CtlDepartamento;

class CtlDepartamentoService {
    /**
     * Obtiene el listado de departamentos
     * @return array
     */

     public function getDepartamentos(){
        $data = CtlDepartamento::select('id','nombre')->orderBy('nombre','asc')->get();

        return $data;
     }
}