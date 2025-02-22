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
$pdf->SetTitle('Factura Proveedor');
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('times', '', 11);
$pdf->AddPage('P', 'A4');
$logo_path = 'C:/wamp/www/lp3/img/carpin_la_familyfull.jpg';

// Logo
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 13, 22, 0, '', '', 'T', false, 100, '', false, false, 0, false, false, false);
    $pdf->Ln(14);
} else {
    $pdf->Cell(0, 10, 'Logo no encontrado.', 0, 1, 'C');
}

// Título principal
$pdf->SetFont('times', 'B', 16);
$pdf->Cell(0, 0, 'FACTURA PROVEEDOR', 'B', 0, 'C', 0);
$pdf->Ln(10);

// Datos de la factura
$vid_factura = $_REQUEST['vid_factura'];
$cabeceras = consultas::get_datos("SELECT * FROM v_factura_compra_cabecera_detalle WHERE id_factura = $vid_factura");

if (!empty($cabeceras)) {
    $cabecera = $cabeceras[0];

    // Información general
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(0, 0, 'Factura N°: ' . $vid_factura, 0, 1, 'C', 0);
    $pdf->Ln(5);

    // Datos de cabecera
    $pdf->SetFont('times', '', 10);
    $pdf->Cell(90, 5, 'Proveedor: ' . $cabecera['proveedor'], 0, 0, 'L');
    $pdf->Cell(90, 5, 'Timbrado: ' . $cabecera['timbrado'], 0, 1, 'L');
    $pdf->Cell(90, 5, 'Fecha de emisión: ' . $cabecera['fecha_emision'], 0, 0, 'L');
    $pdf->Cell(90, 5, 'Usuario: ' . $cabecera['usuario_nick'], 0, 1, 'L');
    $pdf->Cell(90, 5, 'Sucursal: ' . $cabecera['sucursal_descripcion'], 0, 0, 'L');
    $pdf->Cell(90, 5, 'Condición: ' . $cabecera['condicion'], 0, 1, 'L');
    $pdf->Cell(90, 5, 'N° Factura Proveedor: ' . $cabecera['id_factu_proveedor'], 0, 0, 'L');
    $pdf->Cell(90, 5, 'N° Orden: ' . ($cabecera['orden_id'] ?? 'N/A'), 0, 1, 'L');
    $pdf->Cell(90, 5, 'Método de Pago: ' . $cabecera['metodo_pago_nombre'], 0, 1, 'L');

    $pdf->Ln(5);

    // Detalles de la factura
    $detalles = consultas::get_datos("SELECT * FROM v_factura_compra_cabecera_detalle WHERE id_factura = $vid_factura");

    if (!empty($detalles)) {
        $pdf->SetFont('times', 'B', 10);
        $pdf->SetFillColor(220, 220, 220);

        // Encabezado de la tabla
        $pdf->Cell(20, 8, 'CANT.', 1, 0, 'C', 1);
        $pdf->Cell(50, 8, 'MATERIAL', 1, 0, 'C', 1);
        $pdf->Cell(25, 8, 'COSTO UNIT.', 1, 0, 'C', 1);
        $pdf->Cell(25, 8, 'IVA 5%', 1, 0, 'C', 1);
        $pdf->Cell(25, 8, 'IVA 10%', 1, 0, 'C', 1);
        $pdf->Cell(35, 8, 'SUBTOTAL', 1, 1, 'C', 1);

        // Detalles
        $pdf->SetFont('times', '', 10);
        foreach ($detalles as $detalle) {
            $pdf->Cell(20, 7, $detalle['cantidad'], 1, 0, 'C');
            $pdf->Cell(50, 7, $detalle['nombre_material'], 1, 0, 'L');
            $pdf->Cell(25, 7, number_format($detalle['costo_unitario'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(25, 7, number_format($detalle['iva_5'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(25, 7, number_format($detalle['iva_10'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(35, 7, number_format($detalle['subtotal'], 0, ',', '.'), 1, 1, 'R');
        }

        // Total de IVA y monto total
       // Total de IVA (alineado con COSTO UNIT. y valor centrado en IVA 5% y IVA 10%)
// Total IVA: abarcar desde el inicio de CANT. hasta el final
$pdf->SetFont('times', 'B', 10);
$pdf->Cell(95, 7, 'TOTAL IVA', 1, 0, 'R', 1); // Abarca hasta "COSTO UNIT."
$pdf->Cell(50, 7, number_format($cabecera['total_iva'], 0, ',', '.'), 1, 1, 'C', 1);

// Total: abarcar desde el inicio de CANT. hasta el final
$pdf->Cell(145, 7, 'TOTAL', 1, 0, 'R', 1); // Abarca la misma longitud
$pdf->Cell(35, 7, number_format($cabecera['monto_total'], 0, ',', '.'), 1, 1, 'C', 1);

// Total en letras: celda completa
$pdf->Ln(2);
$pdf->SetFont('times', 'B', 10);
$pdf->Cell(0, 7, 'TOTAL EN LETRAS', 1, 1, 'C', 1);
$pdf->SetFont('times', '', 10);
$total_en_letras = strtoupper($cabecera['totalletra']) . ' GUARANIES';
$pdf->Cell(0, 7, $total_en_letras, 1, 1, 'C');


    } else {
        $pdf->Cell(0, 5, 'No se encontraron detalles para esta factura.', 0, 1, 'C');
    }
} else {
    $pdf->Cell(0, 5, 'No se encontró la factura.', 0, 1, 'C');
}

// Generar salida
$pdf->Output('factura_proveedor.pdf', 'I');
?>
