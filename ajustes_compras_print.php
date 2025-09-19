<?php
require_once './tcpdf/tcpdf.php';
require_once 'clases/conexion.php';

session_start();

/**
 * Clase personalizada para pie de página
 */
class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(
            0, 0,
            'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(),
            0, 0, 'R'
        );
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Reporte de Ajuste de Compra');
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('times', '', 11);
$pdf->AddPage('P', 'LEGAL');

// Logo
$logo_path = 'C:/wamp64/www/lp3/img/carpin_la_familyfull.jpg';
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 13, 22);
    $pdf->Ln(14);
} else {
    $pdf->Cell(0, 10, 'Logo no encontrado.', 0, 1, 'C');
}

// Título
$pdf->SetFont('times', 'B', 16);
$pdf->Cell(0, 0, 'REPORTE DE AJUSTES DE COMPRA', 'B', 0, 'C');
$pdf->Ln(12);

// ---- Datos de la orden ----
$id_ajuste = isset($_REQUEST['id_ajuste']) ? intval($_REQUEST['id_ajuste']) : 0;

$cabeceras = consultas::get_datos(
    "SELECT DISTINCT * 
     FROM v_ajustes_compras_cabecera_detalle 
     WHERE id_ajuste = $id_ajuste"
);

if (!empty($cabeceras)) {
    $cab = $cabeceras[0];

    // Información principal
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(0, 6, 'Ajuste N° ' . $id_ajuste, 0, 1, 'C');
    $pdf->Ln(4);

    $pdf->SetFont('times', '', 10);
    $pdf->Cell(100, 6, 'Descripción: ' . $cab['descripcion'], 0, 0, 'L');
    $pdf->Cell(80, 6, 'Sucursal: ' . $cab['sucursal'], 0, 1, 'L');

    $pdf->Cell(100, 6, 'Usuario: ' . $cab['usu_nick'], 0, 0, 'L');
    $pdf->Cell(80, 6, 'Fecha: ' . $cab['fecha_ajuste']. ' HS.', 0, 1, 'L');

    $pdf->Ln(6);

    // ---- Detalle de materiales ----
    $detalles = consultas::get_datos(
        "SELECT * 
         FROM v_ajustes_compras_cabecera_detalle 
         WHERE id_ajuste = $id_ajuste
         ORDER BY nombre_material"
    );

    if (!empty($detalles)) {
        $pdf->SetFont('times', 'B', 10);
        $pdf->SetFillColor(220, 220, 220);

        // Encabezados de la tabla
        $pdf->Cell(25, 8, 'Cant.', 1, 0, 'C', 1);
        $pdf->Cell(0, 8, 'Material', 1, 1, 'C', 1);

        $pdf->SetFont('times', '', 10);
        foreach ($detalles as $d) {
            $pdf->Cell(25, 7, $d['cantidad_ajustada'], 1, 0, 'C');
            $pdf->Cell(0, 7, $d['nombre_material'], 1, 1, 'L');
        }
    } else {
        $pdf->Cell(0, 6, 'No se encontraron detalles del ajuste.', 0, 1, 'C');
    }
} else {
    $pdf->Ln(10);
    $pdf->Cell(0, 6, 'No se encontró el ajuste de compra.', 0, 1, 'C');
}

// Salida del PDF
$pdf->Output('ajustes_compras_print.pdf', 'I');
