<?php

namespace App\Services;

use App\Enum\EstadosEnum;
use App\Http\Requests\Request;
use App\Models\Catalogos\CtlInstitucion;
use App\Http\Requests\v1\CtlInstitucionRequest;
use App\Http\Requests\v1\CtlFacturaRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlInstitucionService{

    /**
     * Obtener listado de instituciones
     * @return array
     */

     public function getInstituciones(Request $request){
        $data = CtlInstitucion::select('id','nombre', 'creador', 'editor','representante_legal','fecha_inicio_junta_directiva','fecha_fin_junta_directiva','fecha_creacion','fecha_edicion','activo')
        ->when(isset($request->nombre), function ($query)use ($request){
            $query->search($request->nombre,['nombre','creador','editor'],[]);
        })
        ->when(isset($request->activo) && ($request->activo != EstadosEnum::ALL->value), function($query) use ($request){
            $query->search($request->activo == EstadosEnum::ACTIVE->value ? 1 : 0, ['activo'], []);
        })
        /* ->orderBy('fecha_edicion','desc') */
        ->orderBy('id','desc')
        ->paginateData($request);
        return $data;
     }

     public function createInstitucion(CtlInstitucionRequest $request){
         $user = Auth::user();
        $request->validate(["nombre" => Rule::unique('franquicias_institucion', 'nombre')]);

         return DB::transaction(function () use ($request, $user) {
            $institucion = CtlInstitucion::create($request->validated() + [
               'creador' => $user->name,
               'editor' => $user->name,
               'fecha_creacion' => Carbon::now(),
               'fecha_edicion' => Carbon::now(),
               'activo' => true
            ]);
            return ['message' => 'Institución creada con éxito'];
         });
     }

     public function editInstitucion(CtlInstitucionRequest $request, $id){
         $user = Auth::user();
         $institucion = CtlInstitucion::find($id);
         if (!$institucion){
            throw new NotFoundHttpException('No se encontró la institución');
        }
        $request->validate(["nombre" => Rule::unique('franquicias_institucion', 'nombre')->ignore($id)]);

         return DB::transaction(function () use ($request, $user, $institucion){
            $institucion->update($request->validated() +[
               'editor' => $user->name,
               'fecha_edicion' => Carbon::now()
            ]);
            return ['message' => 'Institución actualizada con éxito'];
         });
     }

     public function changeStateInstitucion($id){
         $user = Auth::user();
         $institucion = CtlInstitucion::find($id);
         if (!$institucion){
            throw new NotFoundHttpException('No se encontró la institución');
         }
         return DB::transaction(function () use($institucion, $user) {
             $institucion->activo = !$institucion->activo;
             $institucion->editor = $user->name;
             $institucion->fecha_edicion = Carbon::now();
             $institucion->save();
             return ['message' => 'Estado de la institución cambiado con éxito'];
         });
     }

}


