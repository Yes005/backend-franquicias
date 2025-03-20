<?php

namespace App\Services;

use App\Enum\EstadoFranquiciaEnum;
use App\Enum\RolesEnum;
use App\Enum\RoutesEmailEnum;
use App\Http\Requests\Request;
use App\Http\Requests\v1\FranquiciaFileRequest;
use App\Http\Requests\v1\FranquiciaAnulacionRequest;
use App\Http\Requests\v1\FranquiciaObservacionRequest;
use App\Http\Requests\v1\FranquiciaRequest;
use App\Jobs\EnvioCorreo;
use App\Mail\SolicitudFranquicia;
use App\Http\Requests\v1\FranquiciasActualizarFechasRequest;
use App\Mail\AnulacionFranquicia;
use App\Mail\AprobacionFranquicia;
use App\Mail\ObservacionFranquicia;
use App\Mail\ResolucionFranquicia;
use App\Models\Catalogos\CtlInstitucion;
use App\Models\Franquicia;
use App\Models\FranquiciaDocumentos;
use App\Models\User;
use App\Utils\CorrelativoUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\AES;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FranquiciaService

{

    public function createBorrador(FranquiciaRequest $request)
    {
        $user = Auth::user();

        $estado = EstadoFranquiciaEnum::getEstadoId('Borrador');


        return DB::transaction(function () use ($request, $user, $estado) {
            $codigo_provisional = CorrelativoUtils::getProvisional();
            $franquicia = Franquicia::create($request->validated() + [
                'codigo_provisional' => $codigo_provisional,
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
                'usuario_creador_id' => $user->id,
                'estado' => $estado,
            ]);



            return ['message' => 'Franquicia creada con éxito', 'franquicia_id' => $franquicia->id];
        });
    }

    public function editBorrador(FranquiciaRequest $request, $id)
    {
        $user = Auth::user();

        $franquicia = Franquicia::find($request->id);

        if (!$franquicia) {
            throw new NotFoundHttpException('No se encontró la franquicia');
        }

        return DB::transaction(function () use ($request, $franquicia, $user) {
            $franquicia->update($request->validated() +  [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
            ]);

            return ['message' => 'Franquicia actualizada con éxito'];
        });
    }

    public function getDetalleFranquicia($id)
    {
        $data = Franquicia::with([
            'tipos',
            'estados',
            'aduana',
            'clase',
            'corrector',
            'factura',
            'institucion',
            'oficial',
            'usuario_creador'
        ])->where('id', $id)->first();

        if (!$data) {
            throw new NotFoundHttpException('No se encontró la franquicia');
        }

        $hasDocumentos = FranquiciaDocumentos::where('franquicia_id', $id)->where('activo', true)->exists();

        $data = $data->toArray();
        $hasDocumentos = ['hasDocumentos' => $hasDocumentos];
        $data = array_merge($data, $hasDocumentos);

        return response()->json($data);
    }

    public function getFranquicias(Request $request)
    {

        $data = Franquicia::with(['aduana', 'institucion', 'oficial', 'estados', 'tipos'])
            ->when(isset($request->buscar), function ($query) use ($request) {
                $query->search($request->buscar, ['codigo_provisional', 'codigo_franquicia', 'nombre'], ['aduana', 'tipos', 'institucion', 'oficial']);
            })

            ->when(isset($request->guia_aerea), function ($query) use ($request) {
                $query->search($request->guia_aerea, ['no_guia_aerea'], []);
            })
            ->when(isset($request->carta_porte), function ($query) use ($request) {
                $query->search($request->carta_porte, ['carta_de_porte_no'], []);
            })
            ->when(isset($request->conocimiento_embarque), function ($query) use ($request) {
                $query->search($request->conocimiento_embarque, ['conoc_de_embarque_no'], []);
            })
            ->when(isset($request->mercaderia_no), function ($query) use ($request) {
                $query->search($request->mercaderia_no, ['inf_de_mercaderias_rec_no'], []);
            })
            ->when(isset($request->dmti), function ($query) use ($request) {
                $query->search($request->dmti, ['nota_de_pedido_no'], []);
            })
            ->when(isset($request->estado), function ($query) use ($request) {
                $query->whereHas('estados', function ($query) use ($request) {
                    $query->where('id', $request->estado);
                });
            })
            ->when(isset($request->entidad), function ($query) use ($request) {
                $query->whereHas('tipos', function ($query) use ($request) {
                    $query->where('id', $request->entidad);
                });
            })

            ->when(isset($request->aduana), function ($query) use ($request) {
                $query->whereHas('aduana', function ($query) use ($request) {
                    $query->where('id', $request->aduana);
                });
            })
            ->when(isset($request->factura), function ($query) use ($request) {
                $query->whereHas('factura', function ($query) use ($request) {
                    $query->where('id', $request->factura);
                });
            })

            ->when(isset($request->fecha_inicio) && isset($request->fecha_fin), function ($query) use ($request) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            })->orderBy('id', 'desc')

            ->paginateData($request);

        return $data;
    }

    public function createFranquicia(FranquiciaRequest $request, $id)
    {
        $user = Auth::user();
        $jefes = User::whereHas('roles', function ($query) {
            $query->where('rol_id', RolesEnum::getRolesId('Jefe'));
        })->get();

        $url = RoutesEmailEnum::VER_FRANQUICIA->getUrl(['id' => $id]);

        $estado = EstadoFranquiciaEnum::getEstadoId('Revisión');

        $franquicia = Franquicia::find($request->id);

        if (!$franquicia) {
            throw new NotFoundHttpException('No se encontró la franquicia');
        }

        foreach ($jefes as $jefe) {
            $correo = new SolicitudFranquicia($franquicia, $url, $jefe);
            EnvioCorreo::dispatch($jefe->email, $correo);
        }

        return DB::transaction(function () use ($request, $franquicia, $user, $estado) {
            $franquicia->update($request->validated() +  [
                'creador' => $user->name,
                'usuario_creador_id' => $user->id,
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
                'estado' => $estado,
            ]);

            return ['message' => 'Franquicia enviada para su aprobación'];
        });
    }

    public function sendFranquiciaObservacion(FranquiciaObservacionRequest $request, $id)
    {
        $user = Auth::user();

        $franquicia = Franquicia::find($request->id);

        $url = RoutesEmailEnum::EDITAR_FRANQUICIA->getUrl(['id' => $franquicia->id]);

        $estado = EstadoFranquiciaEnum::getEstadoId('Observada');


        if (!$franquicia) {
            throw new NotFoundHttpException('No se encontró la franquicia');
        }

        return DB::transaction(function () use ($request, $franquicia, $user, $estado, $url) {
            $franquicia->update($request->validated() +  [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
                'estado' => $estado
            ]);

            $correo = new ObservacionFranquicia($franquicia, $url);
            EnvioCorreo::dispatch($franquicia->usuario_creador->email, $correo);

            return ['message' => 'Franquicia observada con éxito'];
        });
    }

    public function createFranquiciaRevision(FranquiciaRequest $request)
    {
        $user = Auth::user();

        $jefes = User::whereHas('roles', function ($query) {
            $query->where('rol_id', RolesEnum::getRolesId('Jefe'));
        })->get();

        $estado = EstadoFranquiciaEnum::getEstadoId('Revisión');


        return DB::transaction(function () use ($request, $user, $estado, $jefes) {
            $codigo_provisional = CorrelativoUtils::getProvisional();
            $franquicia = Franquicia::create($request->validated() + [
                'codigo_provisional' => $codigo_provisional,
                'creador' => $user->name,
                'editor' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'fecha_edicion' => Carbon::now(),
                'usuario_creador_id' => $user->id,
                'estado' => $estado,
            ]);

            $url = RoutesEmailEnum::VER_FRANQUICIA->getUrl(['id' => $franquicia->id]);

            foreach ($jefes as $jefe) {
                $correo = new SolicitudFranquicia($franquicia, $url, $jefe);
                EnvioCorreo::dispatch($jefe->email, $correo);
            }

            return ['message' => 'Franquicia enviada para su aprobación', 'franquicia_id' => $franquicia->id];
        });
    }

    public function uploadFile(FranquiciaFileRequest $request)
    {
        $user = Auth::user();
        $franquicia = Franquicia::find($request->franquicia_id);

        $file = $request->file('archivo');
        $originalName = $file->getClientOriginalName();

        $filePath = $file->store('docs_temp_franquicia', 'public');

        $aes = new AES('cbc');
        $aes->setKey(env('FRANQUICIA_ENCRYPTION_KEY'));

        $iv = random_bytes(16);
        $aes->setIV($iv);

        $fileContent = file_get_contents(storage_path('app/public/' . $filePath));
        $encryptedContent = $aes->encrypt($fileContent);

        Storage::disk('public')->delete($filePath);

        $encryptedContentWithIv = $iv . $encryptedContent;

        $franquicia = Franquicia::find($request->franquicia_id);
        $filename = $franquicia->codigo_franquicia . '_' . $originalName;

        $encryptedFilePath = 'docs_franquicia/' . $filename;

        Storage::disk('public')->put($encryptedFilePath, $encryptedContentWithIv);

        return DB::transaction(function () use ($request, $user, $filename, $originalName) {
            $documentoFranquicia = FranquiciaDocumentos::create($request->only('franquicia_id') + [
                'archivo' => $filename,
                'creador' => $user->name,
                'fecha_creacion' => Carbon::now(),
                'franquicia_id' => $request->franquicia_id,
                'usuario_creador_id' => $user->id,
            ]);

            return ['message' => 'Archivo subido exitosamente'];
        });
    }

    public function getFiles($id)
    {
        $franquicia = Franquicia::find($id);

        if (!$franquicia) {
            throw new BadRequestException('No se encontró la franquicia');
        }

        $dir = 'docs_franquicia/';
        $documentos = FranquiciaDocumentos::where('franquicia_id', $id)->where('activo', true)->get();

        $aes = new AES('cbc');
        $aes->setKey(env('FRANQUICIA_ENCRYPTION_KEY'));
        $errores = [];

        $documentosActivos = $documentos->map(function ($documento) use ($dir, $aes, &$errores) {

            $filePath = $dir . $documento->archivo;

            if (!Storage::disk('public')->exists($filePath)) {
                $errores[] = 'No se encontró el archivo: ' . $filePath;
                return null;
            }

            if (pathinfo($documento->archivo, PATHINFO_EXTENSION) != 'pdf') {
                $encryptedContentWithIv = Storage::disk('public')->get($filePath);

                if (!$encryptedContentWithIv) {
                    $errores[] = 'No se encontró el contenido cifrado del documento: ' . $filePath;
                    return null;
                }

                $ivLength = 16;
                $iv = substr($encryptedContentWithIv, 0, $ivLength);
                $encryptedContent = substr($encryptedContentWithIv, $ivLength);
                $aes->setIV($iv);

                try {
                    $decryptedContent = $aes->decrypt($encryptedContent);
                } catch (\Exception $e) {
                    $errores[] = 'Error al descifrar el contenido del documento: ' . $filePath;
                    return null;
                }
            }

            $documento->content_file = (pathinfo($documento->archivo, PATHINFO_EXTENSION) == 'pdf') ? null : base64_encode($decryptedContent ?? '');
            $documento->extension = pathinfo($documento->archivo, PATHINFO_EXTENSION);
            $documento->fecha_creacion = Carbon::parse($documento->fecha_creacion)->format('d-m-Y h:i a');

            return $documento;
        })->filter();

        $response = $documentosActivos->map(function ($documento) {
            return [
                'id' => $documento->id,
                'extension' => $documento->extension,
                'filename' => $documento->archivo,
                'fecha_creacion' => $documento->fecha_creacion,
                'content_file' => $documento->content_file,
            ];
        });

        return response()->json([
            'documentos' => $response,
            'errores' => $errores
        ]);
    }


    public function previewFile($id)
    {
        $dir = 'docs_franquicia/';
        $documento = FranquiciaDocumentos::find($id);
        $estado = FranquiciaDocumentos::select('activo')->where('id', $id)->first();
        $filename = FranquiciaDocumentos::select('archivo')->where('id', $id)->first();

        if (!$documento || $estado->activo == false) {
            throw new NotFoundHttpException('No se encontró el documento');
        }

        $aes = new AES('cbc');
        $aes->setKey(env('FRANQUICIA_ENCRYPTION_KEY'));

        $encryptedContentWithIv = Storage::disk('public')->get($dir . $documento->archivo);

        if (!$encryptedContentWithIv) {
            throw new NotFoundHttpException('No se encontró el contenido cifrado del documento');
        }

        $ivLength = 16;
        $iv = substr($encryptedContentWithIv, 0, $ivLength);
        $encryptedContent = substr($encryptedContentWithIv, $ivLength);
        $aes->setIV($iv);

        $decryptedContent = $aes->decrypt($encryptedContent);

        $tempFile = tempnam(sys_get_temp_dir(), 'franquicia_');
        file_put_contents($tempFile, $decryptedContent);

        $file = base64_encode($decryptedContent);
        $extension = pathinfo($documento->archivo, PATHINFO_EXTENSION);
        $fechaCreacion = Carbon::parse($documento->fecha_creacion)->format('d-m-Y h:i a');

        $response = [
            'content_file' => $file,
            'extension' => $extension,
            'filename' => $filename->archivo,
            'fecha_creacion' => $fechaCreacion,
        ];

        register_shutdown_function(function () use ($tempFile) {
            unlink($tempFile);
        });

        return response()->json($response);
    }

    public function deleteFile($id)
    {
        $documento = FranquiciaDocumentos::find($id);
        $estado = FranquiciaDocumentos::select('activo')->where('id', $id)->first();

        if (!$documento || $estado->activo == false) {
            throw new NotFoundHttpException('No se encontró el documento');
        }

        return DB::transaction(function () use ($documento) {
            $documento->update([
                'activo' => false,
                'fecha_edicion' => Carbon::now(),
            ]);

            return ['message' => 'Archivo eliminado exitosamente'];
        });
    }

    public function resolveFranquicia(FranquiciaRequest $request)
    {
        $user = Auth::user();

        $estado = EstadoFranquiciaEnum::getEstadoId('Solventada');

        $franquicia = Franquicia::find($request->id);

        $url = RoutesEmailEnum::VER_FRANQUICIA->getUrl(['id' => $franquicia->id]);

        $jefes = User::whereHas('roles', function ($query) {
            $query->where('rol_id', RolesEnum::getRolesId('Jefe'));
        })->get();

        if (!$franquicia) {
            throw new NotFoundHttpException('No se encontró la franquicia');
        }

        return DB::transaction(function () use ($request, $franquicia, $user, $estado, $url, $jefes) {
            $franquicia->update($request->validated() +  [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
                'estado' => $estado,
            ]);

            foreach ($jefes as $jefe) {
                $correo = new ResolucionFranquicia($franquicia, $url, $jefe);
                EnvioCorreo::dispatch($jefe->email, $correo);
            }

            return ['message' => 'Observaciones enviadas para su aprobación'];
        });
    }

    public function compareFranquicia(Request $request)
    {

        $estado = EstadoFranquiciaEnum::getEstadoId('Anulada');

        $data = Franquicia::with(['estados'])->when(isset($request->guia_aerea), function ($query) use ($request) {
            $query->where('no_guia_aerea', '=', $request->guia_aerea);
        })
            ->when(isset($request->carta_porte), function ($query) use ($request) {
                $query->where('carta_de_porte_no', '=', $request->carta_porte);
            })
            ->when(isset($request->conocimiento_embarque), function ($query) use ($request) {
                $query->where('conoc_de_embarque_no', '=', $request->conocimiento_embarque);
            })
            ->when(isset($request->mercaderia_no), function ($query) use ($request) {
                $query->where('inf_de_mercaderias_rec_no', '=', $request->mercaderia_no);
            })
            ->when(isset($request->dmti), function ($query) use ($request) {
                $query->where('nota_de_pedido_no', '=', $request->dmti);
            })->when(isset($request->franquicia_id), function ($query) use ($request) {
                $query->where('id', '!=', $request->franquicia_id);
            })
            ->where('estado', '!=', $estado)
            ->get();

        return $data;
    }

    public function cancelFranquicia(FranquiciaAnulacionRequest $request)
    {

        $user = Auth::user();

        $franquicia = Franquicia::find($request->id);

        $url = RoutesEmailEnum::VER_FRANQUICIA->getUrl(['id' => $franquicia->id]);

        $estado = EstadoFranquiciaEnum::getEstadoId('Anulada');


        if (!$franquicia) {
            throw new NotFoundHttpException('No se encontró la franquicia');
        }

        return DB::transaction(function () use ($request, $franquicia, $user, $estado, $url) {
            $franquicia->update($request->validated() +  [
                'editor' => $user->name,
                'fecha_edicion' => Carbon::now(),
                'estado' => $estado,
                'comentario_correccion' => null
            ]);

            $correo = new AnulacionFranquicia($franquicia, $url);
            EnvioCorreo::dispatch($franquicia->usuario_creador->email, $correo);

            return ['message' => 'Franquicia anulada con éxito'];
        });
    }

    public function approveFranquicia(Request $request)
    {
        $franquicia = Franquicia::find($request->id);

        $userCreator = $franquicia->usuario_creador;

        $url = RoutesEmailEnum::VER_FRANQUICIA->getUrl(['id' => $franquicia->id]);

        if (!$franquicia) {
            throw new NotFoundHttpException("No se encontró la franquicia");
        }

        $estado = EstadoFranquiciaEnum::getEstadoId('Aprobada');



        return DB::transaction(function () use ($request, $userCreator, $estado, $franquicia, $url) {
            $codigo_colaborador = $franquicia->usuario_creador->profile->cod_colaborador;

            $codigo_definitivo = CorrelativoUtils::getDefinitivo($codigo_colaborador);

            $franquicia->update($request->validated() + [
                'codigo_franquicia' => $codigo_definitivo,
                'comentario_correccion' => null,
                'estado' => $estado,
            ]);

            $correo = new AprobacionFranquicia($userCreator, $franquicia, $url);
            EnvioCorreo::dispatch($userCreator->email, $correo);

            return ['message' => 'Franquicia aprobada con éxito'];
        });
    }

    public function editFechasFranquicia(FranquiciasActualizarFechasRequest $request)
    {
        $user = Auth::user();
        $franquicia = Franquicia::find($request->id);

        if (!$franquicia) {
            throw new NotFoundHttpException("No se encontró la franquicia");
        }

        return DB::transaction(function () use ($request, $user, $franquicia) {
            $updateData = $request->validated() + ['editor' => $user->name];

            $franquicia->update($updateData);

            if (!is_null($franquicia->fecha_despacho) && !is_null($franquicia->fecha_entrega)) {
                $estado = EstadoFranquiciaEnum::getEstadoId('Firmada');
                $franquicia->update(['estado' => $estado]);
            }

            return ['message' => "Franquicia actualizada con éxito"];
        });
    }

    public function expiredInstitucion($id)
    {
        $institucion = CtlInstitucion::find($id);

        if (!$institucion) {
            throw new NotFoundHttpException('No se encontró la institución');
        }

        $expiredInstitucion = $institucion->fecha_fin_junta_directiva < Carbon::now()->format('Y-m-d');

        $mensaje = ($expiredInstitucion) ? '¡Personería jurídica expirada!' : null;

        if ($mensaje) {
            return response()->json(['message' => $mensaje, 'expired_date' => $institucion->fecha_fin_junta_directiva]);
        }

        return null;
    }
}
