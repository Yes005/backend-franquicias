<?php

namespace App\Services;

use App\Enum\EstadosEnum;
use App\Http\Requests\Request as Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Models\Catalogos\CtlAduana;
use App\Models\User;
use App\Traits\Search;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlAduanaService
{
    /**
    * obtener la lista de aduanas
    * @return array
    */
    public function ListarAduanas(Request $request)
    {
        $data = CtlAduana::select('id', 'nombre', 'creador', 'editor', 'fecha_creacion','fecha_edicion', 'activo')
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
    * Crear una nueva aduana
    * @return array
    */
    public function createAduana(CatalogoRequest $request)
    {
        $user = Auth::user();
        $request->validate(['nombre' => 'min:4|max:150|unique:franquicias_aduana,nombre']);
        return DB::transaction(function () use ($request, $user){
            $aduana = CtlAduana::create($request->validated() + [
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
                'activo' => true
            ]);
            return [
                'message' => 'Aduana creada con éxito',
            ];
        });
    }

    public function editAduana(CatalogoRequest $request,$id)
    {
        $aduana = CtlAduana::find($id);
        if(!$aduana)
            throw new NotFoundHttpException('No se encontró la aduana');
        $data = $request->validate(["nombre" => ['min:4','max:150', Rule::unique('franquicias_aduana', 'nombre')->ignore($id)]]);
        $user = Auth::user();
        return DB::transaction(function () use ($data, $user, $aduana){
            $aduana->update($data + [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
            ]);

            return ['message' => 'Aduana editada con éxito'];
        });
    }

    public function changeStateAduana($id)
    {
        $aduana = CtlAduana::find($id);
        if (!$aduana) {
            throw new NotFoundHttpException('No se encontró la aduana');
        }
        $user = Auth::user();
        return DB::transaction(function () use ($user,$aduana) {
            $aduana->activo = !$aduana->activo; // Cambiar el estado de activo
            $aduana->editor = $user->name;
            $aduana->fecha_edicion = Carbon::now();
            $aduana->save(); // Guardar los cambios
            return [
                'message' => 'Estado de aduana actualizado con éxito',
            ];
        });
    }

}
