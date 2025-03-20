<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Models\Catalogos\CtlDistrito;

class CtlDistritoService {
    /**
     * Obtiene el listado de distritos
     * @return array
     */

     public function getDistritos(Request $request){
        $data = CtlDistrito::select('id','nombre','id_municipio')
        ->when(isset($request->id_municipio), function ($query) use ($request){
            $query->where('id_municipio', $request->id_municipio);
        })
        ->orderBy('nombre','asc')
        ->get();

        return $data;
     }
}
