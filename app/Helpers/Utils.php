<?php


namespace App\Helpers;

use App\Enum\DocumentEnum;
use Exception;
use App\Enum\PermissionEnum;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

abstract class Utils
{


    /**
     * Genera un middleware de permisos
     * @param array $permissions
     * @param string $middleware
     * @return string
     * @throws Exception
     */
    public static function permission(array $permissions, $middleware = 'permission'): string
    {
        $permissions = collect($permissions)->map(function ($permission) {
            if (!($permission instanceof PermissionEnum))
                throw new Exception('Permission debe ser una instancia de PermissionEnum');

            return $permission->value;
        });

        return $middleware . ':' . $permissions->join(',');
    }


    /**
     * Genera un documento word a partir de un template
     * @param string $template
     * @param array $array
     * @param callable|null $callback
     * @return TemplateProcessor
     * @throws Exception
     */
    public static function  generateDocument($template, $array, $callback = null): TemplateProcessor
    {
        if (!file_exists($template))
            throw new Exception("El template no fue encontrado $template");

        $templateProccesor = new TemplateProcessor($template);

        $variables = $templateProccesor->getVariables();


        if ($callback) {
            $callback($templateProccesor, $variables, $array);
        }

        if (!$callback)
            foreach ($variables as $variable) {
                $varskeys = explode('||', $variable);

                if (count($varskeys) > 1) {
                    $value = Arr::get($array, $varskeys[0]) ?? Arr::get($array, $varskeys[1]) ?? '';
                } else {
                    $value = Arr::get($array, $varskeys[0]) ?? '';
                }
                $templateProccesor->setValue($variable, $value);
            }

        return $templateProccesor;
    }

    /**
     * Descarga un documento word
     * @param TemplateProcessor $templateProcessor
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public static function downloadTemplateProcessor(TemplateProcessor $templateProcessor, $name)
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');

        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $name)->deleteFileAfterSend(true);
    }


    /**
     * Nomesclatura para los diferentes documentos de franquicias
     * @param string $document
     * @param DocumentEnum $type
     * @return string
     */
    public static function documentNomeclature($document, DocumentEnum $type): string
    {

        if (is_null($document) || empty($document)) {
            return '';
        }
        $nomeclature = match ($type) {
            DocumentEnum::CONC_EMBARQUE => "BL No.",
            DocumentEnum::DMTI => "DMTI No.",
            DocumentEnum::AEREA => "Guía Aérea No.",
            DocumentEnum::CARTE_PORTE => "Carta Porte No.",
            DocumentEnum::MERCANCIAS => "Inf. de mercaderías rec. No.",
            DocumentEnum::ITINERARIO => "Itinerario:",
        };
        return "$nomeclature $document";
    }


    /**
     * Genera un array de documentos de franquicias
     * @param array $array
     * @param array|null $keys
     * @return array
     */
    public static function documentos($array, $keys = null): array
    {
        if (!$keys) $keys = DocumentEnum::toValues();

        $documentos = [];
        foreach ($keys as $key) {

            if (!isset($array[$key]) || empty($array[$key])) continue;

            $documentos[] = self::documentNomeclature(
                $array[$key],
                DocumentEnum::from($key)
            );
        }
        return $documentos;
    }

    public static function convertDocx2Pdf(TemplateProcessor $templateProcessor, $name): BinaryFileResponse
    {
        $tempDir = sys_get_temp_dir();
        $tempDocxFile = tempnam($tempDir, $name) . '.docx';
        $tempHtmlFile = tempnam($tempDir, $name) . '.html';
        $tempPdfFile = tempnam($tempDir, $name) . '.pdf';

        // Save the TemplateProcessor to a temporary DOCX file
        $templateProcessor->saveAs($tempDocxFile);

        // Load the DOCX file into PhpWord and convert it to HTML
        $phpWord = IOFactory::load($tempDocxFile);
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlWriter->save($tempHtmlFile);

        // Initialize Dompdf and load the HTML content
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $htmlContent = file_get_contents($tempHtmlFile);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Save the generated PDF to a temporary file
        $output = $dompdf->output();
        file_put_contents($tempPdfFile, $output);

        // Remove temporary files
        File::delete($tempDocxFile);
        File::delete($tempHtmlFile);

        // Return the PDF file as a download response and delete it after sending
        return response()->download($tempPdfFile, $name . '.pdf')->deleteFileAfterSend(true);
    }
}
