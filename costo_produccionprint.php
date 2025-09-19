<?php
include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 0, '', 'T');
        $this->Ln(2);
        $this->Cell(90, 6, 'Autor: Nicolas Cubilla', 0, 0, 'L');
        $this->Cell(90, 6, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Crear el PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('nicolas cubilla');
$pdf->SetTitle('REPORTE COSTO PRODUCCIÓN');
$pdf->SetSubject('Reporte de costos');
$pdf->SetKeywords('TCPDF, PDF, reporte, costo produccion');
$pdf->setPrintHeader(false);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Nueva página
$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('times', 'B', 20);

// Logo y título
$logo_path = 'C:/wamp/www/lp3/img/carpin_la_familyfull.jpg';
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 13, 22);
}
$pdf->Cell(0, 10, "REPORTE DE COSTO DE PRODUCCIÓN", 0, 1, 'C');
$pdf->Ln(10);

// Traer datos
$id = (int) $_REQUEST['control_id'];
$detalle_costo = consultas::get_datos("SELECT * FROM v_costo_produccion_detalle WHERE control_id = $id");

$pdf->SetFont('times', '', 11);

if (!empty($detalle_costo)) {
    $cabecera = $detalle_costo[0];
    
    // Cabecera
    $pdf->Cell(60, 6, "ID CONTROL: " . $cabecera['control_id'], 0, 0, 'L');
    $pdf->Cell(60, 6, "CALIDAD ID: " . $cabecera['calidad_id'], 0, 0, 'L');
    $pdf->Cell(60, 6, "FECHA: " . $cabecera['fecha'], 0, 1, 'L');

    $pdf->Cell(60, 6, "ESTADO: " . $cabecera['nombre'], 0, 0, 'L');
    $pdf->Cell(60, 6, "TIEMPO INVERTIDO: " . $cabecera['tiempo_invertido'], 0, 0, 'L');
    $pdf->Cell(60, 6, "SUCURSAL: " . $cabecera['suc_descri'], 0, 1, 'L');

    $pdf->Ln(5);

    // Detalle de Materiales
    $pdf->SetFont('times', 'B', 12);
    $pdf->Cell(0, 8, "DETALLES DE MATERIALES UTILIZADOS", 0, 1, 'L');
    $pdf->Ln(3);

    $pdf->SetFont('times', '', 11);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(10, 8, '#', 1, 0, 'C', 1);
    $pdf->Cell(80, 8, 'Material', 1, 0, 'C', 1);
    $pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C', 1);
    $pdf->Cell(30, 8, 'Costo Unit.', 1, 0, 'C', 1);
    $pdf->Cell(40, 8, 'Costo Total', 1, 1, 'C', 1);

    $total_materiales = 0;
    foreach ($detalle_costo as $index => $detalle) {
        $pdf->Cell(10, 6, $index + 1, 1, 0, 'C');
        $pdf->Cell(80, 6, $detalle['materiales_utilizados'], 1, 0, 'L');
        $pdf->Cell(30, 6, number_format($detalle['cantidad_utilizada'], 0, ",", "."), 1, 0, 'C');
        $pdf->Cell(30, 6, number_format($detalle['costo_unitario'], 0, ",", "."), 1, 0, 'C');
        $pdf->Cell(40, 6, number_format($detalle['costo_materiales'], 0, ",", "."), 1, 1, 'C');
        $total_materiales += $detalle['costo_materiales'];
    }

    $pdf->SetFont('times', 'B', 11);
    $pdf->Cell(150, 8, "Total Materiales:", 1, 0, 'R');
    $pdf->Cell(40, 8, number_format($total_materiales, 0, ",", "."), 1, 1, 'C');
    $pdf->Ln(5);

    // Detalles de Perdidas y Mermas
    $mermas_perdidas = consultas::get_datos("SELECT * FROM v_mermas_perdidas WHERE control_id = $id");
    if (!empty($mermas_perdidas)) {
        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(0, 8, "DETALLES DE PÉRDIDAS Y MERMAS", 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFont('times', '', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(10, 8, '#', 1, 0, 'C', 1);
        $pdf->Cell(80, 8, 'Artículo', 1, 0, 'C', 1);
        $pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C', 1);
        $pdf->Cell(30, 8, 'Precio', 1, 0, 'C', 1);
        $pdf->Cell(40, 8, 'Costo Merma', 1, 1, 'C', 1);

        $total_merma = 0;
        foreach ($mermas_perdidas as $index => $detalle) {
            $pdf->Cell(10, 6, $index + 1, 1, 0, 'C');
            $pdf->Cell(80, 6, $detalle['art_descri'], 1, 0, 'L');
            $pdf->Cell(30, 6, number_format($detalle['cantidad'], 0, ",", "."), 1, 0, 'C');
            $pdf->Cell(30, 6, number_format($detalle['art_preciov'], 0, ",", "."), 1, 0, 'C');
            $pdf->Cell(40, 6, number_format($detalle['costo_merma_aprox'], 0, ",", "."), 1, 1, 'C');
            $total_merma += $detalle['costo_merma_aprox'];
        }

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(150, 8, "Total Perdidas/Mermas:", 1, 0, 'R');
        $pdf->Cell(40, 8, number_format($total_merma, 0, ",", "."), 1, 1, 'C');
        $pdf->Ln(5);
    } else {
        $pdf->Cell(0, 5, "No se encontraron registros de pérdidas o mermas.", 0, 1, 'C');
    }

    // Costo Final de Producción
    $mermas_costo_final = consultas::get_datos("SELECT * FROM v_costo_produccion_final WHERE id_produccion = $id");
    if (!empty($mermas_costo_final)) {
        $detalle_final = $mermas_costo_final[0];

        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(0, 8, "RESUMEN COSTO FINAL DE PRODUCCIÓN", 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFont('times', '', 11);
        $pdf->Cell(80, 8, "Costo de Materiales:", 1, 0, 'R');
        $pdf->Cell(40, 8, number_format($detalle_final['costo_materiales'], 0, ",", "."), 1, 1, 'C');

        $pdf->Cell(80, 8, "Costo de Merma:", 1, 0, 'R');
        $pdf->Cell(40, 8, number_format($detalle_final['costo_merma_aprox'], 0, ",", "."), 1, 1, 'C');

        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(80, 10, "Costo Total Producción:", 1, 0, 'R');
        $pdf->Cell(40, 10, number_format($detalle_final['costo_total_produccion'], 0, ",", "."), 1, 1, 'C');
    }
}

// Firma
$pdf->Ln(15);
$pdf->Cell(60, 6, '_________________________', 0, 0, 'C');
$pdf->Cell(60, 6, '', 0, 0);
$pdf->Cell(60, 6, '_________________________', 0, 1, 'C');

$pdf->Cell(60, 6, 'Responsable Producción', 0, 0, 'C');
$pdf->Cell(60, 6, '', 0, 0);
$pdf->Cell(60, 6, 'Supervisor', 0, 1, 'C');

// Salida
$pdf->Output('reporte_costo_produccion.pdf', 'I');
?>
