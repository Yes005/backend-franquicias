<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Models\Catalogos\CtlMunicipio;

class CtlMunicipioService {
    /**
     * Obtiene el listado de municipios
     * @return array
     */

     public function getMunicipios(Request $request){
        $data = CtlMunicipio::select('id','nombre','id_departamento')
        ->when(isset($request->id_departamento), function ($query) use ($request){
            $query->where('id_departamento', $request->id_departamento);
        })
        ->orderBy('nombre','asc')
        ->get();

        return $data;
     }
}
