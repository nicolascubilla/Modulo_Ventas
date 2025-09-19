<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 0, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

         // Pie de página
    //public function Footer() {
        // Posiciona el pie de página a 15mm del borde inferior
        $this->SetY(-15);
        // Establecer la fuente
        $this->SetFont('helvetica', 'I', 8);
        // Línea horizontal (opcional, elimina si no la deseas)
        $this->Cell(0, 0, '', 'T');  
        $this->Ln(2); // Espacio después de la línea

        // Autor alineado a la izquierda
        $this->Cell(90, 6, 'Autor: Nicolas Cubilla', 0, 0, 'L');
        // Número de página alineado a la derecha
        //$this->Cell(90, 6, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}



// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('nicolas cubilla');
$pdf->SetTitle('REPORTE DE MERMAS');
$pdf->SetSubject('Reporte mermas');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->setPrintHeader(false);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// ---------------------------------------------------------
// AGREGAR PAGINA
// ... (todo tu código antes permanece igual)
// ... toda la parte previa (clase MYPDF, conexión, creación de PDF, etc.) igual

$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('times', 'B', 20);

// Logo y título
$logo_path = 'C:/wamp/www/lp3/img/carpin_la_familyfull.jpg';
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 13, 22);
}
$pdf->Cell(0, 10, "REPORTE DE MERMAS", 0, 1, 'C');
$pdf->Ln(10);

// Cabecera
$merma_id = $_REQUEST['merma_id'];
$cabeceras = consultas::get_datos("SELECT * FROM v_mermas WHERE merma_id = $merma_id");

$pdf->SetFont('times', '', 11);
if (!empty($cabeceras)) {
    $cabecera = $cabeceras[0];
    
    $pdf->Cell(120, 6, "EMPLEADO: " . $cabecera['nombre_empleado'], 0, 0, 'L');
    $pdf->Cell(70, 6, "FECHA: " . $cabecera['fecha_merma'], 0, 1, 'L');

    $pdf->Cell(0, 6, "DESCRIPCIÓN: " . $cabecera['descripcion'], 0, 1, 'L');

    $pdf->MultiCell(0, 6, "MOTIVO: " . $cabecera['motivo'], 0, 'L');
    $pdf->Ln(5);

    // Detalle
    $pdf->SetFont('times', 'B', 12);
    $pdf->Cell(0, 8, "DETALLE DE LA MERMA N°: $merma_id", 0, 1, 'L');
    $pdf->Ln(3);

    $detalles = consultas::get_datos("SELECT * FROM v_mermas WHERE merma_id = $merma_id");
    if (!empty($detalles)) {
        // Encabezado de la tabla
        $pdf->SetFont('', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(120, 8, 'ARTÍCULO', 1, 0, 'C', 1);
        $pdf->Cell(60, 8, 'CANTIDAD', 1, 1, 'C', 1);

        $pdf->SetFont('', '', 11);
        $pdf->SetFillColor(255, 255, 255);

        foreach ($detalles as $detalle) {
            $pdf->Cell(120, 6, $detalle['art_descri'], 1, 0, 'C'); // centrado
            $pdf->Cell(60, 6, number_format($detalle['cantidad'], 0, ",", "."), 1, 1, 'C');
        }

        $pdf->Ln(10); // espacio antes de la firma
    } else {
        $pdf->Cell(0, 5, "No hay detalles disponibles para esta merma.", 0, 1, 'C');
    }

    // Firma
   // Doble firma: Responsable y Supervisor
$pdf->Ln(15);

$pdf->Cell(60, 6, '_________________________', 0, 0, 'C');
$pdf->Cell(60, 6, '', 0, 0); // Espacio entre firmas
$pdf->Cell(60, 6, '_________________________', 0, 1, 'C');

$pdf->Cell(60, 6, $cabecera['nombre_empleado'], 0, 0, 'C');
$pdf->Cell(60, 6, '', 0, 0); // Espacio entre firmas
$pdf->Cell(60, 6, 'Nombre del Supervisor', 0, 1, 'C');

$pdf->Cell(60, 6, 'Responsable', 0, 0, 'C');
$pdf->Cell(60, 6, '', 0, 0);
$pdf->Cell(60, 6, 'Supervisor', 0, 1, 'C');

} else {
    $pdf->Cell(0, 5, "No se encontró la merma.", 0, 1, 'C');
}

$pdf->Output('reporte_merma.pdf', 'I');
