<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar Pedido de Compra</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; // Archivos CSS
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
                                <h3 class="box-title">Editar Pedido de Compra</h3>
                                <div class="box-tools">
                                    <a href="pedcompra_index.php" class="btn btn-primary btn-sm" title="Volver">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                    <div class="alert alert-danger" id="mensaje">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                                    </div>
                                <?php } ?>
                                <?php 
                                    // Obtener el ID del pedido
                                    $id_pedido = $_GET['vid_pedido'];
                                    // Consultar los detalles del pedido desde la vista 'v_pedido_compra_detalle'
                                    $detalles = consultas::get_datos("SELECT * FROM v_pedido_compra_detalle WHERE id_pedido = $id_pedido");
                                ?>
    
                                <form action="pedcompra_control_editar.php" method="POST" class="form-horizontal">
                                    <input type="hidden" name="accion" value="3"> <!-- Acción 3 = Editar -->
                                    <input type="hidden" name="vid_pedido" value="<?php echo $id_pedido; ?>">
                                    
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
                                    <div class="form-group row">
                                        <label for="usuario" class="control-label col-lg-2">Usuario:</label>
                                        <div class="col-lg-3">
                                        <input type="text" id="usuario" name="vusu_cod" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" readonly>
                                        </div>
                                        <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
                                    </div>
                                    <div class="form-group row">
                                        <label for="observacion" class="control-label col-lg-2">Observación:</label>
                                        <div class="col-lg-8">
                                            <textarea name="vobservacion" class="form-control" rows="5"><?php echo $detalles[0]['observacion']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Sucursal" class="control-label col-lg-2">Sucursal:</label>
                                        <div class="col-lg-8">
                                        <input type="text" id="sucursal" name="vid_sucursal" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" readonly>
                                        </div>
                                        <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">

                                    </div>

                                    <!-- Tabla de detalles -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#detalleModal">Agregar Detalle</button>
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
                                            <?php foreach ($detalles as $detalle) { ?>
                                                <tr data-material-id="<?php echo $detalle['material_id']; ?>">
                                                    <td><?php echo $detalle['cantidad']; ?></td>
                                                    <td><?php echo $detalle['material']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm btnEliminarDetalle">Eliminar</button>
                                                    </td>
                                                    <input type="hidden" name="material_ids[]" value="<?php echo $detalle['material_id']; ?>">
                                                    <input type="hidden" name="cantidades[]" value="<?php echo $detalle['cantidad']; ?>">
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
    
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para agregar detalle -->
        <div class="modal fade" id="detalleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Detalle</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="detalleForm">
                            <div class="form-group">
                                <label for="selectMaterial">Item:</label>
                                <?php $material = consultas::get_datos("SELECT * FROM material"); ?>
                                <select class="form-control select2" id="selectMaterial" name="vmaterial_ids[]" required style="width: 100%;">
                                    <option value="">Seleccione un Material</option>
                                    <?php foreach ($material as $mate) { ?>
                                        <option value="<?php echo $mate['material_id']; ?>">
                                            <?php echo $mate['nombre_material']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" id="cantidad" name="vcantidades" class="form-control" required>
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
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
    <script> 
    var detalles = [];

    // Evento para agregar un detalle
    $('#btnAgregarDetalle').click(function () {
        var materialId = $('#selectMaterial').val();
        var materialText = $('#selectMaterial option:selected').text();
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
                        <input type="hidden" name="material_ids[]" value="${materialId}">
                        <input type="hidden" name="cantidades[]" value="${cantidad}">
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
