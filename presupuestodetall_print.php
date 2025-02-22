<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';
session_start();
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
$pdf->SetTitle('REPORTE DE PRESUPUESTO');
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
$pdf->SetFont('times', 'B', 18);

// AGREGAR PAGINA
$pdf->AddPage('P', 'LEGAL');

$pdf->Cell(0, 0, "REPORTE DE PRESUPUESTO",'B', 0, 'C',0);
$pdf->Ln();
//SALTO DE LINEA
$pdf->Ln();
$pdf->SetFont('', 'B', 12);
$pdf->SetFont('times', '', 11);

if (!empty(isset($_REQUEST['opcion']))) {
    switch ($_REQUEST['opcion']) {
        case 1: //por fecha
            $cabeceras = consultas::get_datos("select *,to_char(now(),'dd/mm/yyyy HH24:MI') as horafecha "
                            . "from v_presupuesto_producc_cabecera where fecha::date between '" . $_REQUEST['vdesde'] . "' and '" . $_REQUEST['vhasta'] . "' and id_sucursal =".$_SESSION['id_sucursal']." order by pre_cod");
            break;
        case 2: //por cliente
            $cabeceras = consultas::get_datos("select *,to_char(now(),'dd/mm/yyyy HH24:MI') as horafecha "
                            . "from v_presupuesto_producc_cabecera where cli_cod in(".$_REQUEST['vcliente'].") and id_sucursal =".$_SESSION['id_sucursal']." order by pre_cod");
            break;        
        case 3: //por articulo
            $cabeceras = consultas::get_datos("select *,to_char(now(),'dd/mm/yyyy HH24:MI') as horafecha "
                            . "from v_presupuesto_producc_cabecera where pre_cod in(select pre_cod from detalle_presupuesto where art_cod in(".$_REQUEST['varticulo'].")) and id_sucursal =".$_SESSION['id_sucursal']." order by pre_cod");
            break;
        case 4: //por empleado
            $cabeceras = consultas::get_datos("select *,to_char(now(),'dd/mm/yyyy HH24:MI') as horafecha "
                            . "from v_presupuesto_producc_cabecera where emp_cod in(".$_REQUEST['vempleado'].") and id_sucursal =".$_SESSION['id_sucursal']." order by pre_cod");
            break;          
    }
} else {
    $cabeceras = consultas::get_datos("select *,to_char(now(),'dd/mm/yyyy HH24:MI') as horafecha from v_presupuesto_producc_cabecera where pre_cod=" . $_REQUEST['vpre_cod']);
}

if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        $pdf->Cell(130, 2, 'CLIENTE: ' . $cabecera['cli_cod'] . " - " . $cabecera['cliente'], 0, '', 'L');
        $pdf->Cell(80, 2, 'FECHA: ' . $cabecera['fecha'], 0, 1);
        $pdf->Cell(130, 2, 'ELABORADO POR: ' . $cabecera['empleado'], 0, '', 'L');
        $pdf->Cell(80, 2, 'ESTADO: ' . $cabecera['estado'], 0, 1);
        $pdf->Cell(130, 2, 'SUCURSAL: ' . $cabecera['suc_descri'], 0, '', 'L');
        $pdf->Cell(80, 2, 'PEDIDO N°: ' . $cabecera['pre_cod'], 0, 1);
        $pdf->Ln();
        $pdf->Ln();
//COLOR DE TABLA
        $detalles = consultas::get_datos("select * from v_detalle_presupuesto where pre_cod=" . $cabecera['pre_cod']);
        if (!empty($detalles)) {
            $pdf->SetFont('', 'B', 10);
            // Header        
            $pdf->SetFillColor(180, 180, 180);
            $pdf->Cell(15, 5, '#', 1, 0, 'C', 1);
            $pdf->Cell(75, 5, 'DESCRIPCION', 1, 0, 'C', 1);
            $pdf->Cell(15, 5, 'CANT.', 1, 0, 'C', 1);
            $pdf->Cell(25, 5, 'PRECIO', 1, 0, 'C', 1);
            $pdf->Cell(0, 5, 'SUBTOTAL', 1, 0, 'C', 1);

            $pdf->Ln();
            $pdf->SetFont('', '');
            $pdf->SetFillColor(255, 255, 255);
            //CONSULTAS DE LOS REGISTROS

            foreach ($detalles as $detalle) {
                $pdf->Cell(15, 5, $detalle['art_cod'], 1, 0, 'C', 1);
                $pdf->Cell(75, 5, $detalle['art_descri'] . " " . $detalle['mar_descri'], 1, 0, 'L', 1);
                $pdf->Cell(15, 5, $detalle['pre_cant'], 1, 0, 'C', 1);
                $pdf->Cell(25, 5, number_format($detalle['pre_precio'], 0, ",", "."), 1, 0, 'C', 1);
                $pdf->Cell(0, 5, number_format($detalle['subtotal'], 0, ",", "."), 1, 0, 'C', 1);
                $pdf->Ln();
            }
            $pdf->SetFillColor(180, 180, 180);
            $pdf->SetFont('', 'B', 10);
            $pdf->Cell(15, 5, "TOTAL", 1, 0, 'L', 1);
            $pdf->Cell(140, 5, $cabecera['totalletra'], 1, 0, 'L', 1);
            $pdf->Cell(0, 5, number_format($cabecera['total'], 0, ",", "."), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->Cell(0, 0, "", 'B',0,'C',0);            
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('', '');
            $pdf->SetFillColor(255, 255, 255);
        } else {
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('', 'B', 12);
            $pdf->Cell(0, 5, "El pedido no posee detalles cargados...", 0, 0, 'L', 1);
            $pdf->Ln();
            $pdf->Cell(0, 0, "", 'B',0,'C',0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('', '');
            $pdf->SetFillColor(255, 255, 255);
        }
    }
} else {
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('', 'B', 12);
    $pdf->Cell(0, 5, "No se encontraron registros", 0, 0, 'L', 1);
}



//SALIDA AL NAVEGADOR
$pdf->Output('reporte_marca.pdf', 'I');
?>
