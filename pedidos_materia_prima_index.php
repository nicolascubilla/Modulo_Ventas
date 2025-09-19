<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedidos de Materia Prima</title>
    
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <?php 
    session_start();
    require 'menu/css_lte.ctp'; 
    ?>

    <style>
        .estado-finalizado {
            background-color: #28a745; /* Verde */
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
        }

        .estado-pendiente {
            background-color: #ffc107; /* Amarillo */
            color: black;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
        }

        .estado-anulado {
            background-color: #dc3545; /* Rojo */
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="box box-primary">
                    <!-- Mensaje de éxito -->
                    <?php if (!empty($_SESSION['mensaje'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                        </div>
                    <?php endif; ?>

                    <div class="box-header with-border">
                        <h4 class="box-title">Pedidos de Materia Prima</h4>
                        <div class="box-tools">
                            <a href="pedidos_materia_prima_add.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip" data-placement="top">
                                <i class="fa fa-plus"></i> Agregar Pedido
                            </a>
                        </div>
                    </div>
                    <?php
                                $control = consultas::get_datos("SELECT * FROM v_pedido_materia_cabecera");
                                if (!empty($control))  ?>

                    <div class="table-responsive">
                        <table id="pedidoTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>N° Pedido</th>
                                    <th>N° Orden</th>
                                    <th>Equipo de Trabajo</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Sucursal</th>
                                    <th>Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($control)) {
                                    foreach ($control as $con) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($con['pedido_id']); ?></td>
                                            <td><?php echo htmlspecialchars($con['ord_cod']); ?></td>
                                            <td><?php echo htmlspecialchars($con['nombre_equipo']); ?></td>
                                            <td><?php echo htmlspecialchars($con['fecha']); ?></td>
                                            <td class="text-center">
                                                <span class="estado <?php echo ($con['estado'] == 'FINALIZADO' ? 'estado-finalizado' : ($con['estado'] == 'PENDIENTE' ? 'estado-pendiente' : ($con['estado'] == 'ANULADO' ? 'estado-anulado' : ''))); ?>">
                                                    <?php echo $con['estado']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($con['sucursal']); ?></td>
                                            <td><?php echo htmlspecialchars($con['usuario']); ?></td>
                                            <td class="text-center">
                                                <a href="pedidos_materia_prima_print.php?vpedido_id=<?php echo $con['pedido_id']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                                                    <span class="glyphicon glyphicon-print"></span>
                                                </a>
                                                <a href="pedido_materia_prima_detalle.php?vpedido_id=<?php echo $con['pedido_id']; ?>" class="btn btn-primary btn-sm" data-title="Ver Detalles" rel="tooltip">
                                                    <i class="fa fa-eye"></i> Ver
                                                </a>
                                                <?php if ($con['estado'] !== 'ANULADO' && $con['estado'] !== 'FINALIZADO' ) { ?>
                                                    <button onclick="anular('<?php echo $con['ord_cod']; ?>')" class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-toggle="modal" data-target="#anular">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="alert alert-info flat">
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                        No se han registrado pedidos de materia prima.
                                    </div>
                                <?php } ?>
                            </tbody>
                        </table>
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
                        <form id="formAnular" method="POST" action="pedido_materia_prima_anular_control.php">
                            <input type="hidden" name="vord_cod" id="pedidoId">
                            <input type="hidden" name="accion" value="2">
                            <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> NO</button>
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i> SI</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
        <?php require 'menu/js_lte.ctp'; ?>
    </div>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#pedidoTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                }
            });

            setTimeout(() => {
                $(".alert-success").slideUp(200);
            }, 6000);
        });

        function anular(pedidoId) {
            $("#pedidoId").val(pedidoId);
            $("#confirmacion").html(`
                <span class='glyphicon glyphicon-warning-sign'></span> 
                ¿Desea anular el Pedido de Materia Prima N° <strong>${pedidoId}</strong>?
            `);
        }
    </script>
</body>
</html>
