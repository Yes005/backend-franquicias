<?php

namespace App\Services;

use App\Enum\EstadosEnum;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Models\Catalogos\CtlOficial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlOficialService{

    /**
     * Obtener listado de oficiales
     * @return array
     */

    public function getOficiales(Request $request){
        $data = CtlOficial::select('id','nombre','creador','editor','fecha_creacion','fecha_edicion','activo')
        ->orderBy('id','desc')
        ->when(isset($request->nombre), function ($query)use ($request){
            $query->search($request->nombre,['nombre','creador','editor'],[]);
        })
        ->when(isset($request->activo) && ($request->activo != EstadosEnum::ALL->value), function($query) use ($request){
            $query->search($request->activo == EstadosEnum::ACTIVE->value ? 1 : 0, ['activo'], []);
        })
        ->paginateData($request);

        return $data;
    }

    /**
     * Crear oficial
     * @return array
     */

    public function createOficial(CatalogoRequest $request){
        $user = Auth::user();
        $request->validate(["nombre" => [Rule::unique('franquicias_oficial', 'nombre'), 'min:4','max:150']]);
        return DB::transaction(function () use ($request, $user) {
            $oficial = CtlOficial::create($request->validated() +[
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
                'activo' => true
            ]);
            return [
                'message' => 'Oficial creado con éxito',
            ];
        });
    }

    public function editOficial(CatalogoRequest $request, $id){
        $oficial = CtlOficial::find($id);
        if (!$oficial){
            throw new NotFoundHttpException('No se encontró oficial');
        }
        $request->validate(["nombre" => [Rule::unique('franquicias_oficial', 'nombre')->ignore($id), 'min:4','max:150']]);
        $user = Auth::user();
        return DB::transaction(function () use ($request, $user, $oficial) {
            $oficial->update($request->validated() + [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now()
            ]);
            return ['message' => 'Oficial editado con éxito'];

        });

    }

    public function changeStateOficial($id){
        $oficial = CtlOficial::find($id);

        if (!$oficial){
            throw new NotFoundHttpException('No se encontró oficial');
        }

        $user = Auth::user();

        return DB::transaction(function () use ($oficial, $user) {
            $oficial->activo = !$oficial->activo;
            $oficial->editor = $user->name;
            $oficial->fecha_edicion = Carbon::now();
            $oficial->save();
            return [
                'message' => 'Estado de oficial actualizado con éxito',
            ];
        });

    }
}
