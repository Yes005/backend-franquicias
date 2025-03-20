<?php

namespace App\Http\Controllers\Franquicias;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ClasificacionObservacionRequest;
use App\Http\Requests\v1\ClasificacionRequest;
use App\Services\ClasificacionService;
use App\Http\Requests\Request;

class ClasificacionController extends Controller
{
    protected $ClasificacionService;

    public function __construct(ClasificacionService $ClasificacionService)
    {
        $this->ClasificacionService = $ClasificacionService;
    }

    public function getClasificaciones($id){
        $clasificaciones = $this->ClasificacionService->getClasificaciones($id);
        return $clasificaciones;
    }

    public function guardarPuntaje(ClasificacionRequest $request){
        $puntaje = $this->ClasificacionService->guardarPuntaje($request);
        return $puntaje;
    }

    public function guardarObservacion(ClasificacionObservacionRequest $request){
        $observacion = $this->ClasificacionService->guardarObservacion($request);
        return $observacion;
    }

    public function verObservaciones($franquicia_id){
        $observaciones = $this->ClasificacionService->VerObservaciones($franquicia_id);
        return $observaciones;
    }

    public function verArchivoObservacion($id){
        $archivo = $this->ClasificacionService->verArchivoObservacion($id);
        return $archivo;
    }

    public function deleteObservacion($id){
        $archivo = $this->ClasificacionService->deleteObservacion($id);
        return $archivo;
    }
    
    public function getAverageEntidad($id){
        $average = $this->ClasificacionService->getAverageEntidad($id);
        return $average;
    }

    public function getAverageEntidades(Request $request){
        $average = $this->ClasificacionService->getAverageEntidades($request);
        return response($average['data'])->header('total_rows',$average['total']);
    }

    public function listarClasificaciones(Request $request){
        $clasificaciones = $this->ClasificacionService->listarClasificaciones($request);
        return response($clasificaciones['data'])->header('total_rows',$clasificaciones['total']);
    }
    
}
