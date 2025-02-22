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

// create new PDF document // CODIFICACION POR DEFECTO ES UTF-8
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('VIRGILIO CUBILLA');
$pdf->SetTitle('Reporte de Articulos');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->setPrintHeader(false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins POR DEFECTO
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(8,10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks SALTO AUTOMATICO Y MARGEN INFERIOR
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// ---------------------------------------------------------
// TIPO DE LETRA
$pdf->SetFont('times', 'B', 12);

// AGREGAR PAGINA
$pdf->AddPage('P', 'LEGAL');

$pdf->Cell(0, 0, "REPORTE DE ARTICULOS", 0, 1, 'C');
//SALTO DE LINEA
$pdf->Ln();
//COLOR DE TABLA
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);

//CONSULTAS DE LOS REGISTROS
if (!empty(isset($_REQUEST['vdesde'])) && !empty(isset($_REQUEST['vhasta']))) {
    if ($_REQUEST['opcion'] == "1") { //por codigo
        $articulos = consultas::get_datos("select * from v_articulo "
                        . "where art_cod between " . $_REQUEST['vdesde'] . " and " . $_REQUEST['vhasta']."order by art_cod");
    } else {
        if($_REQUEST['opcion']=="2"){//por marca
         $articulos = consultas::get_datos("select * from v_articulo "
                        . "where mar_descri between '" . $_REQUEST['vdesde'] . "' and '" . $_REQUEST['vhasta']."' order by mar_descri");   
        }else{
         $articulos = consultas::get_datos("select * from v_articulo "
                        . "where art_descri between '" . $_REQUEST['vdesde'] . "' and '" . $_REQUEST['vhasta']."' order by art_descri");
        }        
    }
} else {
    $articulos = consultas::get_datos("select * from v_articulo order by art_cod");
}
if (!empty($articulos)) {
    // Header        
    $pdf->SetFillColor(180, 180, 180);
    $pdf->Cell(25, 5, '#', 1, 0, 'C', 1);
    $pdf->Cell(50, 5, 'Articulo', 1, 0, 'C', 1);
    $pdf->Cell(35, 5, 'Prec. compra', 1, 0, 'C', 1);
    $pdf->Cell(35, 5, 'Prec. venta', 1, 0, 'C', 1);
    $pdf->Cell(0, 5, 'Impuesto', 1, 0, 'C', 1);

    $pdf->Ln();
    $pdf->SetFont('', '');
    $pdf->SetFillColor(255, 255, 255);


    foreach ($articulos as $articulo) {
        $pdf->Cell(25, 5, $articulo['art_cod'], 1, 0, 'C', 1);
        $pdf->Cell(50, 5, $articulo['art_descri']." ".$articulo['mar_descri'], 1, 0, 'L', 1);
        $pdf->Cell(35, 5, $articulo['art_precioc'], 1, 0, 'C', 1);
        $pdf->Cell(35, 5, $articulo['art_preciov'], 1, 0, 'C', 1);
        $pdf->Cell(0, 5, $articulo['tipo_descri'], 1, 0, 'C', 1);
        $pdf->Ln();
    }
}else{
    $pdf->Cell(0, 0, "No se encontraron registros según el filtro", 0, 1, 'C');
}




//SALIDA AL NAVEGADOR
$pdf->Output('reporte_articulo.pdf', 'I');
?>
