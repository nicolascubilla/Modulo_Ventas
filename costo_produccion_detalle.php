<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalle de la Merma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }
        .titulo {
            font-weight: bold;
            font-size: 26px;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }
        .detalle-cabecera, .table-detalle {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .detalle-cabecera th, .detalle-cabecera td,
        .table-detalle th, .table-detalle td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        .detalle-cabecera th {
            background-color: #6c757d;
            color: white;
            text-align: left;
        }
        .detalle-cabecera td {
            background-color: #f8f9fa;
        }
        .table-detalle th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .table-detalle td {
            text-align: center;
            background-color: #ffffff;
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
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border text-center">
                            <h1 class="titulo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-currency-exchange" viewBox="0 0 16 16">
  <path d="M0 5a5 5 0 0 0 4.027 4.905 6.5 6.5 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05q-.001-.07.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.5 3.5 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98q-.004.07-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5m16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0m-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674z"/>
</svg> Detalle del Costo de Producción
                            </h1>
                            <a href="costo_produccion_index.php" class="btn btn-sm btn-primary pull-right">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                        <div class="box-body">
                            <?php
                            if (!empty($_GET['control_id'])) {
                                $id = (int) $_GET['control_id'];
                                $detalle_costo = consultas::get_datos("SELECT * FROM v_costo_produccion_detalle WHERE control_id = $id");

                                if (!empty($detalle_costo)) {
                                    $cabecera = $detalle_costo[0];
                                    ?>
                                    <!-- CABECERA -->
                                    <table  class="detalle-cabecera">
    <tr>
        <th>ID Control</th>
        <td><?= htmlspecialchars($cabecera['control_id']) ?></td>
        <th>Calidad ID</th>
        <td><?= htmlspecialchars($cabecera['calidad_id']) ?></td>
        <th>Fecha</th>
        <td><?= htmlspecialchars($cabecera['fecha']) ?></td>
    </tr>
    <tr>
        <th>Estado</th>
        <td><?= htmlspecialchars($cabecera['nombre']) ?></td>
        <th>Tiempo</th>
        <td><?= htmlspecialchars($cabecera['tiempo_invertido']) ?></td>
        <th>Sucursal</th>
        <td><?= htmlspecialchars($cabecera['suc_descri']) ?></td>
    </tr>
</table>


                                    <!-- DETALLE COSTO -->
                                    <h4><strong>Detalles del costo</strong></h4>
                                    <table  class="table table-striped table-bordered table-detalle">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Materiales utilizados</th>
                                                <th>Cantidad utilizada</th>
                                                <th>Costo unitario</th>
                                                <th>Costo Materiales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detalle_costo as $index => $detalle): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($detalle['materiales_utilizados']) ?></td>
                                                    <td><?= number_format($detalle['cantidad_utilizada'], 0, ",", ".") ?></td>
                                                    <td><?= number_format($detalle['costo_unitario'], 0, ",", ".") ?></td>
                                                    <td><?= number_format($detalle['costo_materiales'], 0, ",", ".") ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <!-- MERMAS Y PÉRDIDAS -->
                                    <?php
                                    $mermas_perdidas = consultas::get_datos("SELECT * FROM v_mermas_perdidas WHERE control_id = $id");
                                    if (!empty($mermas_perdidas)) {
                                        ?>
                                        <h4><strong>Detalles de pérdidas</strong></h4>
                                        <table class="table table-striped table-bordered table-detalle">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Artículo</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Costo merma</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($mermas_perdidas as $index => $detalle): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= htmlspecialchars($detalle['art_descri']) ?></td>
                                                        <td><?= number_format($detalle['cantidad'], 0, ",", ".") ?></td>
                                                        <td><?= number_format($detalle['art_preciov'], 0, ",", ".") ?></td>
                                                        <td><?= number_format($detalle['costo_merma_aprox'], 0, ",", ".") ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php
                                    } else {
                                        echo "<div class='alert alert-info'>No se encontraron registros de pérdidas o mermas.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-info'>No se encontraron detalles del costo.</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>No se ha especificado un control válido.</div>";
                            }
                            ?>
                           <?php
$mermas_costo_final = consultas::get_datos("SELECT * FROM v_costo_produccion_final WHERE id_produccion = $id");
if (!empty($mermas_costo_final)) {
    ?>
    <h4><strong>Resumen del costo final de producción</strong></h4>
    <table class="table table-striped table-bordered table-detalle">
        <thead>
            <tr>
                <th>#</th>
                <th>Costo Materiales</th>
                <th>Costo de merma</th>
                <th>Costo total producción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mermas_costo_final as $index => $detalle): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= number_format($detalle['costo_materiales'], 0, ",", ".") ?></td>
                    <td><?= number_format($detalle['costo_merma_aprox'], 0, ",", ".") ?></td>
                    <td><?= number_format($detalle['costo_total_produccion'], 0, ",", ".") ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}
?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>

</div>


</body>
</html>
