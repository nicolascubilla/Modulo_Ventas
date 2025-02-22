<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalle de Pedido de Compra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">

    <!-- Estilos -->
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
        <!-- Cabecera y barra de herramientas -->
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-13 col-md-13 col-sm-13">
                        <div class="box box-primary">
                            <div class="box-header">
                            <h1 class="text-center titulo">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 8px;">
        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708"/>
    </svg>
    Detalle de Orden de Compras
</h1>

                                <div class="box-tools">
                                    <a href="ordcompra_index.php" class="btn btn-primary btn-sm pull-right" title="Volver">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php
                                if (!empty($_GET['orden_id'])) {
            $orden_id = $_GET['orden_id'];
            $ordenes = consultas::get_datos("SELECT * FROM v_orden_compra_cabecera_detalle WHERE orden_id = $orden_id");

            if (!empty($ordenes)) {
                $cabecera = $ordenes[0];
                ?>

                <!-- Cabecera de la orden -->
                <table class="detalle-cabecera">
                    <tr>
                        <th>ID Orden:</th>
                        <td><?php echo $cabecera['orden_id']; ?></td>
                        <th>Fecha Orden:</th>
                        <td><?php echo $cabecera['fecha_orden']; ?></td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            <span class="estado 
                                <?php 
                                    echo $cabecera['estado'] == 'FINALIZADO' ? 'estado-finalizado' : 
                                    ($cabecera['estado'] == 'CERRADO' ? 'estado-cerrado' : 
                                         ($cabecera['estado'] == 'PENDIENTE' ? 'estado-pendiente' : 'estado-anulado'));
                                ?>">
                                <?php echo $cabecera['estado']; ?>
                            </span>
                        </td>
                        <th>Usuario:</th>
                        <td><?php echo $cabecera['usuario']; ?></td>
                    </tr>
                    <tr>
                        <th>Proveedor:</th>
                        <td><?php echo $cabecera['proveedor']; ?></td>
                        <th>Sucursal:</th>
                        <td><?php echo $cabecera['sucursal']; ?></td>
                    </tr>
                    <tr>
                        <th>Plazo de Entrega:</th>
                        <td><?php echo $cabecera['plazo_entrega']; ?> días</td>
                       
                    </tr>
                </table>

                <!-- Detalles de la orden -->
                <h4>Detalles de la Orden</h4>
                <table class="table-detalle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Material</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ordenes as $index => $detalle) {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . htmlspecialchars($detalle['nombre_material']) . "</td>";
                            echo "<td>" . number_format($detalle['cantidad'], 0, ",", ".") . "</td>";
                            echo "<td>" . number_format($detalle['costo_unitario'], 0, ",", ".") . "</td>";
                            echo "<td>" . number_format($detalle['subtotal'], 0, ",", ".") . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        <!-- Fila para el total general -->
    <tr>
    <td colspan="4" style="text-align: left; border-top: 2px solid #000; font-weight: bold; padding-right: 10px;">
        Total General
    </td>
    <td style="font-weight: bold; color: #003366; border-top: 2px solid #000; text-align: center;">
        <?php echo number_format($detalle['total'], 0, ",", "."); ?>
    </td>
</tr>
                    </tbody>
                </table>

                <?php
            } else {
                echo "<div class='alert alert-info'>No se encontraron detalles para la orden N° " . htmlspecialchars($orden_id) . ".</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>No se ha especificado una orden válida.</div>";
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
