<?php
include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

// Extend TCPDF to create custom Header and Footer
class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 0, '', 'T');  
        $this->Ln(2);
        $this->Cell(90, 6, 'Autor: Nicolas Cubilla', 0, 0, 'L');
        $this->Cell(90, 6, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicolas Cubilla');
$pdf->SetTitle('REPORTE DE AVANCE PRODUCCIÓN');
$pdf->SetSubject('Reporte Control De Producción');
$pdf->SetKeywords('TCPDF, PDF, report, production');
$pdf->setPrintHeader(false);
$pdf->SetMargins(25, 20, 20);
$pdf->SetAutoPageBreak(TRUE, 20);

// Add page
$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('times', 'B', 20);
$logo_path = 'C:/wamp/www/lp3/img/carpin_la_familyfull.jpg';

if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 10, 25, 0, '', '', 'T', false, 100);
    $pdf->Ln(15);
} else {
    $pdf->Cell(0, 10, 'Logo no encontrado.', 0, 1, 'C');
}

$pdf->Cell(0, 0, "REPORTE AVANCE DE PRODUCCIÓN", 0, 1, 'C');
$pdf->Ln(10);

$control_id = $_REQUEST['vcontrol_id'];
$cabeceras = consultas::get_datos("SELECT * FROM v_control_produccion_cabe WHERE control_id = $control_id");
$pdf->SetFont('times', '', 11);

if (!empty($cabeceras)) {
    $cabecera = $cabeceras[0];
    $pdf->Cell(90, 6, "USUARIO: " . $cabecera['usu_nick'], 0, 0, 'L');
    $pdf->Cell(77, 6, "FECHA: " . $cabecera['fecha_avance'], 0, 1, 'R');
    
    $pdf->Cell(90, 6, "SUCURSAL: " . $cabecera['suc_descri'], 0, 0, 'L');
    $pdf->SetTextColor($cabecera['estado'] === 'ANULADO' ? 240 : 0, 0, 0);
    $pdf->Cell(77, 6, "ESTADO: " . $cabecera['estado'], 0, 1, 'R');
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->Ln(4);
    $pdf->Cell(16, 6, "Progreso:", 0, 0, 'L');
    $pdf->Cell(125, 5, $cabecera['progreso'], 0, 1, 'L');
    
    $pdf->Cell(30, 6, "Tiempo Invertido:", 0, 0, 'L');
$pdf->SetFont('', 'B'); // Poner en negrita
$pdf->Cell(135, 6, $cabecera['tiempo_invertido'] . " HS", 0, 1, 'L');
$pdf->SetFont('', ''); // Restaurar fuente normal

    
    $pdf->Cell(22, 6, "Comentarios:", 0, 0, 'L');
    $pdf->MultiCell(135, 6, $cabecera['comentarios'], 0, 'L');
    
    $pdf->SetFont('times', 'B', 15); // Negrita para el título
    $pdf->Ln(3);
    $pdf->Cell(80, 6, "Detalles De La Producción", 0, 1, 'L');
    
    $pdf->SetFont('times', '', 12); // Fuente normal para el Control ID
    $pdf->Cell(80, 6, "Control ID N°: " . $control_id, 0, 1, 'L');
    $pdf->Ln(5);
    
    
    $detalles = consultas::get_datos("SELECT * FROM v_control_produccion_detalle WHERE control_id = $control_id");
    if (!empty($detalles)) {
        $pdf->SetFont('', 'B', 10);
        $pdf->SetFillColor(180, 180, 180);
        $pdf->Cell(20, 8, 'CANTIDAD', 1, 0, 'C', 1);
        $pdf->Cell(50, 8, 'ARTÍCULO', 1, 0, 'C', 1);
        $pdf->Cell(60, 8, 'ETAPAS PRODUCCIÓN', 1, 0, 'C', 1);
        $pdf->Cell(35, 8, 'ESTADO', 1, 1, 'C', 1);
        
        
        $pdf->SetFont('', '', 11);
        $pdf->SetFillColor(255, 255, 255);
        
        foreach ($detalles as $detalle) {
            $pdf->Cell(20, 6, $detalle['cantidad'], 1, 0, 'C', 1);
            $pdf->Cell(50, 6, $detalle['descripcion_articulo'], 1, 0, 'C', 1);
            $pdf->Cell(60, 6, $detalle['nombre_etapa'], 1, 0, 'C', 1);
            $pdf->Cell(35, 6, $detalle['estado'], 1, 1, 'C', 1);
            
        }
    } else {
        $pdf->Cell(0, 5, "No hay detalles disponibles para este reporte.", 0, 1, 'C');
    }
} else {
    $pdf->Cell(0, 5, "No se encontró el reporte.", 0, 1, 'C');
}

$pdf->Output('control_produccion_print.pdf', 'I');
?>
