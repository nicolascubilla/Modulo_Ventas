<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';
session_start();

class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 0, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración inicial
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Reporte de Presupuesto de Compras');
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('times', '', 11);
$pdf->AddPage('P', 'LEGAL');
$logo_path = 'C:/wamp/www/lp3/img/carpin_la_familyfull.jpg';

if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 13, 22, 0, '', '', 'T', false, 100, '', false, false, 0, false, false, false);
    $pdf->Ln(14); // Espacio después del logo
} else {
    $pdf->Cell(0, 10, 'Logo no encontrado.', 0, 1, 'C');
}


// Título principal
$pdf->SetFont('times', 'B', 16);
$pdf->Cell(0, 0, 'REPORTE PRESUPUESTO DE COMPRAS', 'B', 0, 'C', 0);
$pdf->Ln(10);

// Datos del presupuesto
$presupuesto_id = $_REQUEST['vpresupuesto_id'];
$cabeceras = consultas::get_datos("SELECT * FROM v_presupuesto_compra_cabecera_detalle_result WHERE presupuesto_id = $presupuesto_id");

if (!empty($cabeceras)) {
    $cabecera = $cabeceras[0];

    // Información compacta
    $pdf->SetFont('times', '', 12);
// Mostrar el número de presupuesto
$pdf->Cell(0, 0, 'Presupuesto N° ' . $presupuesto_id, 0, 1, 'C', 0);
$pdf->Ln(10);
    $pdf->SetFont('times', '', 10);
    $pdf->Cell(100, 5, 'USUARIO: ' . $cabecera['usuario'], 0, 0, 'L');
    $pdf->Cell(0, 5, 'FECHA: ' . $cabecera['fecha'], 0, 1, 'R');

    $pdf->Cell(100, 5, 'SUCURSAL: ' . $cabecera['sucursal'], 0, 0, 'L');
    $pdf->Cell(0, 5, 'PROVEEDOR: ' . $cabecera['prv_razonsocial'], 0, 1, 'R');

    // Estado destacado
    $pdf->SetTextColor($cabecera['estado'] === 'ANULADO' ? 240 : 0, 0, 0);
    $pdf->Cell(0, 5, 'ESTADO: ' . $cabecera['estado'], 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Ln(5);

    // Detalles de la tabla
    $detalles = consultas::get_datos("SELECT * FROM v_presupuesto_compra_cabecera_detalle_result WHERE presupuesto_id = $presupuesto_id");
    if (!empty($detalles)) {
        $pdf->SetFont('times', 'B', 10);
        $pdf->SetFillColor(220, 220, 220);

        // Encabezado de la tabla
        $pdf->Cell(20, 8, 'CANT.', 1, 0, 'C', 1);
        $pdf->Cell(90, 8, 'MATERIAL', 1, 0, 'C', 1);
        $pdf->Cell(40, 8, 'COSTO UNITARIO', 1, 0, 'C', 1);
        $pdf->Cell(40, 8, 'SUBTOTAL', 1, 0, 'C', 1);
        $pdf->Ln();

        // Datos de la tabla
        $pdf->SetFont('times', '', 10);
        foreach ($detalles as $detalle) {
            $pdf->Cell(20, 7, $detalle['cantidad'], 1, 0, 'C');
            $pdf->Cell(90, 7, $detalle['material'], 1, 0, 'L');
            $pdf->Cell(40, 7, number_format($detalle['costo_unitario'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(40, 7, number_format($detalle['subtotal'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Ln();
        }

        // Total en números
        $pdf->SetFont('times', 'B', 10);
        $pdf->Cell(150, 7, 'TOTAL', 1, 0, 'R', 1);
        $pdf->Cell(40, 7, number_format($cabecera['total'], 0, ',', '.'), 1, 0, 'R', 1);
        $pdf->Ln();
    }


// Total en letras ajustado
$pdf->Ln(5); // Espaciado entre la tabla y el texto en letras
$pdf->SetFont('times', 'B', 10);

// Ajusta el ancho de las celdas para que ocupen todo el espacio de la tabla
$ancho_etiqueta = 36; // Ancho de la celda para "TOTAL EN LETRAS:"
$ancho_texto = 154; // Ancho restante para el texto en letras

// Celda de la etiqueta
$pdf->Cell($ancho_etiqueta, 7, 'TOTAL EN LETRAS:', 1, 0, 'R', 1); // Etiqueta con borde y color opcional

$pdf->SetFont('times', '', 10);
// Concatenar "GUARANÍES" al texto del total en letras
$total_en_letras = strtoupper($cabecera['totalletra']) . ' GUARANÍES';

// Celda para el texto completo
$pdf->MultiCell($ancho_texto, 7, $total_en_letras, 1, 'L', false);


} else {
    $pdf->Cell(0, 5, 'No se encontró el presupuesto.', 0, 1, 'C');
}

// Generar salida
$pdf->Output('reporte_presupuesto_compra.pdf', 'I');
?>
