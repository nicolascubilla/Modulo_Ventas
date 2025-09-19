<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalles del Control de Producción</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            padding: 20px;
            background-color: #ffffff;
            min-height: calc(100vh - 100px);
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

        .detalle-cabecera th, .detalle-cabecera td,
        .table-detalle th, .table-detalle td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .detalle-cabecera th, .table-detalle th {
            background-color: #696969;
            color: #fff;
        }

        .detalle-cabecera td, .table-detalle td {
            background-color: #F8F8FF;
        }

        .estado-anulado, .estado-pendiente, .estado-finalizado {
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
        }

        .estado-anulado { background-color: #ff0000; }
        .estado-pendiente { background-color: #f39c12; }
        .estado-finalizado { background-color: #006400; }

        .btn:hover { background-color: #0056b3; }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
       

        .alert-info { background-color: #d9edf7; color: #31708f; }
        .alert-danger { background-color: #f2dede; color: #a94442; }

        
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

        <!-- Contenedor principal -->
        <div class="content-wrapper">
            <section class="content">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="titulo">Detalles del Control de Producción</h2>
                        <div class="box-tools">
                            <a href="control_produccion_index.php" class="btn btn-primary btn-md" data-title="Volver" rel="tooltip">
                                Volver <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                        
                <?php
                if (isset($_GET['vcontrol_id']) && !empty($_GET['vcontrol_id'])) {
                    $vcontrol_id = (int) $_GET['vcontrol_id'];
                    $control_pro = consultas::get_datos("SELECT * FROM v_control_produccion_cabe WHERE control_id = $vcontrol_id");

                    if (!empty($control_pro)) {
                        $cabecera = $control_pro[0];
                        ?>
                        <table class="detalle-cabecera">
                            <tr>
                                <th>ID Control:</th>
                                <td><?= htmlspecialchars($cabecera['control_id']) ?></td>
                                <th>N° Pedido:</th>
                                <td><?= htmlspecialchars($cabecera['pedido_id']) ?></td>
                                <th>Fecha Avance:</th>
                                <td><?= htmlspecialchars($cabecera['fecha_avance']) ?></td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td class="text-center">
                                    <span class="estado-<?= strtolower($cabecera['estado']) ?>">
                                        <?= htmlspecialchars($cabecera['estado']) ?>
                                    </span>
                                </td>
                                <th>Progreso:</th>
                                <td><?= htmlspecialchars($cabecera['progreso']) ?></td>
                                <th>Tiempo invertido:</th>
                                <td><?= htmlspecialchars($cabecera['tiempo_invertido']) ?></td>
                            </tr>
                            <tr>
                                <th>Sucursal:</th>
                                <td><?= htmlspecialchars($cabecera['suc_descri']) ?></td>
                                <th>Comentarios:</th>
                                <td><?= htmlspecialchars($cabecera['comentarios']) ?></td>
                                <th>Usuario:</th>
                                <td><?= htmlspecialchars($cabecera['usu_nick']) ?></td>
                            </tr>
                        </table>

                        <h4>Detalles de la Producción</h4>
                        <?php
                        $control_detalle = consultas::get_datos("SELECT * FROM v_control_produccion_detalle WHERE control_id = $vcontrol_id");

                        if (!empty($control_detalle)) {
                            ?>
                            <div class="table-responsive">
                                <table class="table-detalle">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                            <th>Etapas de Producción</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($control_detalle as $index => $detalle): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($detalle['descripcion_articulo']) ?></td>
                                                <td><?= htmlspecialchars($detalle['cantidad']) ?></td>
                                                <td><?= htmlspecialchars($detalle['nombre_etapa']) ?></td>
                                                <td><?= htmlspecialchars($detalle['estado']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<div class='alert alert-info'>No se encontraron detalles para el control N° $vcontrol_id.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>No se encontró información para el control solicitado.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>No se ha especificado un control válido.</div>";
                }
                ?>
            </>
        </div>
    </div>

    <?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>

    <script>
        $(document).ready(function () {
            $(".alert").delay(4000).slideUp(200);
        });
    </script>
</body>
</html>
