<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registrar Pedido de Materia Prima</title>
    <link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>

    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        
        <div class="content-wrapper">
            <div class="content">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Registrar Pedido de Materia Prima</h4>
                        <div class="box-tools">
                            <a href="pedidos_materia_prima_index.php" class="btn btn-primary btn-md" data-title="Volver" rel="tooltip">
                                Volver <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="pedidos_materia_prima_control.php" method="post">
                            <input type="hidden" name="accion" value="1"/>

                            <!-- Fila 1: Orden Producción, Buscar Orden, Equipo de Trabajo -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="orden" class="control-label">Orden Producción:</label>
                                    <select class="form-control select2" name="vord_cod" id="orden" onchange="cargarorden(this.value)" required>
                                        <option value="">Seleccione una orden</option>
                                        <?php 
                                        $pedidos = consultas::get_datos("SELECT * FROM v_orden_produccion_pendientes ORDER BY ord_cod DESC");
                                        foreach ($pedidos as $pedido) { ?>
                                            <option value="<?php echo $pedido['ord_cod']; ?>">
                                                <?php echo "N°: " . $pedido['ord_cod'] . " Fecha: " . $pedido['fecha']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="buscar_orden" class="control-label">Buscar Orden (ID):</label>
                                    <div class="input-group">
                                        <input type="text" id="buscar_orden" class="form-control" placeholder="Ingrese ID" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" onclick="buscarorden()">Buscar</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
            <label for="nombre_equipo" class="control-label">Equipo de trabajo:</label>
            <input type="text" id="nombre_equipo" name="nombre_equipo" class="form-control" readonly>
            <input type="hidden" id="vequipo_id" name="vequipo_id">
        </div>
    </div>

                            <!-- Fila 2: Fecha, Sucursal, Usuario -->
                            <div class="row mt-3">
                                <div class="col-lg-4">
                                    <label for="fecha" class="control-label">Fecha:</label>
                                    <?php
                                    date_default_timezone_set('America/Asuncion');
                                    $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha");
                                    $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha']));
                                    ?>
                                    <input type="datetime-local" name="fecha_pedido_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" disabled>
                                    <input type="hidden" name="vfecha" value="<?php echo $fecha[0]['fecha']; ?>">
                                </div>
                                <div class="col-lg-4">
                                    <label for="sucursal" class="control-label">Sucursal:</label>
                                    <input type="text" id="sucursal" name="vid_sucursal_visible" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" disabled>
                                    <input type="hidden" name="vsucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
                                </div>
                                <div class="col-lg-4">
                                    <label for="vusuario" class="control-label">Usuario:</label>
                                    <input type="text" name="vusuario" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
                                    <input type="hidden" name="vusuario" value="<?php echo $_SESSION['usu_cod']; ?>">
                                </div>
                            </div>
                            <div class="row mt-3 mt-0">
                            <div class="col-lg-4">
        <label for="dep_cod" class="control-label">Deposito:</label>
        <select class="form-control select2" name="vdep_cod" id="vdep_cod" required>
            <option value="">Seleccione un Deposito</option>
            <?php 
            $id_sucursal = (int)$_SESSION['id_sucursal'];
            $deposito = consultas::get_datos("SELECT * FROM deposito WHERE id_sucursal = $id_sucursal");
            foreach ($deposito as $dep) { ?>
                <option value="<?php echo $dep['dep_cod']; ?>">
                    <?php echo htmlspecialchars($dep['dep_descri']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

                            <!-- Detalles de la Orden -->
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <h4>Detalles de la Orden</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Artículo a fabricar</th>
                                                <th class="text-center">Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detalle_orden">
                                            <tr>
                                                <td colspan="2" class="text-center">Seleccione una orden para cargar el detalle.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tabla Detalles -->
                            <div class="row mt-3">
                                <div class="col-lg-12 text-end">
                                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#detalleModal">Agregar Detalle</button>
                                </div>
                                <div class="col-lg-12 mt-3">
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
                                </div>
                            </div>

                            <!-- Botón Guardar -->
                            <div class="row mt-3">
                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-primary">Guardar Pedido</button>
                                </div>
                            </div>
                        </form>
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

     
<?php require 'menu/footer_lte.ctp'; ?>
 

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
                          <input type="hidden" name="vmaterial_id[]" value="${materialId}">
                          <input type="hidden" name="vcantidad[]" value="${cantidad}">
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




      <script>
      function cargarorden(ord_cod) {
    if (ord_cod) {
        console.log("Cargando detalles para la orden ID: " + ord_cod); // Log para verificar la llamada
        $.ajax({
            url: "get_pedido_materia_prima.php",
            type: "POST",
            data: { ord_cod: ord_cod },
            dataType: "json", // Indica que esperas un JSON
            success: function (response) {
                console.log("Respuesta recibida: ", response); // Verifica lo que llega del servidor
                if (response) {
                    $("#nombre_equipo").val(response.nombre_equipo || ''); // Rellena el campo de texto
                    $("#vequipo_id").val(response.vequipo_id || ''); // Rellena el campo oculto
                    let detalleHtml = '';
                    if (response.detalles && response.detalles.length > 0) {
                        response.detalles.forEach(detalle => {
                            detalleHtml += `
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                     
                                        ${detalle.art_descri}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                       
                                        ${detalle.ord_cant}
                                    </td>
                                </tr>`;
                        });
                    } else {
                        detalleHtml = '<tr><td colspan="3">No se encontraron detalles para esta orden.</td></tr>';
                    }
                    $("#detalle_orden").html(detalleHtml); // Actualiza la tabla de detalles
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error al cargar los detalles de la orden: " + textStatus);
            }
        });
    } else {
        $("#detalle_orden").html('<tr><td colspan="3">Seleccione una orden para cargar el detalle.</td></tr>');
    }
}


function buscarorden() {
    const query = document.getElementById('buscar_orden').value.trim(); // Elimina espacios extra
    if (query) {
        $.ajax({
            url: 'buscar_orden_produccion.php',
            type: 'POST',
            data: { query: query },
            success: function (response) {
                $('#orden').html(response); // Actualiza la lista de pedidos
                const firstOption = $('#orden option:first').val();
                if (firstOption) {
                    cargarorden(firstOption); // Carga detalles del pedido encontrado
                } else {
                    $('#detalle_orden').html('<tr><td class = "text-center" colspan="3">No se encontró ningúna orden con el ID ingresado.</td></tr>');
                }
            },
            error: function () {
                alert("Error al buscar la orden. Intente nuevamente.");
            }
        });
    } else {
        $('#orden').html('<option value="">Ingrese un ID de la orden</option>');
        $('#detalle_orden').html('<tr><td colspan="3">Ingrese un ID de la orden.</td></tr>');
    }
}


        </script>
      
</body>
</html>
