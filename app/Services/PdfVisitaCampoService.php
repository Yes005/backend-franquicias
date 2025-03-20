<?php

namespace App\Services;

use App\Enum\EstadoFranquiciaEnum;
use App\Models\Franquicia;
use App\Models\VisitaCampo;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PdfVisitaCampoService
{
    const IMG_PATH = 'img/';
    private const LOGO_PATH = self::IMG_PATH . 'logotipo_goes_b.png';
    private const WATERMARK_PATH = self::IMG_PATH . 'escudo.png';
    private const PDF_STORAGE_PATH = 'pdfs_visita_campo/'; // Utilizado cuando se guarda el archivo en storage, es decir que el destino del output es "S".

    private function createMpdfInstance(): Mpdf
    {
        $mpdf = new Mpdf(['format' => 'Letter']);

        $this->configureWatermark($mpdf);
        $this->configureFooter($mpdf);

        return $mpdf;
    }

    private function configureWatermark(Mpdf $mpdf): void
    {
        if (file_exists(public_path(self::WATERMARK_PATH))) {
            $mpdf->SetWatermarkImage(
                public_path(self::WATERMARK_PATH),
                0.6,
                'D',
                [94, 50]
            );
            $mpdf->watermarkImgBehind = true;
            $mpdf->showWatermarkImage = true;
        }
    }

    private function configureFooter(Mpdf $mpdf): void
    {
        $mpdf->SetHTMLFooter('
            <div style="text-align: right; font-weight: bold; font-size: 8pt;">
                Página {PAGENO} de {nb}
            </div>
        ');
    }

    private function generateFileName(string $prefix, ?string $codigo = null): string
    {
        $timestamp = Carbon::now()->format('d-m-Y_His');
        $codigoPart = $codigo ? "{$codigo}_" : '';
        return "{$prefix}_{$codigoPart}{$timestamp}";
    }

    private function savePdf(Mpdf $mpdf, string $fileName): string
    {
        $temp = tempnam(sys_get_temp_dir(), 'pdf');

        $mpdf->SetTitle($fileName);
        $mpdf->SetAuthor('Secretaría Privada de la Presidencia de El Salvador');

        $mpdf->Output($temp, 'F');

        return $temp;
    }

    private function renderVisitaHtml(VisitaCampo $visitaCampo): string
    {
        return View::make('pdfs.visitaCampoReporte', [
            'logo' => public_path(self::LOGO_PATH),
            'visitaCampo' => $visitaCampo,
            'codigoFranquicia' => $visitaCampo->franquicia->codigo_franquicia,
            'fechaVisita' => $visitaCampo->fecha_visita->locale('es')->translatedFormat('l, d \d\e F \d\e Y'),
            'categoria' => $visitaCampo->categoria->nombre,
            'comentarios' => $visitaCampo->detalle,
            'nombres' => $visitaCampo->nombres->pluck('nombre'),
        ])->render();
    }

    private function validateVisita(VisitaCampo $visitaCampo): void
    {
        if (!$visitaCampo) {
            throw new NotFoundHttpException('No se encontró el reporte de visita de campo solicitado');
        }

        if (!EstadoFranquiciaEnum::FINALIZADO->equals($visitaCampo->estado->id)) {
            throw new NotFoundHttpException('El reporte de visita de campo no ha sido finalizado');
        }
    }

    public function generarReporteVisita($id)
    {
        $visitaCampo = VisitaCampo::find($id);

        $this->validateVisita($visitaCampo);

        $mpdf = $this->createMpdfInstance();
        $mpdf->WriteHTML($this->renderVisitaHtml($visitaCampo));

        $fileName = $this->generateFileName('reporte_visita');
        return $this->savePdf($mpdf, $fileName);
    }

    public function generarReportesVisita($franquiciaId)
    {
        $franquicia = Franquicia::find($franquiciaId);

        if (!$franquicia) {
            throw new NotFoundHttpException('No se encontró la franquicia solicitada');
        }

        $visitasCampo = VisitaCampo::where('entidad_id', $franquicia->id)
            ->where('estado_id', EstadoFranquiciaEnum::getEstadoId('Finalizado'))
            ->orderByRaw('fecha_visita DESC, TIME(created_at) DESC')
            ->get();

        if ($visitasCampo->isEmpty()) {
            throw new NotFoundHttpException('No se encontraron reportes de visita de campo para esta franquicia');
        }

        $mpdf = $this->createMpdfInstance();

        foreach ($visitasCampo as $index => $visita) {
            if ($index > 0) {
                $mpdf->AddPage();
            }
            $mpdf->WriteHTML($this->renderVisitaHtml($visita));
        }

        $fileName = $this->generateFileName('reportes_franquicia', $franquicia->codigo_franquicia);
        return $this->savePdf($mpdf, $fileName);
    }
}
