<?php

namespace App\Services;

use App\Enum\DocumentEnum;
use App\Enum\EstadoFranquiciaEnum;
use App\Enum\EstadosEnum;
use App\Helpers\Utils;
use App\Http\Requests\Request;
use App\Http\Requests\v1\ReporteRequest;
use App\Models\Catalogos\CtlFirmante;
use App\Models\Franquicia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Resources\ReporteResource;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\PDF;
use SebastianBergmann\Template\Template;

class ReporteService
{


    /**
     * Lista las franquicias
     * @param Request $request
     * @return object
     */
    public function listar(ReporteRequest $request): object
    {
        $franquicias = Franquicia::with('clase', 'institucion', 'oficial', 'factura', 'estados', 'tipos')
            ->when($request->fecha_inicio, function ($query) use ($request) {
                return $query->where('fecha_despacho', '>=', $request->fecha_inicio);
            })
            ->when($request->fecha_fin, function ($query) use ($request) {
                return $query->where('fecha_despacho', '<=', $request->fecha_fin);
            })
            ->when($request->mes, function ($query) use ($request) {
                return $query->whereBetween('fecha_despacho', [
                    Carbon::parse($request->mes)->startOfMonth()->toDateString(),
                    Carbon::parse($request->mes)->endOfMonth()->toDateString()
                ]);
            })
            ->when($request->dia, function ($query) use ($request) {
                return $query->where('fecha_despacho', $request->dia);
            })
            ->whereHas('estados', function ($query) {
                $query->where('id', EstadoFranquiciaEnum::getEstadoId('Firmada'));
            })
            ->paginateData($request);

        if (is_array($franquicias['data'])) {
            $franquicias['data'] = array_map(function ($franquicia) {
                $franquicia['fecha'] = Carbon::parse($franquicia['fecha'])->format('d/m/Y');
                $franquicia['fecha_despacho'] = Carbon::parse($franquicia['fecha_despacho'])->format('d/m/Y');
                return $franquicia;
            }, $franquicias['data']);

            return (object) [
                'content' => ReporteResource::collection(((object)$franquicias)->data),
                'headers' => ['total_rows' => ((object)$franquicias)->total]
            ];
        } else {
            // Formatear fecha_ingreso
            $franquicias['data'] = $franquicias['data']->map(function ($franquicia) {
                $franquicia->fecha = Carbon::parse($franquicia->fecha)->format('d/m/Y');
                $franquicia->fecha_despacho = Carbon::parse($franquicia->fecha_despacho)->format('d/m/Y');
                return $franquicia;
            });


            return (object) [
                'content' => ReporteResource::collection($franquicias['data']),
                'headers' => ['total_rows' => $franquicias['total']]
            ];
        }
    }

