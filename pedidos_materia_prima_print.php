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
$pdf->SetTitle('REPORTE DE PEDIDOS MATERIA PRIMA');
$pdf->SetSubject('Reporte Pedido Materia Prima');
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
$pdf->SetMargins(25, PDF_MARGIN_TOP, 20); // Aumentar margen izquierdo y derecho

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
$pdf->Cell(0, 0, "REPORTE DE PEDIDOS MATERIA PRIMA", 0, 1, 'C');
$pdf->Ln(10);  // Agregar un espacio después del título

// Recuperar los datos del pedido
$pedido_id = $_REQUEST['vpedido_id'];
$cabeceras = consultas::get_datos("SELECT * FROM v_pedido_materia_prima_detalle WHERE pedido_id = $pedido_id");

$pdf->SetFont('times', '', 11);

// Imprimir la cabecera del pedido
if (!empty($cabeceras)) {
    $cabecera = $cabeceras[0]; // Usar el primer registro de la cabecera
    
   // Usuario y Fecha en la misma línea
$pdf->Cell(120, 6, "USUARIO: " . $cabecera['usuario'], 0, 0, 'L'); 
$pdf->Cell(70, 6, "FECHA: " . $cabecera['fecha'], 0, 1, 'L'); 
$pdf->Ln(1); // Espacio después de la línea

// Sucursal y Estado en la misma línea
$pdf->Cell(120, 6, "SUCURSAL: " . $cabecera['sucursal'], 0, 0, 'L');

// Estado: Cambiar color si es "ANULADO"
if ($cabecera['estado'] === 'ANULADO') {
    $pdf->SetTextColor(240, 0, 0); // Rojo
} else {
    $pdf->SetTextColor(0, 0, 0); // Negro
}

// Asegurar que el Estado quede alineado con la Fecha
$pdf->Cell(70, 6, "ESTADO: " . $cabecera['estado'], 0, 1, 'L');
$pdf->Ln(1); // Espacio después del estado
$pdf->SetTextColor(0, 0, 0); // Restaurar color

    // Restaurar color de texto
    $pdf->SetTextColor(0, 0, 0);

    // Observación y Pedido N° 
   // Observación: Usar MultiCell para texto largo
   $pdf->Cell(32, 2, "Equipo De Trabajo:", 0, 0, 'L');
   $pdf->Cell(110, 2, $cabecera['nombre_equipo'], 0, 1, 'L');
   $pdf->Ln(5);


    $pdf->Cell(80, 2, "Pedido N°: " . $pedido_id, 0, '', 'L');
    $pdf->Ln(10);  // Espacio antes de la tabla de detalles
    
    // Tabla de detalles
    $detalles = consultas::get_datos("SELECT * FROM v_pedido_materia_prima_detalle WHERE pedido_id = $pedido_id");
    if (!empty($detalles)) {
        // Encabezado de la tabla de detalles
        $pdf->SetFont('', 'B', 12);
        $pdf->SetFillColor(180, 180, 180);
        $pdf->Cell(45, 8, 'CANTIDAD', 1, 0, 'C', 1);
        $pdf->Cell(120, 8, 'Material', 1, 0, 'C', 1);
        $pdf->Ln();

        // Detalles del pedido
        $pdf->SetFont('', '', 11);
        $pdf->SetFillColor(255, 255, 255);

        foreach ($detalles as $detalle) {
            $pdf->Cell(45, 6, $detalle['cantidad'], 1, 0, 'C', 1); 

            $pdf->Cell(120, 6, $detalle['nombre_material'], 1, 0, 'C', 1);
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
$pdf->Output('reporte_pedido_materia_prima.pdf', 'I');
?>
