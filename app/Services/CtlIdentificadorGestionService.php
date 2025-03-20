<?php

namespace App\Services;

use App\Enum\EstadosEnum;
use App\Models\Catalogos\CtlIdentificadorGestion;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Http\Requests\v1\CtlIdentificadorGestionRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlIdentificadorGestionService
{
    public function ListarGestiones(Request $request)
    {
        $data = CtlIdentificadorGestion::select('id', 'codigo', 'creador', 'editor', 'fecha_creacion','fecha_edicion', 'activo')->orderBy('id','desc')
        ->when(isset($request->nombre), function ($query)use ($request){
            $query->search($request->nombre,['codigo','creador','editor'],[]);
        })
        ->when(isset($request->activo) && ($request->activo != EstadosEnum::ALL->value), function($query) use ($request){
            $query->search($request->activo == EstadosEnum::ACTIVE->value ? 1 : 0, ['activo'], []);
        })
        ->paginateData($request);
        return $data;
    }

    public function createIdentificador(CtlIdentificadorGestionRequest $request)
    {
        $request->validate(["codigo" => 'unique:franquicias_identificadorgestion,codigo']);
        $user = Auth::user();
        $pastIdentificador = CtlIdentificadorGestion::where('activo', true)->first();
        return DB::transaction(function () use ($request, $user, $pastIdentificador){
            $indicador = CtlIdentificadorGestion::create($request->validated() + [
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
                'activo' => true
            ]);
            if($pastIdentificador){
                $pastIdentificador->activo = false;
                $pastIdentificador->save();
            }
            return ['message'=>'Identificador de gestión creado con éxito'];
        });
    }

    public function editIdentificador(CtlIdentificadorGestionRequest $request, $id)
    {
        $identificador = CtlIdentificadorGestion::find($id);
        if(!$identificador)
            throw new NotFoundHttpException('No se encontró el identificador de gestión');
       $data = $request->validate(["codigo" => Rule::unique('franquicias_identificadorgestion', 'codigo')->ignore($id)]);
        $user = Auth::user();
        return DB::transaction(function () use ($data, $user, $identificador){
            $identificador->update($data + [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
            ]);
            return ['message'=>'Identificador de gestión editado con éxito'];
        });
    }
}
