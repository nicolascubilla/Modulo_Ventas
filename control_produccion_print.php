<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

// Extend the TCPDF class to create custom Footer
class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 0, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicolas Cubilla');
$pdf->SetTitle('REPORTE DE CONTROL DE AVANCES');
$pdf->SetSubject('Reporte de Producción');
$pdf->SetKeywords('TCPDF, PDF, reporte, producción');
$pdf->setPrintHeader(false);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Add a page
$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('times', 'B', 20);
$pdf->Cell(0, 0, "REPORTE DE AVANCES DE PRODUCCIÓN", 0, 1, 'C');
$pdf->Ln();

// Query based on request parameters
$filters = [];
if (!empty($_REQUEST['opcion'])) {
    switch ($_REQUEST['opcion']) {
        case 1: // Fecha
            $filters[] = "fecha_avance::date BETWEEN '" . $_REQUEST['vfecha_inicio'] . "' AND '" . $_REQUEST['vfecha_fin'] . "'";
            break;
        case 2: // Proveedor
            $filters[] = "prv_cod IN (" . $_REQUEST['vproveedor'] . ")";
            break;
        case 3: // Artículo
            $filters[] = "art_cod IN (" . $_REQUEST['varticulo'] . ")";
            break;
        case 4: // Empleado
            $filters[] = "emp_cod IN (" . $_REQUEST['vempleado'] . ")";
            break;
        default:
            $filters[] = "1=1"; // No filters
            break;
    }
} else {
    $filters[] = "ord_cod = " . $_REQUEST['vord_cod'];
}

$filterString = implode(' AND ', $filters);
$cabeceras = consultas::get_datos("SELECT * FROM v_control_produccion_detalle WHERE $filterString");

$pdf->SetFont('times', '', 11);

if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        $pdf->Cell(120, 5, "CÓDIGO DE ORDEN: " . $cabecera['ord_cod'], 0, 1, 'L');
        $pdf->Cell(80, 5, "FECHA AVANCE: " . $cabecera['fecha_avance'], 0, 1, 'L');
        $pdf->Cell(80, 5, "ESTADO: " . $cabecera['ord_estado'], 0, 1, 'L');
        $pdf->Cell(130, 5, "PROGRESO: " . $cabecera['progreso'] . "%", 0, 0, 'L');
        $pdf->Cell(80, 5, "TIEMPO INVERTIDO: " . $cabecera['tiempo_invertido'] . " horas", 0, 1, 'L');
        $pdf->Cell(130, 5, "COMENTARIOS: " . $cabecera['comentarios'], 0, 1, 'L');
        $pdf->Ln();

        // Table Header
        $pdf->SetFillColor(180, 180, 180);
        $pdf->SetFont('', 'B', 12);

        // Production Details
        $detalles = consultas::get_datos("SELECT control_id, ord_cod, fecha_avance, progreso, tiempo_invertido, comentarios FROM v_control_produccion_detalle WHERE ord_cod=" . $cabecera['ord_cod']);
        if (!empty($detalles)) {
            $pdf->Cell(20, 7, 'CÓDIGO', 1, 0, 'C', 1);
            $pdf->Cell(30, 7, 'N° ORDEN', 1, 0, 'C', 1);
            $pdf->Cell(40, 7, 'FECHA AVANCE', 1, 0, 'C', 1);
            $pdf->Cell(60, 7, 'PROGRESO (%)', 1, 0, 'C', 1);
            $pdf->Cell(40, 7, 'TIEMPO(H)', 1, 1, 'C', 1);

            $pdf->SetFont('', '', 11);
            foreach ($detalles as $det) {
                $pdf->Cell(20, 6, $det['control_id'], 1, 0, 'C');
                $pdf->Cell(30, 6, $det['ord_cod'], 1, 0, 'C');
                $pdf->Cell(40, 6, $det['fecha_avance'], 1, 0, 'C');
                $pdf->MultiCell(60, 6, $det['progreso'], 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
                $pdf->Cell(40, 6, number_format($det['tiempo_invertido'], 2), 1, 1, 'C');
            }
            $pdf->Ln();
        } else {
            $pdf->Cell(0, 10, "No se encontraron detalles de la producción", 0, 1, 'L');
            $pdf->Ln();
        }
    }
} else {
    $pdf->Cell(0, 10, "No se encontraron registros", 0, 1, 'L');
}

// Output to browser
$pdf->Output('reporte_control_produccion.pdf', 'I');

?>
