<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Orden producción</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="/taller/favicon.ico">
    
   <!-- DataTables CSS -->
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <!-- Estilos CSS personalizados -->
    <style>
        .estado-pendiente {
            background-color: #f39c12;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
            font-size: 15px;
        }
        .estado-anulado {
            background-color: #f44336;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
            font-size: 15px;
        }
        .estado-finalizado {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
            font-size: 15px;
        }
    </style>
    
    
    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; // Archivos CSS
    ?>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Cabecera y barra de herramientas -->
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                <img src="img/produccion.png" alt="Ajustes" width="50" height="50">
</svg> Orden Producción
                                </h3>
                                <div class="box-tools">
                                    <a href="orden_produccion_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Agregar Orden 
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                    <div class="alert alert-success" id="mensaje">
                                        <i class="glyphicon glyphicon-exclamation-sign"></i>
                                        <?php 
                                        echo $_SESSION['mensaje'];
                                        $_SESSION['mensaje'] = ''; 
                                        ?>
                                    </div>
                                <?php } ?>

                                <?php
                                $orden = consultas::get_datos("select * from v_orden_produccion_cabecera order by ord_cod desc");
                                if (!empty($orden)) { ?>
                                    <div class="table-responsive">
                                    <table id="ordenesTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-center">Orden N°</th>
            <th class="text-center">Presupuesto N°</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Equipo Asignado</th>
            <th class="text-center">Sucursal</th>
            <th class="text-center">usuario</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orden as $ord) { 
            // Determinamos la clase CSS según el estado
            $claseEstado = '';
            switch ($ord['estado_nombre']) {
                case 'FINALIZADO':
                    $claseEstado = 'estado-finalizado';
                    break;
                case 'PENDIENTE':
                    $claseEstado = 'estado-pendiente';
                    break;
                case 'ANULADO':
                    $claseEstado = 'estado-anulado';
                    break;
            }
        ?>
        <tr>
            <td class="text-center"><?php echo htmlspecialchars($ord['ord_cod']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($ord['pre_cod']); ?></td>
            <td><?php echo htmlspecialchars($ord['fecha']); ?></td>
            <td class="<?php echo $claseEstado; ?>"><?php echo htmlspecialchars($ord['estado_nombre']); ?></td>
            <td><?php echo htmlspecialchars($ord['nombre_equipo']); ?></td>
            <td><?php echo htmlspecialchars($ord['sucursal_descripcion']); ?></td>
            <td><?php echo htmlspecialchars($ord['usuario_nick']); ?></td>
            <td class="text-center">
                        <?php if ($ord['estado_nombre'] === "PENDIENTE") { ?>
                            <!-- Botones habilitados solo cuando el estado es "PENDIENTE" -->
                            <a href="pedcompra_print?vord_cod=<?php echo $ord['ord_cod']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="pedcompra_edit.php?vid_pedido=<?php echo $ord['ord_cod']; ?>" class="btn btn-warning btn-sm" title="Editar">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            <a onclick="anular('<?php echo $ord['ord_cod'] . '_' . $ord['ord_cod']; ?>')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#anular" title="Anular">
                                <i class="fa fa-remove"></i>
                            </a>
                            <a href="orden_produccion_det.php?vord_cod=<?php echo $ord['ord_cod']; ?>" class="btn btn-success btn-sm" title="Detalles">
                                <i class="glyphicon glyphicon-list"></i>
                            </a>
                          
                        <?php } ?>

                        <?php if ($ord['estado_nombre'] === "ANULADO") { ?>
                            <!-- Botón habilitado solo cuando el estado es "ANULADO" -->
                            <a href="pedcompra_print?vid_pedido=<?php echo $ord['ord_cod']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="orden_produccion_det.php?vord_cod=<?php echo $ord['ord_cod']; ?>" class="btn btn-success btn-sm" title="Detalles">
                                <i class="glyphicon glyphicon-list"></i>
                            </a>
                        <?php } ?>
                        <?php if ($ord['estado_nombre'] === "FINALIZADO") { ?>
                            <!-- Botón habilitado solo cuando el estado es "ANULADO" -->
                            <a href="pedcompra_print?vid_pedido=<?php echo $ord['ord_cod']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="orden_produccion_det.php?vord_cod=<?php echo $ord['ord_cod']; ?>" class="btn btn-success btn-sm" title="Detalles">
                                <i class="glyphicon glyphicon-list"></i>
                            </a>
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
                                        No se ha registrado pedidos de compras.
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
                        <button class="close" data-dismiss="modal" aria-label="Cerrar"><i class="fa fa-remove"></i></button>
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
        $(document).ready(function () {
            $('#ordenesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                }
            });

            // Ocultar mensaje después de 4 segundos
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        });

        function anular(datos) {
            var dat = datos.split("_");
            $("#si").attr('href', 'pedcompra_control.php?vid_pedido=' + dat[0] + '&accion=2');
            $("#confirmacion").html(`
                <span class='glyphicon glyphicon-warning-sign'></span> 
                Desea anular la orden de producción N° <strong>${dat[0]}</strong>?
            `);
        }
    </script>
</body>
</html>
