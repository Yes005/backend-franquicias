<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Requests\v1\CtlFirmanteRequest;
use App\Models\Catalogos\CtlFirmante ;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CtlFirmanteService{
    /**
     * Obtiene el listado de firmantes de la franquicia
     * @return array
     */

    public function getFirmantes(Request $request){
        $data = CtlFirmante::select('id','firma','cargo','acuerdo_ejecutivo','fecha_inicio_validez','fecha_fin_validez')
        ->orderBy('fecha_inicio_validez','desc')
        ->search($request->search,['firma','cargo','acuerdo_ejecutivo'],[])
        ->paginateData($request);

        return $data;

    }

    public function createFirmante(CtlFirmanteRequest $request){
        $user = Auth::user();

        $this->validateDateRange($request->fecha_inicio_validez, $request->fecha_fin_validez);

        return DB::transaction(function () use ($request, $user) {
            $firmante = CtlFirmante::create($request->validated() + [
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
            ]);

            return ['message' => 'Firmante creado con éxito'];

        });
    }

    public function editFirmante(CtlFirmanteRequest $request, $id){

        $user = Auth::user();

        $this->validateDateRange($request->fecha_inicio_validez, $request->fecha_fin_validez, $id);

        $firmante = CtlFirmante::find($id);

        if(!$firmante)
            throw new NotFoundHttpException('No se encontró el firmante');

        return DB::transaction(function () use ($request, $firmante, $user){
            $firmante->update($request->validated() + [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now()
            ]);

            return ['message' => 'Firmante actualizado con éxito'];

        });
    }

    private function validateDateRange($fechaInicio, $fechaFin, $ignoreId = null)
    {
        $firmaFin = CtlFirmante::where('fecha_fin_validez', '=', $fechaInicio);
        if ($ignoreId) {
            $firmaFin->where('id', '!=', $ignoreId);
        }
        if ($firmaFin->exists()) {
            throw new HttpResponseException(response()->json([
                'message' => 'La fecha de inicio de validez coincide con la fecha fin de validez de otro registro',
            ], 422));
        }

        $firmaInicio = CtlFirmante::where('fecha_inicio_validez', '=', $fechaFin);
        if ($ignoreId) {
            $firmaInicio->where('id', '!=', $ignoreId);
        }
        if ($firmaInicio->exists()) {
            throw new HttpResponseException(response()->json([
                'message' => 'La fecha de fin de validez coincide con la fecha inicio de validez de otro registro',
            ], 422));
        }

        $query = CtlFirmante::where(function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha_inicio_validez', [$fechaInicio, $fechaFin])
                ->orWhereBetween('fecha_fin_validez', [$fechaInicio, $fechaFin])
                ->orWhere(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->where('fecha_inicio_validez', '<=', $fechaInicio)
                        ->where('fecha_fin_validez', '>=', $fechaFin);
                });
        });

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $existing = $query->first();

        if ($existing) {
            throw new HttpResponseException(response()->json([
                'message' => 'Un firmante ya ha sido designado para el periodo establecido',
            ], 422));
        }
    }
}