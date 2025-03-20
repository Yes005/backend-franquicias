<?php

namespace App\Utils;

use App\Models\Catalogos\CtlCodigoProvisional;
use App\Models\Catalogos\CtlCorrelativo;
use App\Models\Catalogos\CtlIdentificadorGestion;
use Carbon\Carbon;

class CorrelativoUtils
{
    public static function getProvisional(){
        $annio = Carbon::now()->year;

        $correlativo = CtlCodigoProvisional::where('annio', $annio)->first();

        if (!$correlativo){
            $correlativo = CtlCodigoProvisional::create([
                'annio' => $annio,
                'correlativo' => 1
            ]);

            $nuevo_correlativo = $correlativo->correlativo;

        }else{
            $nuevo_correlativo = $correlativo->correlativo += 1;
            $correlativo->update(['correlativo' => $nuevo_correlativo]);
        }

        $codigo_provisional = "PROV-" . $annio . "-" . str_pad($nuevo_correlativo, 3, "0", STR_PAD_LEFT);

        return $codigo_provisional;

    }

    public static function getDefinitivo($codigo_colaborador){

        $annio = Carbon::now()->year;

        $identificador = CtlIdentificadorGestion::where('activo', true)->first();

        
        $correlativo = CtlCorrelativo::where('annio',$annio)->where('activo', true)->first();


        if (!$correlativo){
            $correlativo_nuevo = CtlCorrelativo::create([
                'annio' => $annio,
                'correlativo' => 1,
                'activo' => true
            ]);

            $correlativo_definitivo = $correlativo_nuevo->correlativo;


        }else{
            $correlativo->correlativo += 1;
            $correlativo->save();

            $correlativo_definitivo = $correlativo->correlativo;
        }

        $codigo_colaborador = str_pad($codigo_colaborador, 3, "0", STR_PAD_LEFT);

        $codigo_definitvo = $annio . "-" . $codigo_colaborador . "-" . $identificador->codigo . "-" . str_pad($correlativo_definitivo, 3, "0", STR_PAD_LEFT) ;

        return $codigo_definitvo;
    }

    
}