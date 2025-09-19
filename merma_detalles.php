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
            padding: 10px;
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
                                <i class="fa fa-recycle"></i> Detalle de la Merma
                            </h1>
                            <a href="mermas_index.php" class="btn btn-sm btn-primary pull-right">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                        <div class="box-body">
                            <?php
                            if (!empty($_GET['merma_id'])) {
                                $merma_id = $_GET['merma_id'];
                                $merma_id = consultas::get_datos("SELECT * FROM v_mermas WHERE merma_id = $merma_id");

                                if (!empty($merma_id)) {
                                    $cabecera = $merma_id[0];
                                    ?>
                                    <table class="detalle-cabecera">
                                        <tr>
                                            <th>ID Merma</th>
                                            <td><?= htmlspecialchars($cabecera['merma_id']) ?></td>
                                            <th>Fecha</th>
                                            <td><?= htmlspecialchars($cabecera['fecha_merma']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Descripción</th>
                                            <td colspan="3"><?= htmlspecialchars($cabecera['descripcion']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Responsable Inspección</th>
                                            <td><?= htmlspecialchars($cabecera['nombre_empleado']) ?></td>
                                            <th>Motivo</th>
                                            <td><?= htmlspecialchars($cabecera['motivo']) ?></td>
                                        </tr>
                                    </table>

                                    <h4><strong>Detalles de la Merma</strong></h4>
                                    <table class="table table-striped table-bordered table-detalle">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Artículo</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($merma_id as $index => $detalle): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($detalle['art_descri']) ?></td>
                                                    <td><?= number_format($detalle['cantidad'], 0, ",", ".") ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    echo "<div class='alert alert-info'>No se encontraron detalles de la merma.</div>";
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

    <?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>

</div>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function () {
    $('.table-detalle').DataTable();
});
</script>

</body>
</html>
