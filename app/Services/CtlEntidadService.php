<?php

namespace App\Services;

use App\Enum\EstadosEnum;
use App\Http\Requests\Request;
use App\Models\Catalogos\CtlEntidad;

class CtlEntidadService{
    /**
     * Obtiene el listado de entidades
     * @return array
     */

     public function getEntidades(Request $request){
        $data = CtlEntidad::select('id','nombre','activo')->orderBy('id','asc')
        ->when(isset($request->activo) && ($request->activo != EstadosEnum::ALL->value), function($query) use ($request){
            $query->search($request->activo == EstadosEnum::ACTIVE->value ? 1 : 0, ['activo'], []);
        })->get();

        return $data;
     }
}