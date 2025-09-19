<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Módulo de Ventas</title>

    <link rel="shortcut icon" type="image/x-icon" href="/taller/favicon.ico">

    <!-- CSS personalizado -->
    <style>
    .estado-pendiente {
        background-color: #f39c12;
        color: white;
        font-weight: bold;
        border-radius: 12px;
        padding: 5px 15px;
        text-transform: uppercase;
        display: inline-block;
    width: 80%;
    text-align: center;
    
    }

    .estado-finalizado {
        background-color: #27ae60;
        color: white;
        font-weight: bold;
        border-radius: 12px;
        padding: 5px 15px;
        text-transform: uppercase;
        display: inline-block;
    width: 80%;
    text-align: center;
    }

    .estado-anulado {
        background-color: #ff0000;
        color: white;
        font-weight: bold;
        border-radius: 12px;
        padding: 5px 15px;
        text-transform: uppercase;
       display: inline-block;
    width: 80%;
    text-align: center;
    }

    .text-truncate {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
       
    }
    </style>

    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <?php require 'menu/css_lte.ctp'; ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Cabecera y barra de herramientas -->
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <!-- Contenido principal -->
        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-cash" viewBox="0 0 16 16">
                                        <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                                        <path
                                            d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z" />
                                    </svg> Módulo de Ventas
                                </h3>
                                <div class="box-tools">
                                    <a href="ventas_add.php" class="btn btn-primary btn-sm pull-right"
                                        data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Nueva Venta
                                    </a>
                                </div>
                            </div>

                            <div class="box-body">
                                <!-- Mensaje de alerta -->
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-success" role="alert" id="mensaje">
                                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                                    <?php 
                                        echo $_SESSION['mensaje'];
                                        $_SESSION['mensaje'] = ''; 
                                        ?>
                                </div>
                                <?php } ?>

                                <!-- Tabla de ventas -->
                                <?php
                                //require_once 'config/consultas.php';
                                $ventas = Consultas::get_datos("SELECT * FROM v_ventas ORDER BY ven_fecha DESC");
                                
                                if (!empty($ventas)) { ?>
                                <div class="table-responsive">
                                    <table id="ventasTable" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">N°</th>
                                                <th class="text-center">Comprobante</th>
                                                <th class="text-center">Fecha</th>
                                                <th class="text-center">Cliente</th>
                                                <th class="text-center">Tipo</th>
                                                <th class="text-center">Condición</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Vendedor</th>
                                                <th class="text-center">Sucursal</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ventas as $venta) { 
                                                    // Determinar clase de estado basado en id_estado
                                                    $estadoClass = '';
                                                    $estadoTexto = '';
                                                    switch($venta['id_estado']) {
                                                        case 1: // Pendiente
                                                            $estadoClass = 'estado-pendiente';
                                                            $estadoTexto = 'PENDIENTE';
                                                            break;
                                                        case 2: // Finalizado
                                                            $estadoClass = 'estado-finalizado';
                                                            $estadoTexto = 'FINALIZADA';
                                                            break;
                                                        case 3: // Anulado
                                                            $estadoClass = 'estado-anulado';
                                                            $estadoTexto = 'ANULADA';
                                                            break;
                                                        default:
                                                            $estadoClass = '';
                                                            $estadoTexto = $venta['id_estado'];
                                                    }
                                                ?>
                                            <tr>

                                                <td class="text-center"><?php echo $venta['ven_cod']; ?></td>
                                                <td class="text-center"><?php echo $venta['nro_comprobante']; ?></td>
                                                <td class="text-center">
                                                    <?php echo date('d/m/Y', strtotime($venta['ven_fecha'])); ?></td>
                                                <td class="text-truncate" title="<?php echo $venta['cliente']; ?>">
                                                    <?php echo $venta['cliente']; ?>
                                                </td>
                                                <td class="text-center"><?php echo $venta['tipo_comprobante']; ?></td>
                                                <td class="text-center"><?php echo $venta['condicion_pago']; ?></td>
                                                <td class="<?php echo $estadoClass; ?>">
                                                    <?php echo $estadoTexto; ?>
                                                </td>
                                                <td class="text-truncate" title="<?php echo $venta['empleado']; ?>">
                                                    <?php echo $venta['empleado']; ?>
                                                </td>
                                                <td class="text-center"><?php echo $venta['suc_descri']; ?></td>
                                                <td class="text-center">
                                                    <a href="venta_ver.php?id=<?php echo $venta['ven_cod']; ?>"
                                                        class="btn btn-primary btn-sm" data-title="Ver" rel="tooltip">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="venta_imprimir.php?id=<?php echo $venta['ven_cod']; ?>"
                                                        class="btn btn-default btn-sm" data-title="Imprimir"
                                                        rel="tooltip" target="_blank">
                                                        <i class="fa fa-print"></i>
                                                    </a>

                                                    <?php if ($venta['id_estado'] != 3) { // Si no está anulada ?>
                                                    <a onclick="anular(<?php echo $venta['ven_cod']; ?>)"
                                                        class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip">
                                                        <i class="fa fa-ban"></i>
                                                    </a>

                                                    <?php if ($venta['id_estado'] == 1) { // Solo pendientes se pueden editar ?>
                                                    <a href="venta_editar.php?id=<?php echo $venta['ven_cod']; ?>"
                                                        class="btn btn-warning btn-sm" data-title="Editar"
                                                        rel="tooltip">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else { ?>
                                <div class="alert alert-info">
                                    <i class="glyphicon glyphicon-info-sign"></i>
                                    No se han registrado ventas.
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para anular -->
        <div class="modal fade" id="anular" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Cerrar"><i
                                class="fa fa-remove"></i></button>
                        <h4 class="modal-title">Atención!</h4>
                    </div>
                    <div class="modal-body">
                        <div id="confirmacion" class="alert alert-danger"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> NO</button>
                        <a id="si" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i> SI</a>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <?php require 'menu/js_lte.ctp'; ?>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#ventasTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
            },
            columnDefs: [{
                    orderable: false,
                    targets: [9],
                    
                }, // Columna de acciones no ordenable
                {
                    width: "7%",
                    targets: [0, 1, 4, 5, 6, 8]
                } // Ancho fijo para algunas columnas
            ]
        });

        // Ocultar mensaje después de 4 segundos
        $("#mensaje").delay(6000).slideUp(200, function() {
            $(this).alert('close');
        });
    });

    function anular(ventaId) {
        $("#si").attr('href', 'venta_anular.php?id=' + ventaId);
        $("#confirmacion").html(`
                <span class='glyphicon glyphicon-warning-sign'></span> 
                Desea anular la Venta N° <strong>${ventaId}</strong>?
            `);
        $('#anular').modal('show');
    }
    </script>
</body>

</html>