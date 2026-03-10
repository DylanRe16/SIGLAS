<?php

namespace App\Http\Controllers;

use TCPDF;
use App\Models\Solicitud_citaModel;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generatePdf($id)
    {
        // Cargar la cita con relaciones necesarias
        $cita = Solicitud_citaModel::with([
            'persona',
            'empresa',
            'tipoSolicitud',
            'empresa.estado',
            'empresa.municipio',
            'empresa.parroquia',
            'empresa.sector',
            'solicitudProcurador.personalRolUnidadSust.unidadSust'
        ])->where('id_ptsolicitud', $id)->first();

        if (!$cita) {
            abort(404, 'Cita no encontrada');
        }

        // Para obtener la entidad relacionada
        $entidad_id = $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->entidad_id;
        $entidad = DB::connection('bd4')
            ->table('public.entidad')
            ->where('id', $entidad_id)
            ->first();

        // Renderizar la vista con datos a HTML
        $html = view('modulos.solicitud.pdf-print', ['cita' => $cita, 'persona' => $cita->persona, 'entidad' => $entidad])->render();

        // Rutas absolutas de las imágenes
        $rutaImagen = public_path('dist/img/cintillo-a-medida.png');
        $rutaImagen1 = public_path('dist/img/logo_mpppst.png');
        $rutaPie = public_path('img/pie_presentaciones_Carta.jpg');
        $rutaNuevoCintillo = public_path('img/nuevo_cintillo_mpppst.png');


        // Crear instancia TCPDF personalizada con Footer y Header con imágenes
        $pdf = new class($cita, $rutaImagen, $rutaImagen1, $rutaNuevoCintillo) extends TCPDF {
            protected $cita;
            protected $rutaImagen;
            protected $rutaImagen1;
            protected $rutaNuevoCintillo;

            public function __construct($cita, $rutaImagen, $rutaImagen1, $rutaNuevoCintillo)
            {
                parent::__construct();
                $this->cita = $cita;
                $this->rutaImagen = $rutaImagen;
                $this->rutaImagen1 = $rutaImagen1;
                $this->rutaNuevoCintillo = $rutaNuevoCintillo;
            }
            public function Header()
            {
                // Marca de agua de imagen
                // $watermark = public_path('dist/img/watermark_sgs.jpg');
                // if (file_exists($watermark)) {
                //     // Ancho y alto de la página
                //     $pageWidth = $this->getPageWidth();
                //     $pageHeight = $this->getPageHeight();

                //     // Guardar estado gráfico
                //     $this->SetAlpha(1); // Controla la transparencia
                //     $this->Image(
                //         $watermark,
                //         0, // X
                //         0, // Y
                //         $this->w, // Ancho total (incluye márgenes)
                //         $this->h, // Alto total (incluye márgenes)
                //         'JPG',
                //         '',
                //         '',
                //         false,
                //         300,
                //         '',
                //         false,
                //         false,
                //         0
                //     );
                //     $this->SetAlpha(1); // Restablece opacidad
                // }

                // Imagen principal (cintillo)
                if (file_exists($this->rutaNuevoCintillo)) {
                    $this->Image($this->rutaNuevoCintillo, 20, 10, 170, 15, 'PNG');
                }
                // // Logo secundario (ajusta posición/tamaño según tu diseño)
                // if (file_exists($this->rutaImagen1)) {
                //     $this->Image($this->rutaImagen1, 145, 10, 40, 15, 'PNG');
                // }


                // Watermark SGS (simétrico, cubre toda la página)
                $bMargin = $this->getBreakMargin();
                $auto_page_break = $this->AutoPageBreak;
                $this->SetAutoPageBreak(false, 0);

                $pageWidth = $this->getPageWidth();
                $pageHeight = $this->getPageHeight();

                // Ajustes para simetría y espaciado
                $this->SetFont('helvetica', 'B', 14);
                $this->SetTextColor(200, 200, 200); // Un poco más tenue, ajusta al gusto

                $xSpacing = 40; // Espaciado horizontal mayor
                $ySpacing = 30; // Espaciado vertical mayor
                $angle = 45;     // Ángulo como en la imagen adjunta, prueba con 30-35º

                // Calcula el número de columnas y filas para que el patrón sea simétrico
                $cols = ceil($pageWidth / $xSpacing) + 1;
                $rows = ceil($pageHeight / $ySpacing) + 1;

                // Opcional: hazlo más tenue
                if (method_exists($this, 'SetAlpha')) {
                    $this->SetAlpha(0.7); // Transparencia (requiere TCPDF >= 6.2.12)
                }

                for ($col = 0; $col < $cols; $col++) {
                    for ($row = 0; $row < $rows; $row++) {
                        $x = $col * $xSpacing;
                        $y = $row * $ySpacing;
                        $this->StartTransform();
                        $this->Rotate($angle, $x, $y);
                        $this->Text($x, $y, 'SGS');
                        $this->StopTransform();
                    }
                }

                if (method_exists($this, 'SetAlpha')) {
                    $this->SetAlpha(1);
                }

                $this->SetAutoPageBreak($auto_page_break, $bMargin);

                // Configura la fuente y color del texto
                $text = 'OTIC';
                $textWidth = $this->GetStringWidth($text, 'helvetica', 'B', 14);

                // Centrar el texto horizontalmente, y ponerlo en Y=8mm (ajusta según tu diseño)
                $x = $pageWidth - $textWidth - 12;
                $y = 8;
                $this->Text($x, $y, $text);
            }

            public function Footer(){
                    if (file_exists(public_path('img/pie_presentaciones_Carta.jpg'))) {
                        $this->Image(
                            public_path('img/pie_presentaciones_Carta.jpg'),
                            0,                // X (ajusta según tu diseño)
                            $this->getPageHeight() - 25, // Y (posición desde abajo)
                            210,               // Ancho (ajusta si es necesario)
                            25,                // Alto (ajusta si es necesario)
                            'JPG',             // Tipo de imagen
                            '',                // Link (vacío si no aplica)
                            '',                // Align
                            false,             // Resize
                            300,               // DPI
                            '',                // Paleta
                            false,             // Fit box
                            false,             // Hidden
                            0                  // Border
                        );
                    }

                $this->SetY(-120);
                $this->SetFont('helvetica', '', 11);
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('helvetica', 'B', 11);
                $this->SetFont('helvetica', 'B', 10); // Negrita
                $this->Write(8, 'NOTA: ');

                $this->SetFont('helvetica', '', 10); // Normal
                $this->Write(8, 'En caso de no acudir en la fecha y hora indicada, deberá realizar una nueva solicitud');


                $this->SetY(-50);
                $this->SetFont('helvetica', '', 11);
                $this->SetTextColor(0, 0, 0);

                $this->Cell(0, 8, '"Juntos construimos Justicia Laboral"', 0, 1, 'C');
                $this->Cell(0, 8, '¡Gracias por confiar en el Ministerio del Poder Popular', 0, 1, 'C');
                $this->Cell(0, 8, 'para el Proceso Social de Trabajo (MPPPST)!', 0, 1, 'C');
            }
        };

        $pdf->SetCreator('SGS');
        $pdf->SetAuthor('MPPPST');
        $pdf->SetTitle(($cita->tipoSolicitud->solicitud->first()->sdescripcion ?? 'Cita'));
        $pdf->SetSubject('PDF Solicitud Inspectoria');

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

        $pdf->SetMargins(20, 35, 20);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetFont('helvetica', '', 11);

        $pdf->AddPage();

        $pdf->SetY(30);
        $pdf->writeHTML($html, true, false, true, false, '');

        // Preparar URL para QR
        $url = asset("imprimir-pdf/{$id}");
        $qrSize = 40;

        // Obtener ancho y alto de la página
        $pageWidth = $pdf->getPageWidth();
        $pageHeight = $pdf->getPageHeight();

        // Márgenes
        $marginRight = 87;
        $marginBottom = 60;

        // Calcular posición X (derecha) y Y (abajo)
        $xPosition = $pageWidth - $qrSize - $marginRight;
        $yPosition = $pageHeight - $qrSize - $marginBottom;

        // Estilo del QR
        $style = [
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => [0, 0, 0],
            'bgcolor' => false,
            'module_width' => 1,
            'module_height' => 1
        ];

        // Imprimir el QR en la posición calculada
        $pdf->write2DBarcode($url, 'QRCODE,L', $xPosition, $yPosition, $qrSize, $qrSize, $style, 'N');

        // Salida directa al navegador (inline)
        return response($pdf->Output('documento.pdf', 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }
}
