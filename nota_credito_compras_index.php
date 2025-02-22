<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notas de Crédito</title>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    
    <!-- Estilos personalizados -->
    <style>
        .estado {
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
        }
        .estado-aprobado {
            background-color: #28a745; /* Verde */
            color: white;
        }
        .estado-anulado {
            background-color: #ff0000; /* Rojo */
            color: white;
        }
        .estado-pendiente {
            background-color: #f39c12; /* Amarillo */
            color: white;
        }
        .btn-info:hover {
            background-color: #17a2b8;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .img-drop-shadow {
            filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));
        }
    </style>

    <?php 
    session_start();
    require 'menu/css_lte.ctp'; // Archivos CSS personalizados del sistema
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
                                <img src="img/nota_credito.jpg" alt="Nota Crédito" width="50" height="50" class="img-drop-shadow">
                                <h2 class="box-title">Notas de Crédito</h2>
                                <div class="box-tools">
                                    <a href="nota_credito_compras_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Agregar Nota Crédito
                                    </a>
                                </div>
                            </div>

                            <div class="box-body">
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                    <div class="alert alert-success" role="alert" id="mensaje">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                                    </div>
                                <?php } ?> 

                                <?php
                                $notas = consultas::get_datos("SELECT * FROM v_nota_credito_cabecera");
                                if (!empty($notas)) { ?>
                                    <div class="table-responsive">
                                        <table id="notasTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">N° Nota</th>
                                                    <th class="text-center">N° Factura</th>
                                                    <th class="text-center">Fecha Nota</th>
                                                    <th class="text-center">Monto Nota</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Motivo</th>
                                                    <th class="text-center">Sucursal</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($notas as $nota) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $nota['id_nota_credito']; ?></td>
                                                        <td class="text-center"><?php echo $nota['id_factura']; ?></td>
                                                        <td class="text-center"><?php echo $nota['fecha_nota']; ?></td>
                                                        <td class="text-right"><?php echo number_format($nota['monto_nota']); ?></td>
                                                        <td class="text-center">
                                                            <span class="estado 
                                                                <?php 
                                                                    echo $nota['estado'] === 'APROBADO' ? 'estado-aprobado' : 
                                                                         ($nota['estado'] === 'ANULADO' ? 'estado-anulado' : 'estado-pendiente'); 
                                                                ?>">
                                                                <?php echo $nota['estado']; ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo $nota['motivo']; ?></td>
                                                        <td><?php echo $nota['sucursal']; ?></td>
                                                        <td><?php echo $nota['usuario']; ?></td>
                                                        <td class="text-center">
                                                            <a href="nota_credito_print.php?id_nota=<?php echo $nota['id_nota_credito']; ?>" 
                                                               class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="_blank">
                                                                <i class="glyphicon glyphicon-print"></i> Imprimir
                                                            </a>
                                                            <a href="nota_credito_detalles.php?id_factura=<?php echo $nota['id_factura']; ?>" 
                                                               class="btn btn-info btn-sm" data-title="Detalles" rel="tooltip">
                                                                <i class="fa fa-info-circle"></i> Detalles
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info flat">
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                        No se han registrado notas de crédito.
                                    </div> 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
        <?php require 'menu/js_lte.ctp'; ?>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#notasTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                    }
                });
                $("#mensaje").delay(6000).slideUp(200);
            });
        </script>
    </div>
</body>
</html>
