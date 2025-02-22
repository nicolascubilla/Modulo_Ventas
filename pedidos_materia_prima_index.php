<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pedidos de Materia Prima</title>
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
    
   
    
    <?php 
    session_start();
    require 'menu/css_lte.ctp'; 
    ?>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="box box-primary">
                    <!-- Mensaje de Error -->
                    <?php if (!empty($_SESSION['mensaje'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php
                            echo $_SESSION['mensaje'];
                            $_SESSION['mensaje'] = '';
                            ?>
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

                    <div class="box-body">
                        <table id="example" class="display nowrap" style="width:100%">
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
                                <?php 
                                $control = consultas::get_datos("SELECT * FROM v_pedido_materia_cabecera");
                                if (!empty($control)) {
                                    foreach ($control as $con) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($con['pedido_id']); ?></td>
                                            <td><?php echo htmlspecialchars($con['ord_cod']); ?></td>
                                            <td><?php echo htmlspecialchars($con['nombre_equipo']); ?></td>
                                            <td><?php echo htmlspecialchars($con['fecha']); ?></td>
                                            <td><?php echo htmlspecialchars($con['estado']); ?></td>
                                            <td><?php echo htmlspecialchars($con['sucursal']); ?></td>
                                            <td><?php echo htmlspecialchars($con['usuario']); ?></td>
                                            <td>
                                            <a href="presupuesto_compra_print.php?vpedido_id=<?php echo $con['pedido_id']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                <span class="glyphicon glyphicon-print"></span>
                            </a>
                            <a href="pedido_materia_prima_detalle.php?vpedido_id=<?php echo $con['pedido_id']; ?>" 
    class="btn btn-primary btn-sm" data-title="Ver Detalles" rel="tooltip" target="_top">
    <i class="fa fa-eye"></i> Ver
</a>
<a onclick="anular(<?php echo "'".$con['pedido_id']."_".$con['pedido_id']."'"; ?>)" class="btn btn-danger btn-sm" role="button" data-title="Anular" rel="tooltip" data-placement="top" data-toggle="modal" data-target="#anular">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </a>
                                               
                                            </td>
                                        </tr>
                                    <?php } 
                                } else { ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No se han registrado pedidos de materia prima.</td>
                                    </tr>
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
        // Inicializar DataTables
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Exportar a Excel',
                        className: 'btn btn-success btn-sm'
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });
  // Ocultar mensaje después de 4 segundos
  $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        
        // Función para anular un pedido
        function anularPedido(pedidoId) {
            if (confirm('¿Está seguro de anular este pedido?')) {
                // Lógica de anulación (AJAX o redirección)
                alert('Pedido ' + pedidoId + ' anulado.');
            }
        }

      
        function anular(datos) {
            var dat = datos.split("_");
            $("#si").attr('href', 'presupuesto_compra_anular.php?vpedido_id=' + dat[0] + '&accion=2');
            $("#confirmacion").html(`
                <span class='glyphicon glyphicon-warning-sign'></span> 
                Desea anular el Pedido de Materia Prima N° <strong>${dat[0]}</strong>?
            `);
        }
    </script>
</body>
</html>
