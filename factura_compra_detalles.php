<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalle de Factura de Compras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }
        .titulo {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }
        .detalle-cabecera, .table-detalle {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .detalle-cabecera th, .detalle-cabecera td, .table-detalle th, .table-detalle td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .detalle-cabecera th, .table-detalle th {
            background-color: #5a5c69;
            color: #fff;
            text-align: center;
        }
        .detalle-cabecera td {
            background-color: #f8f9fc;
        }
        .table-detalle td {
            text-align: center;
            background-color: #f8f9fc;
        }
        .estado {
            font-weight: bold;
            color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            text-transform: uppercase;
        }
        .estado-finalizado { background-color: #28a745; }
        .estado-pendiente { background-color: #ffc107; }
        .estado-cerrado { background-color: #20B2AA; }
        .estado-anulado { background-color: #dc3545; }
        .total {
            font-weight: bold;
            background-color: #343a40;
            color: #fff;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-info { background-color: #d1ecf1; color: #0c5460; }
        .alert-danger { background-color: #f8d7da; color: #721c24; }
    </style>
    <?php
    session_start();
    require 'menu/css_lte.ctp'; 
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            
                <div class="row">
                    <div class="col-lg-13 col-md-13 col-sm-13">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h1 class="text-center titulo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 8px;">
                                        <path d="M3.5 0a.5.5 0 0 0-.5.5v15a.5.5 0 0 0 .757.429L6 14.667l2.743 1.262a.5.5 0 0 0 .514 0L12 14.667l2.243 1.262A.5.5 0 0 0 15 15.5v-15a.5.5 0 0 0-.757-.429L12 1.333 9.257.071a.5.5 0 0 0-.514 0L6 1.333 3.757.071A.5.5 0 0 0 3.5 0z"/>
                                    </svg>
                                Factura de Compras
                                </h1>
                                <div class="box-tools">
                                    <a href="factura_compra_index.php" class="btn btn-primary btn-sm pull-right" title="Volver">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php
                                if (!empty($_GET['id_factura'])) {
                                    $id_factura = $_GET['id_factura'];
                                    $facturas = consultas::get_datos("SELECT * FROM v_factura_compra_cabecera_detalle WHERE id_factura = $id_factura");

                                    if (!empty($facturas)) {
                                        $cabecera = $facturas[0];
                                        ?>

                                        <!-- Cabecera de la factura -->
                                        <table class="detalle-cabecera">
                                            <tr>
                                                <th>ID Factura:</th>
                                                <td><?php echo $cabecera['id_factura']; ?></td>
                                                <th>Fecha Emisión:</th>
                                                <td><?php echo $cabecera['fecha_emision']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Proveedor:</th>
                                                <td><?php echo $cabecera['proveedor']; ?></td>
                                                <th>Monto Total:</th>
                                                <td><?php echo number_format($cabecera['monto_total'], 0, ",", "."); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Estado:</th>
                                                <td>
                                                    <span class="estado 
                                                        <?php 
                                                            echo $cabecera['estado_nombre'] == 'FINALIZADO' ? 'estado-finalizado' : 
                                                            ($cabecera['estado_nombre'] == 'CERRADO' ? 'estado-cerrado' : 
                                                                 ($cabecera['estado_nombre'] == 'PENDIENTE' ? 'estado-pendiente' : 'estado-anulado'));
                                                        ?>">
                                                        <?php echo $cabecera['estado_nombre']; ?>
                                                    </span>
                                                </td>
                                                <th>Usuario:</th>
                                                <td><?php echo $cabecera['usuario_nick']; ?></td>

                                               
                                            </tr>
                                            <th>Orden N°:</th>
                                            <td><?php echo $cabecera['orden_id']; ?></td>
                                            <th>Condición:</th>
                                            <td><?php echo $cabecera['condicion']; ?></td>
                                            </tr>
                                            <th>Timbrado:</th>
                                            <td><?php echo $cabecera['timbrado']; ?></td>
                                            <th>Metodo de pago:</th>
                                            <td><?php echo $cabecera['metodo_pago_nombre']; ?></td>
                                            </tr>
                                          
                                        </table>

                                        <!-- Detalles de la factura -->
                                        <h4 class="text-center titulo">Detalles de la Factura</h4>
                                        <table class="table-detalle">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Material</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Iva 5</th>
                                                    <th>Iva 10</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($facturas as $index => $detalle) {
                                                    echo "<tr>";
                                                    echo "<td>" . ($index + 1) . "</td>";
                                                    echo "<td>" . htmlspecialchars($detalle['nombre_material']) . "</td>";
                                                    echo "<td>" . number_format($detalle['cantidad'], 0, ",", ".") . "</td>";
                                                    echo "<td>" . number_format($detalle['costo_unitario'], 0, ",", ".") . "</td>";
                                                    echo "<td>" . number_format($detalle['iva_5'], 0, ",", ".") . "</td>";
                                                    echo "<td>" . number_format($detalle['iva_10'], 0, ",", ".") . "</td>";
                                                    echo "<td>" . number_format($detalle['subtotal'], 0, ",", ".") . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="5" style="text-align: right; font-weight: bold;">Total IVA:</td>
                                                    <td><?php echo number_format($cabecera['total_iva'], 0, ",", "."); ?></td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>

                                        <?php
                                    } else {
                                        echo "<div class='alert alert-info'>No se encontraron detalles para la factura N° " . htmlspecialchars($id_factura) . ".</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>No se ha especificado una factura válida.</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
