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
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('nicolas cubilla');
$pdf->SetTitle('REPORTE DE PEDIDO COMPRAS');
$pdf->SetSubject('Reporte Pedido Compras');
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
$pdf->AddPage('P', 'LEGAL');
// TIPO DE LETRA
$pdf->SetFont('times', 'B', 20);
$logo_path = 'C:/wamp/www/lp3/img/carpin_la_familyfull.jpg';

if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 13, 22, 0, '', '', 'T', false, 100, '', false, false, 0, false, false, false);
    $pdf->Ln(9); // Espacio después del logo
} else {
    $pdf->Cell(0, 10, 'Logo no encontrado.', 0, 1, 'C');
}
$pdf->Cell(0, 0, "REPORTE DE PEDIDO COMPRAS", 0, 1, 'C');
$pdf->Ln(10);  // Agregar un espacio después del título

// Recuperar los datos del pedido
$pedido_id = $_REQUEST['vid_pedido'];
$cabeceras = consultas::get_datos("SELECT * FROM v_pedido_compra_detalle WHERE id_pedido = $pedido_id");

$pdf->SetFont('times', '', 11);

// Imprimir la cabecera del pedido
if (!empty($cabeceras)) {
    $cabecera = $cabeceras[0]; // Usar el primer registro de la cabecera
    
    // Usuario y Fecha
    $pdf->Cell(120, 2, "USUARIO: " . $cabecera['usuario'], 0, '', 'L');
    $pdf->Cell(80, 2, "FECHA: " . $cabecera['fecha_pedido'], 0, '', 'L');
    $pdf->Ln(5);  // Agregar un poco de espacio

    // Sucursal
    $pdf->Cell(130, 2, "SUCURSAL: " . $cabecera['sucursal'], 0, '', 'L');
    
    // Estado: Cambiar color si el estado es "ANULADO"
    if ($cabecera['estado'] === 'ANULADO') {
        $pdf->SetTextColor(240, 0, 0);  // Rojo
    } else {
        $pdf->SetTextColor(0, 0, 0);  // Negro
    }
    $pdf->Cell(100, 2, "ESTADO: " . $cabecera['estado'], 0, '', 'L');
    $pdf->Ln(5);  // Espacio después del estado
    
    // Restaurar color de texto
    $pdf->SetTextColor(0, 0, 0);

    // Observación y Pedido N° 
   // Observación: Usar MultiCell para texto largo
$pdf->Cell(130, 6, "OBSERVACION:", 0, '', 'L');
$pdf->Ln(5); // Espacio antes de la observación

$pdf->MultiCell(190, 6, $cabecera['observacion'], 0, 'L'); // Ajustar automáticamente el texto a varias líneas

// Pedido N° en una nueva línea
$pdf->Ln(5); // Espacio después de la observación


    $pdf->Cell(80, 2, "PEDIDO N°: " . $pedido_id, 0, '', 'L');
    $pdf->Ln(10);  // Espacio antes de la tabla de detalles
    
    // Tabla de detalles
    $detalles = consultas::get_datos("SELECT * FROM v_pedido_compra_detalle WHERE id_pedido = $pedido_id");
    if (!empty($detalles)) {
        // Encabezado de la tabla de detalles
        $pdf->SetFont('', 'B', 12);
        $pdf->SetFillColor(180, 180, 180);
        $pdf->Cell(45, 8, 'CANTIDAD', 1, 0, 'C', 1);
        $pdf->Cell(120, 8, 'MATERIAL', 1, 0, 'C', 1);
        $pdf->Ln();

        // Detalles del pedido
        $pdf->SetFont('', '', 11);
        $pdf->SetFillColor(255, 255, 255);

        foreach ($detalles as $detalle) {
            $pdf->Cell(45, 6, $detalle['cantidad'], 1, 0, 'C', 1);
            $pdf->Cell(120, 6, $detalle['material'], 1, 0, 'L', 1);
            $pdf->Ln();
        }

        $pdf->Ln();
    } else {
        $pdf->Cell(0, 5, "No hay detalles disponibles para este pedido.", 0, 1, 'C');
    }
} else {
    $pdf->Cell(0, 5, "No se encontró el pedido.", 0, 1, 'C');
}

// SALIDA AL NAVEGADOR
$pdf->Output('reporte_pedido_compra.pdf', 'I');
?>
