<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cuentas a Pagar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">


    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- Estilos personalizados -->
    <style>
    
    /* Estilo para el botón de "Pagar" */
    .btn-success {
        background: linear-gradient(135deg, #ff5722, #e91e63);
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #e91e63, #c2185b);
        box-shadow: 0 5px 15px rgba(233, 30, 99, 0.4);
        transform: scale(1.05);
    }

    /* Estilo para el modal */
    .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        padding: 15px;
    }

    .modal-body {
        font-size: 16px;
        color: #333;
        padding: 20px;
        text-align: center;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
        text-align: center;
        padding: 15px;
    }

    .modal-footer .btn {
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
    }

    .modal-footer .btn-default {
        background-color: #6c757d;
        color: white;
    }

    .modal-footer .btn-primary {
        background-color: #28a745;
        color: white;
    }

    .modal-footer .btn-default:hover {
        background-color: #5a6268;
    }

    .modal-footer .btn-primary:hover {
        background-color: #218838;
    }

    #confirmacion {
        color: #212529;
        font-weight: bold;
        margin-top: 15px;
    }
    /* Botón Pagar - Azul degradado */
.btn-success {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    font-weight: bold;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #0056b3, #003580);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
}

</style>

    </style>

    <?php 
      session_start();
      require 'menu/css_lte.ctp'; 
      ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
          <!-- Cabecera y barra de herramientas -->
          <?php require 'menu/header_lte.ctp'; ?>
          <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Cuentas a Pagar</h3>
                                <div class="box-tools">
                                    <a href="factura_compra_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i>
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
                                if (!empty($_GET['id_factura'])) {
                                    $cuentas = consultas::get_datos("SELECT * FROM v_cuentas_a_pagar WHERE id_factura = {$_GET['id_factura']}");
                                    if (!empty($cuentas)) { ?>
                                        <div class="table-responsive">
                                            <table id="cuentasTable" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID Factura</th>
                                                        <th class="text-center">Nro Cuota</th>
                                                        <th class="text-center">Monto</th>
                                                        <th class="text-center">Fecha Vencimiento</th>
                                                        <th class="text-center">Saldo</th>
                                                        <th class="text-center">Estado</th>
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($cuentas as $cuenta) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $cuenta['id_factura']; ?></td>
                                                            <td class="text-center"><?php echo $cuenta['nro_cuota']; ?></td>
                                                            <td class="text-center"><?php echo number_format($cuenta['monto_cuota']); ?></td>
                                                            <td class="text-center"><?php echo $cuenta['fecha_vencimiento']; ?></td>
                                                            <td class="text-center"><?php echo number_format($cuenta['saldo_cuota']); ?></td>
                                                            <td class="text-center">
                                                                <span class="estado-pendiente"><?php echo $cuenta['estado_pago']; ?></span>
                                                            </td>
                                                            <td class="text-center">
                                                            <?php if (strtoupper($cuenta['estado_pago']) === 'PAGADO') { ?>
        <!-- Botón deshabilitado -->
        <button class="btn btn-secondary btn-sm disabled" 
                style="pointer-events: none; opacity: 0.6;" 
                title="Ya pagado">
            <i class="fa fa-check"></i> Pagado
        </button>
    <?php } else { ?>
        <!-- Botón activo -->
        <a onclick="pagar('<?php echo $cuenta['id_factura']; ?>', '<?php echo $cuenta['nro_cuota']; ?>', '<?php echo $cuenta['fecha_vencimiento']; ?>')"  
           class="btn btn-success btn-sm" 
           data-title="Pagar cuenta" 
           rel="tooltip" 
           data-toggle="modal" 
           data-target="#pagar">
            <i class="fa fa-money"></i> Pagar
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
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                            No hay cuentas pendientes de pago.
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
        <?php require 'menu/js_lte.ctp'; ?>
        
        <div class="modal fade" id="pagar" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Cerrar">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Confirmación de Pago</h4>
            </div>
            <div class="modal-body">
                <div id="confirmacion" class="alert alert-light">
                    ¿Estás seguro de que deseas pagar la factura N° <strong>12345</strong>?
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> No
                </button>
                <a id="si" class="btn btn-primary">
                    <i class="fa fa-check"></i> Sí
                </a>
            </div>
        </div>
    </div>
</div>


        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#cuentasTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                    }
                });
            });

            function pagar(id_factura, nro_cuota, fecha_vencimiento) {
    // Configurar el enlace con el id_factura para el controlador
    $('#si').attr('href', 'factura_compra_cuentas_control.php?vid_factura=' + id_factura + '&accion=2&vnro_cuota=' + nro_cuota);


    // Mostrar el mensaje estilizado con el número de cuota, fecha de vencimiento y factura
    $('#confirmacion').html(
        '<p style="font-size: 18px; font-weight: bold; color: #333; margin: 10px 0;">' +
        '¿Estás seguro que deseas proceder con el <span style="color: #28a745;">pago</span> de la cuota N° <strong>' + nro_cuota + '</strong> con vencimiento el <strong>' + fecha_vencimiento + '</strong> de la factura N° <strong>' + id_factura + '</strong>?' +
        '</p>'
    );
}
$("#mensaje").delay(6000).slideUp(200);


        </script>
    </div>
</body>
</html>
