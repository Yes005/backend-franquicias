<?php

namespace App\Services;

use App\Enum\EstadosEnum;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Models\Catalogos\CtlClases;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlClaseService
{
    public function ListarClases(Request $request)
    {
        $data = CtlClases::select('id', 'nombre', 'creador', 'editor', 'fecha_creacion','fecha_edicion', 'activo')->orderBy('id','desc')
        ->when(isset($request->nombre), function ($query)use ($request){
            $query->search($request->nombre,['nombre','creador','editor'],[]);
        })
        ->when(isset($request->activo) && ($request->activo != EstadosEnum::ALL->value), function($query) use ($request){
            $query->search($request->activo == EstadosEnum::ACTIVE->value ? 1 : 0, ['activo'], []);
        })
        ->paginateData($request);
        return $data;
    }

    public function createClase(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:4|max:100|unique:franquicias_clase,nombre'
        ],[
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser un texto',
            'min' => 'El campo :attribute debe tener al menos :min caracteres',
            'max' => 'El campo :attribute no puede tener más de :max caracteres',
            'unique' => 'El campo :attribute ya existe',
        ]);

        $user = Auth::user();
        return DB::transaction(function () use ($request, $user){
            $clase = CtlClases::create([
                "nombre" => $request->nombre,
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
                'activo' => true
            ]);

            return ['message' => 'Clase creada con éxito'];
        });
    }

    public function editClase(Request $request,$id)
    {
        $clase = CtlClases::find($id);
        if(!$clase)
            throw new NotFoundHttpException('No se encontró la clase');
        $data = $request->validate(["nombre" => Rule::unique('franquicias_clase', 'nombre')->ignore($id)]);
        $user = Auth::user();
        return DB::transaction(function () use ($data, $user, $clase){
            $clase->update($data + [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
            ]);
            return ['message' => 'Clase editada con éxito'];
        });
    }


    public function changeStateClase($id)
    {
        $clase =  CtlClases::find($id);
        if (!$clase) {
            throw new NotFoundHttpException('No se encontró la clase');
        }
        $user = Auth::user();
        return DB::transaction(function () use ($user,$clase) {
            $clase->activo = !$clase->activo; // Cambiar el estado de activo
            $clase->editor = $user->name;
            $clase->fecha_edicion = Carbon::now();
            $clase->save(); // Guardar los cambios
            return [
                'message' => 'Estado de clase actualizado con éxito',
            ];
        });
    }
}
