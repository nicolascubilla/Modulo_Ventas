<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agregar Orden de Compras</title>
    <?php
    session_start();
    require 'menu/css_lte.ctp';
    ?>
    <style>
        /* Centrado y espaciado general */
        .form-group {
            margin-top: 15px;
        }

        .control-label {
            font-weight: bold;
        }

        /* Tabla */
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table {
            margin-top: 15px;
        }

        /* Diseño responsivo para columnas */
        .row {
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0"/>
</svg>
                                <h3 class="box-title">Agregar Orden de Compras</h3>
                                <div class="box-tools">
                                    <a href="ordcompra_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            <form action="ordcompra_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="1">
                                
                                <div class="box-body">
    <!-- Fila 1 -->
    <div class="row">
        <div class="col-lg-6">
            <label for="presupuesto" class="control-label">Presupuesto:</label>
            <select class="form-control select2" name="vpresupuesto_id" id="presupuesto" onchange="cargarPresupuesto(this.value)" required>
                <option value="">Seleccione un presupuesto</option>
                <?php 
                $presupuestos = consultas::get_datos("SELECT * FROM v_presupuesto_compra_cabecera WHERE estado_nombre ='PENDIENTE' ORDER BY presupuesto_id DESC");
                foreach ($presupuestos as $presupuesto) { ?>
                    <option value="<?php echo $presupuesto['presupuesto_id']; ?>">
                        <?php echo "N°: " . $presupuesto['presupuesto_id'] . " Fecha: " . $presupuesto['fecha_presu']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-6">
            <label for="buscar_presupuesto" class="control-label">Buscar Presupuesto (ID):</label>
            <div class="input-group">
                <input type="text" id="buscar_presupuesto" class="form-control" placeholder="Ingrese ID" autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onclick="buscarPresupuesto()">Buscar</button>
                </span>
            </div>
        </div>
    </div>

    <!-- Fila 2 -->
    <div class="row">
        <div class="col-lg-6">
            <label for="fecha" class="control-label">Fecha:</label>
            <?php
            date_default_timezone_set('America/Asuncion');
            $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_orden");
            $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_orden']));
            ?>
            <input type="datetime-local" name="fecha_orden_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" disabled>
            <input type="hidden" name="vfecha_orden" value="<?php echo $fecha[0]['fecha_orden']; ?>">
        </div>

        <div class="col-lg-6">
            <label for="prv_nombre" class="control-label">Proveedor seleccionado:</label>
            <input type="text" id="prv_nombre" name="prv_nombre" class="form-control" readonly>
            <input type="hidden" id="prv_cod" name="prv_cod">
        </div>
    </div>

    <!-- Fila 3 -->
    <div class="row">
        <div class="col-lg-6">
            <label for="vplazo_entrega" class="control-label">Fecha de Entrega:</label>
            <input type="date" name="vplazo_entrega" class="form-control" value="<?php echo consultas::get_datos("SELECT CURRENT_DATE AS plazo_entrega")[0]['plazo_entrega']; ?>">
        </div>

        <div class="col-lg-6">
            <label for="vusuario" class="control-label">Usuario:</label>
            <input type="text" name="vusuario" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
            <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
        </div>
    </div>

    <!-- Fila 4 -->
    <div class="row">
        <div class="col-lg-6">
            <label for="sucursal" class="control-label">Sucursal:</label>
            <input type="text" id="sucursal" name="vid_sucursal_visible" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" disabled>
            <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
        </div>
    </div>

    <!-- Detalle -->
    <div class="row">
        <div class="col-lg-12">
            <h4>Detalle del Presupuesto</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="detalle_presupuesto">
                    <tr>
                        <td colspan="4">Seleccione un presupuesto para cargar el detalle.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-floppy-o"></i> Registrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <?php require 'menu/footer_lte.ctp'; ?>

    <script>
        $(document).ready(function() {
            $('#presupuesto').select2({
                width: 'resolve',
                placeholder: 'Seleccione un presupuesto'
            });
        });
    </script>

    <script>
                function cargarPresupuesto(presupuesto_id) {
    if (presupuesto_id) {
        $.ajax({
            url: "get_presupuesto_orden_compra.php",
            type: "POST",
            dataType: "json", // Esperamos un JSON
            data: { presupuesto_id: presupuesto_id },
            success: function (response) {
                // Actualizar razón social
                $("#prv_nombre").val(response.razon_social);
                $("#prv_cod").val(response.prv_cod);

                // Actualizar detalles del presupuesto
                $("#detalle_presupuesto").html(response.detalles);
            },
            error: function () {
                console.error("Error al cargar los datos del presupuesto.");
            }
        });
    } else {
        // Reiniciar campos en caso de que no se seleccione un presupuesto
        $("#detalle_presupuesto").html('<tr><td colspan="3">Debe seleccionar un presupuesto.</td></tr>');
        $("#prv_nombre").val('');
    }
}

function buscarPresupuesto() {
    const query = document.getElementById('buscar_presupuesto').value.trim(); // Elimina espacios extra
    if (query) {
        $.ajax({
            url: 'buscar_presupuesto_orden_compra.php',
            type: 'POST',
            data: { query: query },
            success: function (response) {
                $('#presupuesto').html(response); // Actualiza la lista de pedidos
                const firstOption = $('#presupuesto option:first').val();
                if (firstOption) {
                    cargarPresupuesto(firstOption); // Carga detalles del pedido encontrado
                } else {
                    $('#detalle_presupuesto').html('<tr><td colspan="3">No se encontró ningún presupuesto con el ID ingresado.</td></tr>');
                }
            },
            error: function () {
                alert("Error al buscar el pedido. Intente nuevamente.");
            }
        });
    } else {
        $('#presupuesto').html('<option value="">Ingrese un ID de pedido</option>');
        $('#detalle_presupuesto').html('<tr><td colspan="3">Ingrese un ID de pedido.</td></tr>');
    }
}


      
    </script>

    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
