<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalles de ajustes de Compras</title>
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
    }

    .box {
        background: #ffffff;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .box-header {
        background-color:rgb(160, 210, 241);
        color: #ffffff;
        padding: 15px;
        border-bottom: 1px solid #ddd;
        border-radius: 4px 4px 0 0;
    }

    .box-header .titulo {
        margin: 0;
        font-size: 20px;
    }

    .box-tools a.btn {
        background-color: #0056b3;
        color: #ffffff;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 4px;
    }

    .box-tools a.btn:hover {
        background-color: #003f7f;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table th {
        background-color:rgb(35, 62, 78);
        color: #ffffff;
    }

    table tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    table tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    h3 {
        color: #333;
        font-size: 18px;
        margin-top: 20px;
    }

    .alert {
        padding: 15px;
        border-radius: 4px;
        margin-top: 10px;
        font-size: 14px;
    }

    .alert-info {
        background-color: #d9edf7;
        color: #31708f;
        border: 1px solid #bce8f1;
    }

    .alert-danger {
        background-color: #f2dede;
        color: #a94442;
        border: 1px solid #ebccd1;
    }
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
    <div class="col-lg-12 col-md-12 col-sm-12">  <!-- Cambié col-lg-13 a col-lg-12 -->
        <div class="box box-primary">
            <div class="box-header">
  
                <h1 class="titulo">Ajuste de Inventario</h1>
                <div class="box-tools">
                <a href="ajuste_compra_index.php" class="btn" title="Volver">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
                </div>
                </div>
                <div class="box-body">
                <?php
                if (!empty($_GET['id_ajuste'])) {
                    $id_ajuste = $_GET['id_ajuste'];
                    $facturas = consultas::get_datos("SELECT * FROM v_ajustes_compras_cabecera_detalle WHERE id_ajuste = $id_ajuste");

                    if (!empty($facturas)) {
                        $cabecera = $facturas[0];
                        ?>

                        <!-- Cabecera de la factura -->
                        <table>
                            <tr>
                                <th style="width: 25%;">Ajuste N°</th>
                                <td style="width: 25%;"><?= htmlspecialchars($cabecera['id_ajuste']) ?></td>
        
                            </tr>
                            <tr>
                                <th>Fecha de Ajuste</th>
                                <td><?= htmlspecialchars($cabecera['fecha_ajuste']) ?></td>
                               
                            </tr>
                            <tr>
                                <th>Descripción</th>
                                <td colspan="3"><?= htmlspecialchars($cabecera['descripcion']) ?></td>
                            </tr>
                            <tr>
                                <th>Usuario</th>
                                <td colspan="3"><?= htmlspecialchars($cabecera['usu_nick']) ?></td>
                            </tr>
                        </table>

                        <!-- Detalles del ajuste -->
                        <h3>Detalles del Ajuste</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 10%;">#</th>
                                    <th style="width: 60%;">Material</th>
                                    <th style="width: 30%;">Cantidad Ajustada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($facturas as $index => $detalle): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($detalle['nombre_material']) ?></td>
                                        <td><?= number_format($detalle['cantidad_ajustada'], 0, ",", ".") ?></td>
                                    </tr>
                                <?php endforeach; ?>
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

    
    


<?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>
    
</body>
</html>
