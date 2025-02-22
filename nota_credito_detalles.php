<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalle de Nota de Crédito</title>
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
            color: #000;
            background-color: #ffc107; /* Amarillo */
            border-radius: 5px;
            padding: 5px 10px;
            text-transform: uppercase;
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
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h1 class="text-center titulo">Detalle de Nota de Crédito</h1>
                                <div class="box-tools">
                                    <a href="nota_credito_compras_index.php" class="btn btn-primary btn-sm pull-right" title="Volver">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php
                                if (!empty($_GET['id_factura'])) {
                                    $id_factura = $_GET['id_factura'];
                                  
                                    $notas = consultas::get_datos("SELECT * FROM v_nota_credito_detalles WHERE id_factura = $id_factura");

                                    if (!empty($notas)) {
                                        $nota = $notas[0];
                                ?>
                                <!-- Cabecera -->
                                <table class="detalle-cabecera">
                                    <tr>
                                        <th>ID Nota:</th>
                                        <td><?php echo $nota['id_nota_credito']; ?></td>
                                        
                                        <th>Fecha:</th>
                                        <td><?php echo $nota['fecha_nota']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Estado:</th>
                                        <td>
                                            <span class="estado">
                                                <?php echo $nota['estado']; ?>
                                            </span>
                                        </td>
                                        <th>Usuario:</th>
                                        <td><?php echo $nota['usuario']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>N° Factura:</th>
                                        <td><?php echo $nota['id_factura']; ?></td>
                                        <th>Monto:</th>
                                        <td><?php echo number_format($nota['monto_nota'], 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Motivo:</th>
                                        <td><?php echo $nota['motivo']; ?></td>
                                        <th>Sucursal:</th>
                                        <td><?php echo $nota['sucursal']; ?></td>
                                    </tr>
                                </table>
                                <?php
                                    } else {
                                        echo "<div class='alert alert-info'>No se encontraron datos para la Nota de Crédito.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>No se especificó un ID de factura válido.</div>";
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
