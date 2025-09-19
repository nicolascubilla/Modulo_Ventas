<?php
require_once('./tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 0, '', 'T');
        $this->Ln(2);
        $this->Cell(90, 6, 'Autor: Marcos Cubilla', 0, 0, 'L');
        $this->Cell(90, 6, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Crear el PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Marcos Cubilla');
$pdf->SetTitle('PRESUPUESTO');
$pdf->setPrintHeader(false);
$pdf->SetMargins(15, 30, 15);
$pdf->SetAutoPageBreak(TRUE, 20);

// Nueva página
$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('times', '', 12);

// Logo en la esquina
$logo_path = 'C:/wa'; // asegúrate de usar la extensión correcta
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 10, 35); // x=15, y=10, ancho=35mm
}

// Encabezado arriba del título
$pdf->SetFont('times', 'B', 12);
$pdf->Cell(0, 6, "C.M.C", 0, 1, 'C');

// Título principal
$pdf->SetFont('times', 'B', 14);
$pdf->Cell(0, 8, "PRESUPUESTO", 0, 1, 'C');
$pdf->Ln(5);


// Cabecera
$pdf->SetFont('times', '', 11);

// Número y Fecha
$pdf->Cell(95, 6, "Número: 0000001", 0, 0, 'L');
$pdf->Cell(95, 6, "Fecha: " . date("d/m/Y H:i"), 0, 1, 'R');
$pdf->Ln(2);

// Cliente (izquierda) y Contratista + RUC (derecha)
$pdf->Cell(95, 6, "Cliente: Parroquia San Buenaventura", 0, 0, 'L');
$pdf->Cell(95, 6, "Construcción: Marcos Cubilla - RUC: 2358721-0", 0, 1, 'R');

// RUC del cliente (debajo del cliente, alineado izquierda)
$pdf->Cell(95, 6, "C.I./RUC: 80103008-0", 0, 1, 'L');
$pdf->Ln(4);

// Tabla de detalles
$pdf->SetFont('times', 'B', 11);
$pdf->SetFillColor(230,230,230);
$pdf->Cell(80, 8, "Detalle del Producto", 1, 0, 'C', 1);
$pdf->Cell(30, 8, "Cantidad", 1, 0, 'C', 1);
$pdf->Cell(40, 8, "Precio Unitario", 1, 0, 'C', 1);
$pdf->Cell(40, 8, "Sub Total", 1, 1, 'C', 1);

$pdf->SetFont('times', '', 11);

// Datos fijos
$items = [
    ["Chapa acústica", 30, 85600, 25200000],
    ["Cemento valemi", 60, 65000, 3900000],
    ["Ladrillo común", 650, 2308, 1350000],
    ["Arena lavada", 3, 500000, 1500000],
    ["Cable 4 mm inpa", 2, 680000, 1160000],
    ["Cable 2 mm inpa", 1, 350000, 350000],
];

foreach ($items as $row) {
    $pdf->Cell(80, 8, $row[0], 1, 0, 'L');
    $pdf->Cell(30, 8, number_format($row[1], 0, ",", "."), 1, 0, 'C');
    $pdf->Cell(40, 8, number_format($row[2], 0, ",", "."), 1, 0, 'R');
    $pdf->Cell(40, 8, number_format($row[3], 0, ",", "."), 1, 1, 'R');
}

$pdf->SetFont('times', 'B', 11);
$pdf->Cell(150, 8, "Total del Presupuesto:", 1, 0, 'R', 1);
$pdf->Cell(40, 8, number_format(33460000, 0, ",", "."), 1, 1, 'R', 1);
$pdf->Ln(5);

$pdf->SetFont('times', 'I', 11);
$pdf->Cell(0, 6, "Total en letras: Treinta y tres millones cuatrocientos sesenta mil guaraníes.", 0, 1, 'L');
$pdf->Ln(20);

// Firma
$pdf->Ln(20); // espacio antes de la firma
// Espacio antes de la firma
$pdf->Ln(15);
$pdf->Cell(0, 6, 'Marcos Cubilla', 0, 1, 'C');
// Línea de firma (centrada)
$pdf->Cell(0, 6, '_________________________', 0, 1, 'C');

// Nombre del firmante


// Identificador / Cargo
$pdf->Cell(0, 6, 'C.M.C', 0, 1, 'C');


// Salida
$pdf->Output('presupuesto_estatico.pdf', 'I');
