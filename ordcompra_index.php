<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orden de Compra</title>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    
    <!-- Estilos personalizados -->
    <style>
        .estado-aprobado {
            background-color: #28a745; /* Verde */
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 10px;
            text-transform: uppercase;
            text-align: center;
        }
        .estado-anulado {
            color: red;
            font-weight: bold;
            font-size: 1.2em;
            text-transform: uppercase;
        }
        .estado {
    font-weight: bold;
    color: white;
    border-radius: 10px;
    padding: 5px 10px;
    text-transform: uppercase;
    display: inline-block;
}

.estado-finalizado {
    background-color: #006400;
}

.estado-pendiente {
    background-color: #f39c12;
}
.estado-cerrado {
    background-color: #20B2AA;
}
.estado-anulado {
        background-color: #ff0000; /* Fondo rojo */
        color: white; /* Texto blanco */
    }
    .btn-info {
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-info:hover {
    background-color: #17a2b8;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

    </style>

    <?php 
    session_start();
    require 'menu/css_lte.ctp'; // Archivos CSS personalizados del sistema
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
        <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
</svg>
                                <h3 class="box-title">Orden de Compra</h3>
                                <div class="box-tools">
                                <a href="ordcompra_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Agregar Orden Compras
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
                                $ordenes = consultas::get_datos("SELECT * FROM v_orden_compras_cabecera");
                                if (!empty($ordenes)) { ?>
                                    <div class="table-responsive">
                                        <table id="ordenesTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">N° Orden</th>
                                                    <th class="text-center">Presupuesto N°</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Proveedor</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Sucursal</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($ordenes as $orden) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $orden['orden_id']; ?></td>
                                                        <td class="text-center"><?php echo $orden['presupuesto_id']; ?></td>
                                                        <td class="text-center"><?php echo $orden['fecha_orden']; ?></td>
                                                        <td class="text-center">
                                                        <span class="estado 
        <?php 
            echo $orden['estado'] == 'FINALIZADO' ? 'estado-finalizado' : 
                 ($orden['estado'] == 'PENDIENTE' ? 'estado-pendiente' : 
                 ($orden['estado'] == 'CERRADO' ? 'estado-cerrado' :
                 ($orden['estado'] == 'ANULADO' ? 'estado-anulado' : ''))); 
        ?>">
        <?php echo $orden['estado']; ?>
    </span>
                                                        </td>
                                                        <td><?php echo $orden['proveedor']; ?></td>
                                                        <td><?php echo $orden['usuario']; ?></td>
                                                        <td><?php echo $orden['sucursal']; ?></td>
                                                        <td class="text-center">
                                                            <a href="orden_compra_print.php?orden_id=<?php echo $orden['orden_id']; ?>" 
                                                               class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="_blank">
                                                                <i class="glyphicon glyphicon-print"></i> Imprimir
                                                            </a>
                                                            <a href="orden_compra_detalles.php?orden_id=<?php echo $orden['orden_id']; ?>" 
   class="btn btn-info btn-sm" 
   data-title="Detalles" 
   rel="tooltip">
    <i class="fa fa-info-circle"></i> Detalles
</a>
                                                           
<?php if ($orden['estado'] !== 'ANULADO' && $orden['estado'] !== 'CERRADO') { ?>
                          
<a onclick="anular('<?php echo $orden['orden_id']; ?>', '<?php echo $orden['presupuesto_id']; ?>')"  
   class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-toggle="modal" data-target="#anular">
    <i class="glyphicon glyphicon-remove"></i> Anular
</a>

<?php } ?> 
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info flat">
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                        No se han registrado órdenes de compras.
                                    </div> 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->

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
                $("#mensaje").delay(6000).slideUp(200);
            });

            function anular(ordenId, presupuestoId) {
    // Configurar el enlace con el presupuesto_id para el controlador
    $('#si').attr('href', 'orden_compra_control_anular.php?vpresupuesto_id=' + presupuestoId + '&accion=2');
    
    // Mostrar el mensaje con el orden_id
    $('#confirmacion').html('<span class="glyphicon glyphicon-question-sign"></span> ¿Desea anular la Orden N° <strong>' + ordenId + '</strong>?');
}

        </script>
    </div>
</body>
</html>
