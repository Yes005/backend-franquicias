<?php

namespace App\Services;

use App\Enum\EstadoFranquiciaEnum;
use App\Http\Requests\v1\ClasificacionObservacionRequest;
use App\Http\Requests\Request;
use App\Http\Requests\v1\ClasificacionRequest;
use App\Models\Catalogos\CtlClasificacion;
use App\Models\Franquicia;
use App\Models\MntClasificacionDocumentos;
use App\Models\MntClasificacionFranquicia;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClasificacionService
{
    public function getClasificaciones($id)
    {
        // Obtener todas las clasificaciones con los campos requeridos
        $clasificaciones = CtlClasificacion::select('id', 'nombre', 'puntaje_maximo')->get();
        $franquicia = Franquicia::select('id', 'estado', 'institucion_id', 'oficial_id')->where('id', $id)->first();

        if (!$franquicia) {
            return response()->json(['message' => 'No se encontró la franquicia'], 404);
        }

        $estadoAprobada = EstadoFranquiciaEnum::getEstadoId('Aprobada');
        $estadoFirmada = EstadoFranquiciaEnum::getEstadoId('Firmada');

        if ($franquicia->estado !== $estadoAprobada && $franquicia->estado !== $estadoFirmada) {
            return response()->json(['message' => 'La franquicia no ha sido aprobada o firmada'], 403);
        }

        // Obtener las clasificaciones específicas de la franquicia
        $clasificacionFranquicia = MntClasificacionFranquicia::with([
            'clasificacion' => function ($query) {
                $query->select('id', 'nombre', 'puntaje_maximo');
            }
        ])
            ->select('clasificacion_id', 'franquicia_id', 'puntaje')
        ->select('clasificacion_id', 'franquicia_id', 'puntaje')
            ->where('franquicia_id', $id)
            ->get(); // Obtener todas las clasificaciones de la franquicia

        $data = collect();
        $score = MntClasificacionFranquicia::where('franquicia_id', $id)->exists();

        // Manejar clasificaciones sin puntaje asignado
        $clasificaciones->each(function ($clasificacion) use (
            $clasificacionFranquicia,
            $data,

        ) {
            $existingClasificacion = $clasificacionFranquicia->where('clasificacion_id', $clasificacion->id)->first();

            // Si la clasificación no existe, agregarla con puntaje 0
            if (!$existingClasificacion) {
                $data->push([
                    'id' => $clasificacion->id,
                    'nombre' => $clasificacion->nombre,
                    'puntaje_maximo' => $clasificacion->puntaje_maximo,
                    'puntaje' => 0,

                ]);
            } else {
                // Si existe, devolver la clasificación con su puntaje
                $data->push([
                    'id' => $existingClasificacion->clasificacion_id,
                    'nombre' => $existingClasificacion->clasificacion->nombre,
                    'puntaje_maximo' => $existingClasificacion->clasificacion->puntaje_maximo,
                    'puntaje' => $existingClasificacion->puntaje,

                ]);
            }
        });

        return response()->json([
            "clasificaciones" => $data,
            'franquicia_id' => $id,
            'entidad' => $franquicia->institucion->nombre ?? $franquicia->oficial->nombre,
            "has_score" => $score,

        ], 200);
    }


    public function guardarPuntaje(ClasificacionRequest $request)
    {
        $request->validated();
        $user = Auth::user();
        if (!$user)
            throw new AuthorizationException('Debes estar autenticado para realizar esta acción');

        $franquicia = Franquicia::select('id', 'estado')->where('id', $request->input('franquicia_id'))->first();

        $estadoAprobada = EstadoFranquiciaEnum::getEstadoId('Aprobada');
        $estadoFirmada = EstadoFranquiciaEnum::getEstadoId('Firmada');

        if ($franquicia->estado !== $estadoAprobada && $franquicia->estado !== $estadoFirmada) {
            return response()->json(['message' => 'La franquicia no ha sido aprobada o firmada'], 403);
        }

        DB::beginTransaction();
        $update = false;
        try {
            foreach ($request->input('clasificaciones') as $clasificacion) {

                $data = MntClasificacionFranquicia::updateOrCreate(
                    [
                        'franquicia_id' => $request->input('franquicia_id'),
                        'clasificacion_id' => $clasificacion['clasificacion_id'],

                    ],
                    [
                        'puntaje' => $clasificacion['puntaje'],
                        'updated_at' => Carbon::now(),

                    ]
                );

                if ($data->wasRecentlyCreated) {
                    $update = false;
                } else {
                    $update = true;
                }
            }

            DB::commit();

            $msgUpdated = response()->json(['message' => 'Puntaje actualizado con éxito'], 200);
            $msgCreated = response()->json(['message' => 'Puntaje guardado con éxito'], 201);
            return $update ? $msgUpdated : $msgCreated;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al guardar los puntajes', 'error' => $e->getMessage()], 500);
        }
    }

    public function guardarObservacion(ClasificacionObservacionRequest $request)
    {

        $user = Auth::user();
        if (!$user) {
            throw new AuthorizationException('Debes estar autenticado para realizar esta acción');
        }

        $franquicia = Franquicia::select('id', 'estado')->where('id', $request->input('franquicia_id'))->first();

        $estadoAprobada = EstadoFranquiciaEnum::getEstadoId('Aprobada');
        $estadoFirmada = EstadoFranquiciaEnum::getEstadoId('Firmada');

        if ($franquicia->estado !== $estadoAprobada && $franquicia->estado !== $estadoFirmada) {
            return response()->json(['message' => 'La franquicia no ha sido aprobada o firmada'], 403);
        }

        DB::beginTransaction();
        try {
            $observacionesCount = MntClasificacionDocumentos::where('franquicia_id', $franquicia->id)
                ->get()
                ->count();

            if ($request->hasFile('archivo')) {
                $nextFileNumber = $observacionesCount + 1;
                $extension = $request->file('archivo')->getClientOriginalExtension();
                $isImage = in_array(strtolower($extension), ['png', 'jpeg', 'jpg']);
                $isPdf = strtolower($extension) === 'pdf';

                if ($isImage) {
                    $fileName = 'imagen-obs-' . $nextFileNumber . '.' . $extension;
                } elseif ($isPdf) {
                    $fileName = 'documento-obs-' . $nextFileNumber . '.' . $extension;
                }

                $path = $request->file('archivo')->storeAs('observaciones', $fileName, 'public');
            }

            $data = MntClasificacionDocumentos::create([
                'franquicia_id' => $request->input('franquicia_id'),
                'comentario' => $request->input('comentario'),
                'archivo' => $fileName ?? null,
                'usuario_creador_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Observacion guardada con éxito',
                'observacion' =>
                [
                    'id' => $data->id,
                    'comentario' => $data->comentario,
                    'archivo' => $fileName ?? null
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al guardar la observación', 'error' => $e->getMessage()], 500);
        }
    }

    public function VerObservaciones($franquicia_id)
    {
        try {
            if (!$franquicia_id || !is_numeric($franquicia_id)) {
                return response()->json([
                    'message' => 'El franquicia_id proporcionado no es válido'
                ], 400);
            }

            $observaciones = MntClasificacionDocumentos::select('id', 'comentario', 'archivo')
            ->where('franquicia_id', $franquicia_id)
                ->orderBy('created_at', 'desc')
                ->get();

            $observacionesArchivo = $observaciones->map(function ($observacion) {
                $nombreArchivo = pathinfo($observacion->archivo, PATHINFO_FILENAME);

                return [
                    'id' => $observacion->id,
                    'comentario' => $observacion->comentario,
                    'archivo' => $nombreArchivo ? $nombreArchivo : null
                ];
            });

            return response()->json([
                'message' => 'Observaciones obtenidas con éxito',
                'observaciones' => $observacionesArchivo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener las observaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verArchivoObservacion($id)
    {

        try {

            $observacion = MntClasificacionDocumentos::select('archivo')
                ->where('id', $id)
                ->first();

            if (!$observacion) {
                return response()->json(['message' => 'No se encontró la observación'], 404);
            }

            $filePath = storage_path('app/public/observaciones/' . $observacion->archivo);

            if (!file_exists($filePath)) {
                return response()->json(['message' => 'Archivo no encontrado'], 404);
            }

            if ($observacion->archivo == null) {
                return response()->json(['message' => 'No se encontró el archivo en la observación'], 404);
            }

            $fileContent = file_get_contents($filePath);
            $base64Content = base64_encode($fileContent);
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'pdf'];
            if (!in_array($extension, $extensionesPermitidas)) {
                $extension = 'unknown';
            }

            return response()->json([
                'filename' => basename($filePath),
                'extension' => $extension,
                'content_file' => $base64Content
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener el archivo de la observación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteObservacion($id)
    {
        try {
            
            $observacion = MntClasificacionDocumentos::find($id);

            if (!$observacion) {
                return response()->json(['message' => 'No se encontró la observación'], 404);
            }

            $filePath = 'public/observaciones/' . $observacion->archivo;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            } else {
                return response()->json(['message' => 'El archivo asociado no fue encontrado en el almacenamiento'], 404);
            }
            
            $observacion->delete();

            return response()->json(['message' => 'Observación eliminada con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al eliminar la observación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAverageEntidad($id)
    {

        $franquicia = Franquicia::select('id', 'estado', 'institucion_id', 'oficial_id')->where('id', $id)->first();

        if (!$franquicia) {
            return response()->json(['message' => 'No se encontró la franquicia'], 404);
        }

        $estadoRevision = EstadoFranquiciaEnum::getEstadoId('Revisión');
        $estadoSolventada = EstadoFranquiciaEnum::getEstadoId('Solventada');

        if ($franquicia->estado !== $estadoRevision && $franquicia->estado !== $estadoSolventada) {
            return response()->json(['message' => 'La franquicia no está en estado de revisión o solventada'], 403);
        }

        if ($franquicia->institucion_id) {
            $entidadId = $franquicia->institucion_id;
            $columna = 'institucion_id';
        } elseif ($franquicia->oficial_id) {
            $entidadId = $franquicia->oficial_id;
            $columna = 'oficial_id';
        }

        $franquiciasEntidad = Franquicia::select('id')
            ->where($columna, $entidadId)
            ->whereIn('estado', [EstadoFranquiciaEnum::getEstadoId('Aprobada'), EstadoFranquiciaEnum::getEstadoId('Firmada')])
            ->get()
            ->pluck('id');

        $clasificaciones = CtlClasificacion::all();

        $clasificacionesFranquicia = MntClasificacionFranquicia::whereIn('franquicia_id', $franquiciasEntidad)
            ->select('clasificacion_id', DB::raw('AVG(puntaje) as promedio_puntaje'))
            ->groupBy('clasificacion_id')
            ->get()
            ->keyBy('clasificacion_id');

        $data = collect();

        foreach ($clasificaciones as $clasificacion) {
            if (isset($clasificacionesFranquicia[$clasificacion->id])) {
                $promedioPuntaje = round($clasificacionesFranquicia[$clasificacion->id]->promedio_puntaje);
            } else {
                $promedioPuntaje = 0;
            }

            $data->push([
                'id' => $clasificacion->id,
                'nombre' => $clasificacion->nombre,
                'puntaje_maximo' => $clasificacion->puntaje_maximo,
                'puntaje' => $promedioPuntaje,

            ]);
        }

        return response()->json([
            'clasificaciones' => $data,
            'entidad' => $franquicia->institucion->nombre ?? $franquicia->oficial->nombre,

        ], 200);
    }

    public function getAverageEntidades(Request $request)
    {
        $clasificaciones = CtlClasificacion::all();
        $estadoFirmada = EstadoFranquiciaEnum::getEstadoId('Firmada');

        $franquiciasAgrupadas = Franquicia::select('institucion_id', 'oficial_id', DB::raw('COUNT(id) as cantidad_franquicias'))
        ->where('estado', $estadoFirmada)
            ->when(isset($request->tipo_entidad), function ($query) use ($request) {
                $query->withWhereHas('tipos', function ($query) use ($request) {
                    $query->where('id', $request->tipo_entidad);
                });
            })
            ->when(isset($request->buscar), function ($query) use ($request) {
                $query->search($request->buscar, ['nombre'], ['institucion', 'oficial']);
            })
            ->groupBy('institucion_id', 'oficial_id')
            ->paginateData($request);

        $total = $franquiciasAgrupadas['total'];
        $franquciasList = $franquiciasAgrupadas['data'];
        $data = collect();

        foreach ($franquciasList as $entidad) {
            $entidadId = $entidad->institucion_id ?: $entidad->oficial_id;
            $columna = $entidad->institucion_id ? 'institucion_id' : 'oficial_id';

            $franquiciasEntidad = Franquicia::select('id')
                ->where($columna, $entidadId)
                ->whereIn('estado', [EstadoFranquiciaEnum::getEstadoId('Firmada')])
                ->get()
                ->pluck('id');

            $clasificacionesFranquicia = MntClasificacionFranquicia::whereIn('franquicia_id', $franquiciasEntidad)
                ->select('clasificacion_id', DB::raw('AVG(puntaje) as promedio_puntaje'))
                ->groupBy('clasificacion_id')
                ->get()
                ->keyBy('clasificacion_id');

            $clasificacionesData = collect();

            foreach ($clasificaciones as $clasificacion) {
                $promedioPuntaje = isset($clasificacionesFranquicia[$clasificacion->id])
                    ? (float) round($clasificacionesFranquicia[$clasificacion->id]->promedio_puntaje, 1) : 0;

                $promedioPuntaje = number_format($promedioPuntaje, 1);

                $clasificacionesData->push([
                    'id' => $clasificacion->id,
                    'nombre' => $clasificacion->nombre,
                    'promedio_puntaje' => $promedioPuntaje,

                ]);
            }

            $calificacionPromedio = (float) round($clasificacionesData->avg('promedio_puntaje'), 1);
            $calificacionPromedio = number_format($calificacionPromedio, 1);

            $data->push([
                'id' => $entidadId,
                'entidad' => $entidad->institucion_id ? $entidad->institucion->nombre : $entidad->oficial->nombre,
                'cantidad_franquicias' => $entidad->cantidad_franquicias,
                'clasificaciones' => $clasificacionesData,
                'calificacion' => $calificacionPromedio,
                
            ]);
        }

        return ['data' => ['entidades' => $data], 'total' => $total];
    }

    public function listarClasificaciones(Request $request)

    {
        $data = CtlClasificacion::select('id', 'nombre', 'puntaje_maximo')
        ->orderBy('id', 'desc')
        ->when(isset($request->nombre), function ($query) use ($request) {
            $query->search($request->nombre, ['nombre'], []);
        })
            ->paginateData($request);

        return $data;
    }
}
