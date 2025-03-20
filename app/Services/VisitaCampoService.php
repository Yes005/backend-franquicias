<?php

namespace App\Services;

use App\Enum\EstadoFranquiciaEnum;
use App\Helpers\StorageFile;
use App\Http\Requests\v1\FilterVisitaCampoRequest;
use App\Http\Requests\v1\VisitaCampoRequest;
use App\Models\VisitaCampo;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VisitaCampoService
{
    private string $pathTo;

    private StorageFile $storageFile;

    public function __construct()
    {
        $this->pathTo = env('FILES_VISITAS_PATH', 'public/docs_visitas');

        $this->storageFile = new StorageFile(
            $this->pathTo,
            fn($path, $file, $model) => $this->createFile($path, $file, $model),
            'archivos'
        );
    }


    private function createFile($path, $file, $model): array
    {
        return [
            'nombre' => basename($path),
            'ruta' => $path,
            'size' => $file->getSize(),
            'correlativo' => $model->correlativo_file
        ];
    }


    public function listar(FilterVisitaCampoRequest $request): object
    {
        $visitas = VisitaCampo::with([
            'franquicia:id,institucion_id,oficial_id,tipo,fecha_despacho',
            'franquicia.institucion:id,nombre',
            'franquicia.oficial:id,nombre',
            'estado:id,nombre'
        ])->whereHas('franquicia', function ($query) use ($request) {
            $query->when($request->institucion_id, fn($query, $value) => $query->where('institucion_id', $value))
                ->when($request->oficial_id, fn($query, $value) => $query->where('oficial_id', $value));
        })
            ->search($request->numero_franquicia, 'codigo_franquicia', ['franquicia'])
            ->search($request->numero_seguimiento, 'numero_seguimiento', [])
            ->when($request->fecha_inicio, fn($query) => $query->whereDate('fecha_visita', '>=', $request->fecha_inicio))
            ->when($request->fecha_fin, fn($query) => $query->whereDate('fecha_visita', '<=', $request->fecha_fin))
            ->orderBy('updated_at', 'desc')
            ->paginateData($request);

        return (object) $visitas;
    }


    public function crear(VisitaCampoRequest $request): VisitaCampo
    {
        return DB::transaction(function () use ($request) {


            $visita = VisitaCampo::create($request->all());


            if ($request->has('nombres')) {
                collect($request->nombres)
                    ->each(fn($nombre) => $visita->nombres()->create(['nombre' => $nombre]));
            }
            if ($request->has('archivos')) {
                collect($request->archivos)->each(function ($archivo) use ($visita) {

                    $this->storageFile->saveFile(fn() => $visita->file_name, $archivo, $visita);
                });
            }
            return $visita;
        });
    }


    public function actualizar(VisitaCampoRequest $request, $id): VisitaCampo
    {
        return DB::transaction(function () use ($request, $id) {

            $visita = VisitaCampo::find($id);

            if (!$visita) {
                throw new BadRequestException('La visita no existe');
            }

            if (!$request->fecha_visita) {
                $visita->fecha_visita = null;
            }

            if (!$request->categoria_visita_id) {
                $visita->categoria_visita_id = null;
            }

            $visita->update($request->all());

            $visita->nombres()->forceDelete();

            $this->storageFile->deleteFile($visita, fn($model) => $model->ruta);

            if ($request->has('nombres')) {
                collect($request->nombres)
                    ->each(fn($nombre) => $visita->nombres()->create(['nombre' => $nombre]));
            }

            if ($request->has('archivos')) {
                collect($request->archivos)->each(function ($archivo) use ($visita) {
                    $this->storageFile->saveFile(fn() => $visita->file_name, $archivo, $visita);
                });
            }

            return $visita;
        });
    }


    public function eliminar($id): void
    {
        $visita = VisitaCampo::find($id);

        if (!$visita) {
            throw new BadRequestException('La visita a eliminar no existe');
        }

        if (EstadoFranquiciaEnum::tryFrom($visita->estado_id) === EstadoFranquiciaEnum::FINALIZADO) {
            throw new BadRequestException('No se puede eliminar una visita finalizada');
        }

        DB::transaction(function () use ($visita) {
            $this->storageFile->deleteFile($visita, fn($model) => $model->ruta);

            $visita->nombres()->delete();

            $visita->forceDelete();
        });
    }


    public function detalleVisita($id): object
    {

        $visitas = VisitaCampo::with(['archivos', 'nombres', 'franquicia', 'estado'])
            ->find($id);

        if (!$visitas) {
            throw new NotFoundHttpException('La visita no existe');
        }

        $response = [
            'id' => $visitas->id,
            'fecha_visita' => $visitas->fecha_visita?->format('Y-m-d'),
            'codigo_franquicia' => $visitas->codigo_franquicia,
            'estado' => $visitas->estado->nombre ?? null,
            'nombres' => $visitas->nombres->pluck('nombre'),
            'entidad' => [
                "institucion_id" => $visitas->franquicia?->institucion_id,
                "oficial_id" => $visitas->franquicia?->oficial_id,
                "nombre" => $visitas->franquicia?->entidad?->nombre,
                "id" => $visitas->franquicia?->id,
            ],
            'numero_seguimiento' => $visitas->numero_seguimiento,
            'correlativo' => $visitas->correlativo,
            'categoria_visita_id' => $visitas->categoria_visita_id,
            'detalle' => $visitas->detalle,
            'archivos' => $visitas->archivos->map(function ($archivo) {

                $filePath = storage_path('app/' . $archivo->ruta);


                if (!file_exists($filePath)) {
                    return [
                        'id' => $archivo->id,
                        'nombre_archivo' => $archivo->nombre,
                        'base64' => null,
                        'mensaje' => 'Archivo no encontrado',
                    ];
                }

                $fileContent = file_get_contents($filePath);
                $base64Content = base64_encode($fileContent);

                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                return [
                    'id' => $archivo->id,
                    'nombre_archivo' => $archivo->nombre,
                    'base64' => $base64Content,
                    'extension' => $extension,
                ];
            }),
            'correlativo_file' => $visitas->correlativo_file,
            'file_name' => $visitas->file_name,
        ];

        return (object) $response;
    }
}