    /**
     * Descarga un documento basdo en un TemplateProcessor
     * @param TemplateProcessor $documento
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(TemplateProcessor $documento, $filename)
    {
        return Utils::downloadTemplateProcessor($documento, $filename);
        /* return Utils::convertDocx2Pdf($documento, $filename); */
    }

    /**
     * Genera un documento de reporte de franquicia por id
     * @param int $id
     * @return TemplateProcessor
     * @throws NotFoundHttpException
     */

    public  function generateDocFranquciaById($id): TemplateProcessor
    {
        $template = storage_path(env('TEMPLATE_IMPRESION'));

        $franquicia = Franquicia::with('estados', 'clase', 'institucion', 'oficial', 'tipos', 'factura', 'aduana')
            ->where('id', $id)
            ->first();

        if (!$franquicia) throw new NotFoundHttpException('Franquicia no encontrada');

        $fecha = Carbon::parse($franquicia->fecha);
        $fecha_formateada = ucfirst($fecha->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY'));

        $franquicias = $franquicia->toArray();


        $franquicias['fecha_formateada'] = $fecha_formateada;



        if ($franquicia->estados->nombre == 'Revisión') {
            $franquicia->codigo_franquicia = $franquicia->codigo_provisional;
        }

        $configuracion = CtlFirmante::where('fecha_inicio_validez', '<=', $franquicia->fecha)
            ->whereNull('fecha_fin_validez')->first();


        if (!$configuracion)
            $configuracion = CtlFirmante::where('fecha_inicio_validez', '<=', $franquicia->fecha)
                ->where('fecha_fin_validez', '>=', $franquicia->fecha)->first();

        if (!$configuracion) {
            throw new NotFoundHttpException('No se ha encontrado ningún firmante asociado a la fecha de la franquicia ingresada');
        }

        return Utils::generateDocument($template, $franquicias + $configuracion->toArray());
    }

    /**
     * Genera un documento de reporte de franquicias
     * @param object $props
     * @return TemplateProcessor
     * @throws NotFoundHttpException
     */
    public  function generateDocFranquicias(ReporteRequest $props, $path): TemplateProcessor
    {
        $fecha_actual = Carbon::now();
        $template =  storage_path($path);
        $estado = EstadoFranquiciaEnum::getEstadoId('Firmada');
        $franquicias = Franquicia::with('clase', 'institucion', 'oficial', 'tipos', 'factura', 'estados')
            ->when(isset($props->fecha_inicio), function ($query) use ($props) {
                return $query->where('fecha_despacho', '>=', $props->fecha_inicio);
            })
            ->when(isset($props->fecha_fin), function ($query) use ($props) {
                return $query->where('fecha_despacho', '<=', $props->fecha_fin);
            })
            ->when(isset($props->mes), function ($query) use ($props) {
                $date = Carbon::parse($props->mes);
                $query->whereYear('fecha_despacho', $date->year)
                    ->whereMonth('fecha_despacho', $date->month);
            })
            ->when(isset($props->dia), function ($query) use ($props) {
                return $query->where('fecha_despacho', $props->dia);
            })->where('estado', $estado)
            ->get();

        if ($franquicias->isEmpty()) throw new NotFoundHttpException('No se encontraron franquicias para generar un reporte');

        $configuracion = CtlFirmante::where('fecha_inicio_validez', '<=', $fecha_actual)
            ->where('fecha_fin_validez', '>=', $fecha_actual)->first();

        if (!$configuracion || $configuracion->fecha_inicio_validez > $fecha_actual) throw new NotFoundHttpException('No se encontró un firmante');

        $firmador = User::withWhereHas('profile', function ($query) {
            $query->where('firmador', true);
        })->first();
        if (!$firmador) throw new NotFoundHttpException('No se encontró un firmador');

        return Utils::generateDocument(
            $template,
            [
                "configuracion" => $configuracion->toArray(),
                'franquicias' => $franquicias->toArray(),
                'firmador' => $firmador->toArray(),
                'fecha' => $fecha_actual,
            ],
            function ($templateProccesor, $variables, $array) {

                $fecha = Carbon::parse($array['fecha']);
                $franquicias = $array['franquicias'];
                $firmador = $array['firmador'];
                $configuracion = $array['configuracion'];
                $templateProccesor->cloneRow('franquicias.codigo_franquicia', count($franquicias));
                $dia = mb_convert_case($fecha->translatedFormat('l'), MB_CASE_TITLE, "UTF-8");

                $templateProccesor->setValue('fecha', "$dia, {$fecha->translatedFormat('d \d\e F \d\e\l Y')}");
                function setTemplateValues($templateProccesor, $prefix, $data)
                {
                    foreach ($data as $key => $value) {
                        if (is_array($value)) {
                            setTemplateValues($templateProccesor, $prefix . '.' . $key, $value);
                        } else {
                            $templateProccesor->setValue($prefix . '.' . $key, (string) $value);
                        }
                    }
                }
                // Set values for firmador
                setTemplateValues($templateProccesor, 'firmador', $firmador);
                // Set values for configuracion
                setTemplateValues($templateProccesor, 'configuracion', $configuracion);
                $templateProccesor->setValue('doclist', '');

                foreach ($franquicias as $key => $row) {
                    $fecha = Carbon::parse($row['fecha']);
                    $fecha_despacho = Carbon::parse($row['fecha_despacho']);

                    $row['fecha'] = $fecha->format('d/m/Y');
                    $row['fecha_entrega'] = $fecha_despacho->format('d/m/Y');
                    $row['estado_reporte'] = isset($row['fecha_entrega']) ? 'ENTREGADA' : 'PENDIENTE';
                    foreach ($variables as $variable) {
                        $varkey = str_replace('franquicias.', '', $variable);
                        $vars = explode('||', $varkey);
                        $value = Arr::get($row, $vars[0]);
                        if (isset($vars[1])) {
                            $value = $value ?? Arr::get($row, $vars[1]);
                        }
                        $value = $value ?: '';
                        $documents = [
                            Utils::documentNomeclature($row['no_guia_aerea'], DocumentEnum::AEREA) ?? '',
                            Utils::documentNomeclature($row['conoc_de_embarque_no'], DocumentEnum::CONC_EMBARQUE) ?? '',
                            Utils::documentNomeclature($row['inf_de_mercaderias_rec_no'], DocumentEnum::MERCANCIAS) ?? '',
                            Utils::documentNomeclature($row['carta_de_porte_no'], DocumentEnum::CARTE_PORTE) ?? '',
                            Utils::documentNomeclature($row['nota_de_pedido_no'], DocumentEnum::DMTI) ?? '',
                            Utils::documentNomeclature($row['itinerario'], DocumentEnum::ITINERARIO) ?? '',
                        ];

                        $filteredDocuments = array_filter($documents);
                        $doclist = array_map(function ($item) {

                            if (is_null($item) || empty($item)) {
                                return '';
                            }
                            return "<w:p><w:pPr><w:jc w:val=\"center\"/></w:pPr><w:r><w:t>• $item</w:t></w:r></w:p>";
                        }, $filteredDocuments);
                        if ($variable == 'doclist') {
                            $templateProccesor->setValue($variable . '#' . ($key + 1), implode($doclist));
                            continue;
                        }
                        $templateProccesor->setValue($variable . '#' . ($key + 1), $value);
                    }
                }
            }
        );
    }
}
