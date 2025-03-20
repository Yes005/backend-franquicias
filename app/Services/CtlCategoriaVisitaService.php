<?php

namespace App\Services;

use App\Models\Catalogos\CtlCategoriaVisita;

class CtlCategoriaVisitaService {


    public function listarAll(){

        return CtlCategoriaVisita::where('activo', 1)->get();
    }
}
