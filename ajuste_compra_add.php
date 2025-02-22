<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agregar Factura de Compras</title>
    <?php session_start(); require 'menu/css_lte.ctp'; ?>
    <style>
        .form-group { margin-top: 15px; }
        .control-label { font-weight: bold; }
        .table th, .table td { text-align: center; vertical-align: middle; }
        .table th { background-color: #f4f4f4; }
        .table { margin-top: 15px; }
        .row { margin-bottom: 15px; }
        .form-horizontal .col-lg-3, .form-horizontal .col-lg-6 { margin-bottom: 15px; }

        .title-container {
    display: flex;
    align-items: center; /* Alinea el SVG y el título verticalmente */
    gap: 10px; /* Espaciado entre la imagen y el título */
}

.icon {
    width: 24px; /* Ajusta el tamaño del SVG */
    height: auto; /* Mantén las proporciones */
}

.title {
    font-size: 2.5rem; /* Ajusta el tamaño del título */
    margin: 0; /* Elimina márgenes innecesarios */
}

    #vdep_cod {
        margin-top: -0px; /* Ajusta este valor según necesites */
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
                            <div class="title-container">
    <!-- Ícono SVG -->
    <img src="img/icons8-ajustes (1).gif" alt="Ajustes" width="50" height="50">
</svg> <h2  class="title">Ajustes de Mercaderias</h2></div>
                                
                                <div class="box-tools">
                                    <a href="ajuste_compra_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>

                            <form action="ajustes_compras_control.php" method="post" class="form-horizontal">
    <input type="hidden" name="accion" value="1">
    <div class="box-body">

    <div class="container">
    <!-- Fila 1 - Factura Compra, Buscar Factura, N° Factura Proveedor -->
    <div class="row">
        <div class="col-lg-4">
            <label for="id_factura" class="control-label">Factura Compra:</label>
            <select class="form-control select2" name="vid_factura" id="id_factura" onchange="cargarfactura(this.value)" required>
                <option value="">Seleccione una Factura</option>
                <?php 
                $factura = consultas::get_datos("SELECT DISTINCT id_factura, fecha_emision FROM v_factura_compra_cabecera_detalle ORDER BY id_factura DESC");
                foreach ($factura as $fact) { ?>
                    <option value="<?php echo $fact['id_factura']; ?>">
                        <?php echo "N°: " . $fact['id_factura'] . " - Fecha: " . $fact['fecha_emision']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-4">
        <label for="buscar_factura" class="control-label">Buscar Factura (ID):</label>
            <div class="input-group">
                <input type="text" id="buscar_factura" class="form-control" placeholder="Ingrese ID" autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onclick="buscarFactura()">Buscar</button>
                </span>
            </div>
        </div>



        <div class="col-lg-4">
            <label for="factura_proveedor" class="control-label">N° Factura Proveedor:</label>
            <input type="text" id="factura_proveedor" name="factura_proveedor" class="form-control" readonly>
        </div>
    </div>

    <!-- Fila 2 - Proveedor, Sucursal, Usuario -->
    <div class="row mt-3">
        <div class="col-lg-4">
            <label for="prv_nombre" class="control-label">Proveedor Seleccionado:</label>
            <input type="text" id="prv_nombre" name="prv_nombre" class="form-control" readonly>
            <input type="hidden" id="prv_cod" name="vprv_cod">
        </div>

        <div class="col-lg-4">
            <label for="sucursal" class="control-label">Sucursal:</label>
            <input type="text" id="sucursal" name="vid_sucursal_visible" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" readonly>
            <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
        </div>

        <div class="col-lg-4">
            <label for="vusuario" class="control-label">Usuario:</label>
            <input type="text" id="vusuario" name="vusuario_visible" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" readonly>
            <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
        </div>
    </div>

    <!-- Fila 3 - Fecha ajuste, N° Timbrado, Tipo de Ajuste -->
    <div class="row mt-3">
        <div class="col-lg-4">
            <label for="fecha_ajuste" class="control-label">Fecha Ajuste:</label>
            <?php
            date_default_timezone_set('America/Asuncion');
            $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_ajuste");
            $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_ajuste']));
            ?>
            <input type="datetime-local" id="fecha_ajuste" name="fecha_ajuste_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" readonly>
            <input type="hidden" name="vfecha_ajuste" value="<?php echo $fecha[0]['fecha_ajuste']; ?>">
        </div>

        <div class="col-lg-4">
            <label for="vtimbrado" class="control-label">N° Timbrado:</label>
            <input type="text" id="vtimbrado" name="vtimbrado" class="form-control" readonly>
        </div>

        <div class="col-lg-4">
            <label for="id" class="control-label">Tipo de Ajuste:</label>
            <select class="form-control select2" name="vid_concepto" id="id" required>
                <option value="">Seleccione un Tipo de Ajuste</option>
                <?php 
                $concepto = consultas::get_datos("SELECT * FROM conceptosajustes WHERE estado ='A'");
                foreach ($concepto as $concep) { ?>
                    <option value="<?php echo $concep['id']; ?>">
                        <?php echo $concep['concepto']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Fila 4 - Condición -->
    <div class="row mt-3">
        <div class="col-lg-4">
            <label for="condicion" class="control-label">Condición:</label>
            <input type="text" id="condicion" name="condicion_visible" class="form-control" readonly>
            <input type="hidden" name="condicion" id="condicion_hidden">
        </div>
    </div>

    <!-- Fila con Descripción -->
    <div class="row mt-3">
        <div class="col-lg-12">
            <label for="descripcion" class="control-label">Descripción:</label>
            <textarea id="descripcion" name="vdescripcion" class="form-control" rows="5" placeholder="Ingrese una descripción..."></textarea>
        </div>
    </div>

    <!-- Fila 5 - Detalle de la Orden -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <h4>Detalle de la Factura:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Cantidad A AJUSTAR</th>
                        <th>Costo Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="detalle_factura">
                    <tr>
                        <td colspan="4">Seleccione una factura para cargar el detalle.</td>
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
            $('#factura').select2({ width: 'resolve', placeholder: 'Seleccione una factura' });
        });

        function cargarfactura(id_factura) {
    if (id_factura) {
        $.ajax({
            url: "get_factura_ajustes_compra.php",
            type: "POST",
            dataType: "json",
            data: { id_factura: id_factura },
            success: function (response) {
                if (response) { 
                    $("#prv_nombre").val(response.proveedor); // Nombre del proveedor
                    $("#factura_proveedor").val(response.id_factu_proveedor); // Número de factura del proveedor
                    $("#vid_sucursal_visible").val(response.sucursal); // Sucursal
                    $("#vtimbrado").val(response.vtimbrado); // Timbrado
                    $("#condicion").val(response.vcondicion); // Condición
                    $("#detalle_factura").html(response.detalles); // Detalles de la factura en la tabla
                } else {
                    console.error("No se encontraron datos.");
                }
            },
            error: function () {
                console.error("Error al cargar los datos de la factura.");
            },
        });
    } else {
        $("#detalle_factura").html('<tr><td colspan="5">Debe seleccionar una factura.</td></tr>');
        $("#prv_nombre").val('');
    }
}

function buscarFactura() {
    const query = document.getElementById('buscar_factura').value.trim(); 
    if (query) {
        $.ajax({
            url: 'buscar_factura_ajuste.php',
            type: 'POST',
            data: { query: query },
            success: function (response) {
                console.log(response); // Depuración
                $('#id_factura').html(response); // Asegúrate de que 'id_factura' es correcto
                const firstOption = $('#id_factura option:first').val();
                if (firstOption) {
                    cargarfactura(firstOption); // Asegúrate de que cargarfactura funcione correctamente
                } else {
                    $('#detalle_factura').html('<tr><td colspan="3">No se encontró ninguna factura con el ID ingresado.</td></tr>');
                }
            },
            error: function () {
                alert("Error al buscar la factura. Intente nuevamente.");
            }
        });
    } else {
        $('#id_factura').html('<option value="">Ingrese un ID de factura</option>');
        $('#detalle_factura').html('<tr><td colspan="3">Ingrese un ID de factura.</td></tr>');
    }
}




 
    </script>
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
