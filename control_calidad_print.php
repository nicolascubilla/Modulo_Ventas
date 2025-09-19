<?php
include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

// Extender TCPDF para personalizar el pie de página
class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 0, '', 'T');
        $this->Ln(2);
        $this->Cell(90, 6, 'Autor: Nicolas Cubilla', 0, 0, 'L');
        $this->Cell(90, 6, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Crear nuevo documento PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicolas Cubilla');
$pdf->SetTitle('REPORTE DE AVANCE CONTROL CALIDAD');
$pdf->SetSubject('Reporte Control de calidad');
$pdf->SetKeywords('TCPDF, PDF, report, calidad');
$pdf->setPrintHeader(false);
$pdf->SetMargins(25, 20, 20);
$pdf->SetAutoPageBreak(TRUE, 20);

// Agregar página
$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('times', 'B', 20);

// Logo
$logo_path = 'C:/wamp/www/lp3/img/carpin_la_familyfull.jpg';
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 10, 25, 0, '', '', 'T', false, 100);
    $pdf->Ln(15);
} else {
    $pdf->Cell(0, 10, 'Logo no encontrado.', 0, 1, 'C');
}

// Título del reporte
$pdf->Cell(0, 0, "REPORTE DE CONTROL CALIDAD", 0, 1, 'C');
$pdf->Ln(10);

// Obtener datos
$calidad_id = $_REQUEST['vcalidad_id'];
$cabeceras = consultas::get_datos("SELECT * FROM v_control_calidad_cab_detall WHERE calidad_id = $calidad_id");

$pdf->SetFont('times', '', 11);

if (!empty($cabeceras)) {
    $cabecera = $cabeceras[0];

    // Cabecera del reporte
    $pdf->Cell(90, 6, "Empleado: " . $cabecera['empleado'], 0, 0, 'L');
    $pdf->Cell(77, 6, "FECHA: " . $cabecera['fecha_inspeccion'], 0, 1, 'R');

    $pdf->Cell(90, 6, "Resultado: " . $cabecera['resultado'], 0, 0, 'L');
    $pdf->SetTextColor($cabecera['aprobado'] === 'RECHAZADO' ? 240 : 0, 0, 0);
    $pdf->Cell(77, 6, "ESTADO: " . $cabecera['aprobado'], 0, 1, 'R');
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Ln(3);
    $pdf->Cell(22, 4, "Observación:", 0, 0, 'L');
    $pdf->MultiCell(100, 4, $cabecera['observaciones'], 0, 'L');

    $pdf->Ln(4);
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(80, 6, "CALIDAD ID N°: " . $calidad_id, 0, 1, 'L');
    $pdf->Ln(5);

    // Detalles del reporte
    $detalles = consultas::get_datos("SELECT * FROM v_control_calidad_cab_detall WHERE calidad_id = $calidad_id");

    if (!empty($detalles)) {
        $pdf->SetFont('', 'B', 9);
        $pdf->SetFillColor(180, 180, 180);
    
        // Encabezado de la tabla
        $pdf->Cell(15, 7, 'CANT.', 1, 0, 'C', 1);
        $pdf->Cell(30, 7, 'ARTÍCULO', 1, 0, 'C', 1);
        $pdf->Cell(39, 7, 'ETAPAS PRODUCCIÓN', 1, 0, 'C', 1);
        $pdf->Cell(25, 7, 'ESTADO', 1, 0, 'C', 1);
        $pdf->Cell(29, 7, 'CANT. CRÍTICA', 1, 0, 'C', 1);
        $pdf->Cell(32, 7, 'CANT. RECHAZADA', 1, 1, 'C', 1);
    
        $pdf->SetFont('', '', 9);
        $pdf->SetFillColor(255, 255, 255);
    
        // Contenido de la tabla
        foreach ($detalles as $detalle) {
            $pdf->Cell(15, 6, $detalle['cantidad'], 1, 0, 'C', 1);
            $pdf->Cell(30, 6, $detalle['art_descri'], 1, 0, 'L', 1);
            $pdf->Cell(39, 6, $detalle['nombre_etapa'], 1, 0, 'L', 1);
            $pdf->Cell(25, 6, $detalle['nombre'], 1, 0, 'C', 1);
            $pdf->Cell(29, 6, $detalle['cantidad_critica'], 1, 0, 'C', 1);
            $pdf->Cell(32, 6, $detalle['cantidad_rechazada'], 1, 1, 'C', 1);
        }
    
    
    } else {
        $pdf->Cell(0, 5, "No hay detalles disponibles para este reporte.", 0, 1, 'C');
    }

} else {
    $pdf->Cell(0, 5, "No se encontró el reporte.", 0, 1, 'C');
}

// Salida del PDF
$pdf->Output('control_calidad_print.pdf', 'I');
?>
