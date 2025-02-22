<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Presupuesto de Compra</title>
    
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
        }
        .estado-finalizado {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
        }
        .estado-anulado {
            background-color: #ff0000;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 5px 15px;
            text-transform: uppercase;
            display: inline-block;
        }
    </style>

    </style>

    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    
    <?php 
    session_start();
    require 'menu/css_lte.ctp'; // Archivos CSS personalizados del sistema
    ?>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
  <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"/>
</svg></i> Presupuesto de Compra
                                </h3>
                                <div class="box-tools">
                                    <a href="presupuesto_compra_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Agregar Presupuesto
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

                                <!-- Tabla de pedidos -->
                                <?php
                                $Presupuesto = consultas::get_datos("SELECT * FROM v_presupuesto_compra_cabecera");
                                if (!empty($Presupuesto)) { ?>
                                    <div class="table-responsive">
                                        <table id="pedidosTable" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">N°</th>
                                                    <th class="text-center">N° Pedido</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Proveedor</th>
                                                    <th class="text-center">Sucursal</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
    <?php foreach ($Presupuesto as $Presu) { ?>
        <tr>
            <td class="text-center"><?php echo $Presu['presupuesto_id']; ?></td>
            <td class="text-center"><?php echo $Presu['id_pedido']; ?></td>
            <td class="text-center"><?php echo $Presu['fecha_presu']; ?></td>
            <td class="<?php echo 'estado-' . strtolower($Presu['estado_nombre']); ?>">
                                                            <?php echo $Presu['estado_nombre']; ?>
                                                        </td>
            <td><?php echo $Presu['usuario']; ?></td>
            <td><?php echo $Presu['proveedor']; ?></td>
            <td><?php echo $Presu['sucursal']; ?></td>
            <td class="text-center">
            
            <a href="presupuesto_compra_print.php?vpresupuesto_id=<?php echo $Presu['presupuesto_id']; ?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target="print">
                <span class="glyphicon glyphicon-print"></span>
                            </a>
                          
    

               
                                                        <a href="presupuesto_compra_detalles.php?vpresupuesto_id=<?php echo $Presu['presupuesto_id']; ?>" 
    class="btn btn-primary btn-sm" data-title="Ver Detalles" rel="tooltip" target="_top">
    <i class="fa fa-eye"></i> Ver
</a>


<?php if ($Presu['estado_nombre'] !== 'ANULADO' && $Presu['estado_nombre'] !== 'FINALIZADO') { ?>
              
                                                            <a onclick="anular(<?php echo "'".$Presu['id_pedido']."_".$Presu['presupuesto_id']."'"; ?>)" class="btn btn-danger btn-sm" role="button" data-title="Anular" rel="tooltip" data-placement="top" data-toggle="modal" data-target="#anular">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </a>
                                                        
<a href= "presupuesto_compra_editar?vpresupuesto_id=<?php echo $Presu['presupuesto_id'];?>" class="btn btn-warning btn-sm" role="button" data-title="Editar" rel="tooltip" data-placement="top">
                                                            <span class="glyphicon glyphicon-edit"></span>
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
                                        No se ha registrado pedidos de compras pendientes.
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
            $('#pedidosTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                }
            });

            // Ocultar mensaje después de 4 segundos
            $("#mensaje").delay(6000).slideUp(200, function () {
                $(this).alert('close');
            });
        });
        function anular(datos) {
            var dat = datos.split("_");
            $("#si").attr('href', 'presupuesto_compra_anular.php?vid_pedido=' + dat[0] + '&accion=2');
            $("#confirmacion").html(`
                <span class='glyphicon glyphicon-warning-sign'></span> 
                Desea anular el Presupuesto de Compra N° <strong>${dat[0]}</strong>?
            `);
        }
    
    </script>
  
</body>
</html>
