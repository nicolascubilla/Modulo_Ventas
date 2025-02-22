<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
    <title>LP3</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .titulo-grande {
            font-size: 20px;
            font-weight: bold;
        }
        th {
            font-size: 18px;
            padding: 10px;
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
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <i class="ion ion-plus"></i>
                                <h3 class="box-title">Agregar Pedido de Compra</h3>
                                <div class="box-tools">
                                    <a href="pedcompra_index.php" class="btn btn-primary btn-sm pull-right" data-title="Volver" rel="tooltip" data-placement="top">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                    <div class="alert alert-danger" role="alert" id="mensaje">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                                    </div>
                                <?php } ?>

                                <!-- Formulario principal -->
                                <form action="pedcompra_dcontrol.php" method="POST" class="form-horizontal" id="pedidoForm">
                                <input type="hidden" name="accion" value="1">
                                 <div class="box-body">
                                    
                           <!-- Fecha -->
                           <div class="form-group row">
    <label for="fecha" class="control-label col-lg-2 col-md-1 col-sm-1 titulo-grande">Fecha:</label>
    <div class="col-lg-3 col-md-3 col-sm-3">
    <?php
date_default_timezone_set('America/Asuncion');
        // Obtener la fecha y hora actual desde PostgreSQL
        $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_pedido");
        // Convertir el formato de PostgreSQL al esperado por datetime-local
        $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_pedido']));
        ?>
        <!-- Campo visible, solo lectura -->
        <input type="datetime-local" name="fecha_pedido_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" disabled>
        <!-- Campo oculto para enviar la fecha -->
        <input type="hidden" name="vfecha_pedido" value="<?php echo $fecha[0]['fecha_pedido']; ?>">
    </div>
</div>


                                         <!-- Usuario -->
<div class="form-group row">
    <label for="usuario" class="control-label col-lg-2 col-md-2 col-sm-2 titulo-grande">Usuario:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <!-- Este campo ya no es necesario porque el valor se envía por el campo oculto -->
        <input type="text" id="usuario" name="vusu_cod" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
    </div>
    <!-- Campo oculto para enviar el código de usuario (usu_cod) -->
    <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
</div>

                                          <!-- Fila con Observación -->
                                         <div class="form-group row">
                                          <label for="observacion" class="control-label col-lg-2 col-md-2 col-sm-2 titulo-grande">Observación:</label>
                                          <div class="col-lg-8 col-md-8 col-sm-8">
                                             <textarea id="observacion" name="vobservacion" class="form-control" rows="5" placeholder="Ingrese una observación..."></textarea>
                                          </div>
                                             </div>

                                          </div>

                                       <!-- Sucursal -->
<!-- Sucursal -->
<div class="form-group row">
    <label for="sucursal" class="control-label col-lg-2 col-md-2 col-sm-2">Sucursal:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <!-- Este campo ya no es necesario porque el valor se envía por el campo oculto -->
        <input type="text" id="sucursal" name="vid_sucursal" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" disabled>
    </div>
    <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
</div>

                                    <!-- Tabla de detalles -->
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#detalleModal">Agregar Detalle</button>
                                        </div>
                                    </div>

                                    <table id="tablaDetalles" class="table table-bordered">
  <thead>
    <tr>
      <th>Cantidad</th>
      <th>Material</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <!-- Las filas dinámicas se insertarán aquí -->
  </tbody>
</table>


                                    <div class="text-end">
                                    <div class="box-footer">
                                      <button type="submit" class="btn btn-primary">Guardar Pedido</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para agregar detalle -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleModalLabel">Agregar Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detalleForm">
                    <!-- Material -->
                    <div class="form-group row">
                        <label for="selectMaterial" class="col-sm-2 control-label">Materiales:</label>
                        <div class="col-sm-8">
                            <?php
                            $material = consultas::get_datos("SELECT material_id, nombre_material FROM Material");
                            if ($material) { ?>
                                <select class="form-control select2" id="material_id" name="vmaterial_id[]" required>
                                    <option value="">Seleccione el Item</option>
                                    <?php foreach ($material as $mate) { ?>
                                        <option value="<?php echo htmlspecialchars($mate['material_id']); ?>">
                                            <?php echo htmlspecialchars($mate['nombre_material']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <p class="text-danger">No se encontraron materiales disponibles.</p>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Cantidad -->
                    <div class="form-group row">
                        <label for="cantidad" class="col-sm-2 control-label">Cantidad:</label>
                        <div class="col-sm-8">
                            <input type="number" id="cantidad" name="vcantidad" class="form-control" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarDetalle">Agregar Detalle</button>
            </div>
        </div>
    </div>
</div>

    
    <?php require 'menu/js_lte.ctp'; ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script> 
    $(document).ready(function () {
    // Inicializar Select2 globalmente
    $('.select2').select2({
        width: '100%'
    });

    // Reinicializar Select2 dentro del modal
    $('#detalleModal').on('shown.bs.modal', function () {
        $('#material_id').select2({
            dropdownParent: $('#detalleModal'), // Asigna el dropdown al modal
            width: '100%' // Ajusta el ancho
        });
    });
});

     </script>
   
    <script>
        
  // Inicialización de detalles
  var detalles = [];

  // Evento para agregar un detalle
  $('#btnAgregarDetalle').click(function () {
    var materialId = $('#material_id').val();
    var materialText = $('#material_id option:selected').text();
    var cantidad = $('#cantidad').val();

    if (materialId && cantidad > 0) {
        // Verificar si el material ya está agregado
        var existe = $('#tablaDetalles tbody tr').toArray().some(function (fila) {
            return $(fila).data('material-id') == materialId;
        });

        if (!existe) {
            // Agregar una nueva fila con inputs ocultos para el detalle
            var row = `
                <tr data-material-id="${materialId}">
                    <td>${cantidad}</td>
                    <td>${materialText}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btnEliminarDetalle">Eliminar</button>
                    </td>
                    <!-- Inputs ocultos para enviar los datos al servidor -->
                    <input type="hidden" name="material_id[]" value="${materialId}">
                    <input type="hidden" name="cantidad[]" value="${cantidad}">
                </tr>`;
            $('#tablaDetalles tbody').append(row);

            // Limpiar el formulario del modal
            $('#detalleForm')[0].reset();
            $('#selectMaterial').val(null).trigger('change'); // Resetear el select2
            $('#detalleModal').modal('hide'); // Cerrar el modal
        } else {
            alert('Este material ya fue agregado.');
        }
    } else {
        alert('Debe seleccionar un material y una cantidad válida.');
    }
  });

  // Evento para eliminar un detalle
  $(document).on('click', '.btnEliminarDetalle', function () {
    $(this).closest('tr').remove();
  });
</script>



</body>
</html>