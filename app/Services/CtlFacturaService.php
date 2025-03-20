<?php

namespace App\Services;

use App\Enum\EstadosEnum;
use App\Http\Requests\Request;
use App\Http\Requests\v1\CatalogoRequest;
use App\Http\Requests\v1\CtlFacturaRequest;
use App\Models\Catalogos\CtlFactura;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlFacturaService
{
    public function ListarFacturas(Request $request)
    {
        $data = CtlFactura::select('id', 'nombre', 'creador','editor','fecha_creacion','fecha_edicion', 'activo', 'mostrar_no_factura')->orderBy('id','desc')
        ->when(isset($request->nombre), function ($query)use ($request){
            $query->search($request->nombre,['nombre','creador','editor'],[]);
        })
        ->when(isset($request->activo) && ($request->activo != EstadosEnum::ALL->value), function($query) use ($request){
            $query->search($request->activo == EstadosEnum::ACTIVE->value ? 1 : 0, ['activo'], []);
        })
        ->paginateData($request);
        return $data;
    }

    public function createFactura(CtlFacturaRequest $request)
    {
        $request->validate(["nombre" => 'unique:franquicias_facturacomercial,nombre']);
        $user = Auth::user();
        return DB::transaction(function () use ($request, $user){
            $aduana = CtlFactura::create($request->validated() +[
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
                'activo' => true
            ]);
            return ['message' => 'Tipo de franquicia creada con éxito'];
        });
    }

    public function editFactura(CtlFacturaRequest $request, $id)
    {
        $factura = CtlFactura::find($id);
        if(!$factura)
            throw new NotFoundHttpException('No se encontró el tipo de franquicia');
        $request->validate(["nombre" => Rule::unique('franquicias_facturacomercial', 'nombre')->ignore($id)]);
        $user = Auth::user();
        return DB::transaction(function () use ($request, $user, $factura){
            $factura->update($request->validated() + [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
            ]);
            return ['message' => 'Tipo de franquicia editada con éxito'];
        });
    }

    public function changeStateFactura($id)
    {
        $factura = CtlFactura::find($id);
        if(!$factura)
            throw new NotFoundHttpException('No se encontró el tipo de franquicia');
        $user = Auth::user();
        return DB::transaction(function () use ($factura, $user){
            $factura->activo = !$factura->activo;
            $factura->editor = $user->name;
            $factura->fecha_edicion = Carbon::now();
            $factura->save();
            return ['message' => 'Estado del tipo de franquica cambiado con éxito'];
        });
    }
}
