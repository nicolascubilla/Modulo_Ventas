<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agregar Presupuesto</title>
    <?php
    session_start();
    require 'menu/css_lte.ctp';
    ?>
    <style>
        /* Ajustar el diseño del formulario */
        .form-group label {
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #f4f4f4;
        }
        #buscar_pedido {
            width: calc(70% - 5px);
            display: inline-block;
        }
        #btn_buscar {
            width: 28%;
            display: inline-block;
        }
        .custom-select {
    width: 100%; /* Ancho total de la columna */
    height: 40px; /* Altura personalizada */
    font-size: 14px; /* Ajusta el tamaño del texto si es necesario */
    padding: 5px; /* Espaciado interno */
}
.custom-select {
    height: 38px; /* Altura del selector */
    font-size: 14px;
}

.input-group-btn .btn {
    height: 38px; /* Altura del botón para que coincida con el campo */
}

.select2-container--default .select2-selection--single {
    height: 38px; /* Para que el selector de Select2 tenga la misma altura */
    line-height: 38px;
}

.input-group {
    width: 100%; /* Asegura que el grupo ocupe todo el espacio disponible */
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <i class="fa fa-plus"></i>
                                <h3 class="box-title">Agregar Presupuesto de Compra</h3>
                                <div class="box-tools">
                                    <a href="presupuesto_compra_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            <form action="presupuesto_compra_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="1">
                                
                                <div class="box-body">
                                    <!-- Fecha -->
                                    <div class="form-group row">
                                        <label for="fecha" class="control-label col-sm-2">Fecha:</label>
                                        <div class="col-sm-4">
                                            <?php
                                            date_default_timezone_set('America/Asuncion');
                                            $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha_presu");
                                            $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha_presu']));
                                            ?>
                                            <input type="datetime-local" name="fecha_pedido_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" disabled>
                                            <input type="hidden" name="vfecha_presu" value="<?php echo $fecha[0]['fecha_presu']; ?>">
                                        </div>
                                    </div>
                                    <!-- Usuario -->
                                    <div class="form-group row">
                                        <label for="usuario" class="control-label col-sm-2">Usuario:</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="vusuario" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
                                            <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <div class="form-group row">
    <!-- Selector de Pedido -->
    <label for="pedido" class="control-label col-lg-2 col-md-2 col-sm-2">Pedido:</label>
    <div class="col-lg-4 col-md-4 col-sm-4">
        <select class="form-control select2 custom-select" name="vid_pedido" id="pedido" onchange="cargarPedido(this.value)" required>
            <option value="">Seleccione un pedido</option>
            <?php 
            $pedidos = consultas::get_datos("SELECT * FROM v_pedido_compra_listar WHERE estado='PENDIENTE'");
            foreach ($pedidos as $pedido) { ?>
                <option value="<?php echo $pedido['id_pedido']; ?>">
                    <?php echo "N°: " . $pedido['id_pedido'] . " Fecha: " . $pedido['fecha_pedido']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <!-- Buscador de Pedido -->
    <label for="buscar_pedido" class="control-label col-lg-1 col-md-2 col-sm-2">Buscar Pedido (ID):</label>
    <div class="col-lg-3 col-md-2 col-sm-1">
        <div class="input-group">
            <input type="text" id="buscar_pedido" class="form-control" placeholder="Ingrese ID" autocomplete="off">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary" onclick="buscarPedido()">Buscar</button>
            </span>
        </div>
    </div>
</div>

<!-- Proveedor -->
<div class="form-group row">
    <label for="prv_cod" class="control-label col-lg-2 col-md-2 col-sm-2">Proveedor:</label>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?php
        $proveedores = consultas::get_datos("SELECT prv_cod, prv_razonsocial FROM proveedor");
        if ($proveedores) { ?>
            <select class="form-control select2" id="prv_cod" name="vprv_cod" required>
                <option value="">Seleccione el proveedor</option>
                <?php foreach ($proveedores as $proveedor) { ?>
                    <option value="<?php echo htmlspecialchars($proveedor['prv_cod']); ?>">
                        <?php echo htmlspecialchars($proveedor['prv_razonsocial']); ?>
                    </option>
                <?php } ?>
            </select>
        <?php } else { ?>
            <p class="text-danger">No se encontraron proveedores disponibles.</p>
        <?php } ?>
    </div>
</div>

<!-- Sucursal -->
<div class="form-group row">
    <label for="sucursal" class="control-label col-lg-2 col-md-2 col-sm-2">Sucursal:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <input type="text" id="sucursal" name="vid_sucursal" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" disabled>
    </div>
    <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
</div>


                                    <!-- Detalle del Pedido -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <h4>Detalle del Pedido</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 45%">Material</th>
                                                        <th style="width: 25%">Cantidad</th>
                                                        <th style="width: 25%">Costo Unitario</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detalle_pedido">
                                                    <tr>
                                                        <td colspan="3">Seleccione un pedido para cargar el detalle.</td>
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
             function cargarPedido(id_pedido) {
    if (id_pedido) {
        console.log("Cargando detalles para el pedido ID: " + id_pedido); // Agregar un log para verificar la llamada
        $.ajax({
            url: "get_presupuesto_pedido.php",
            type: "POST",
            data: { id_pedido: id_pedido },
            success: function (response) {
                console.log("Respuesta recibida: ", response); // Verifica lo que llega del servidor
                $("#detalle_pedido").html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error al cargar los detalles del pedido: " + textStatus);
            }
        });
    } else {
        $("#detalle_pedido").html('<tr><td colspan="3">Seleccione un pedido para cargar el detalle.</td></tr>');
    }
}
function buscarPedido() {
    const query = document.getElementById('buscar_pedido').value.trim(); // Elimina espacios extra
    if (query) {
        $.ajax({
            url: 'buscar_pedido_compra.php',
            type: 'POST',
            data: { query: query },
            success: function (response) {
                $('#pedido').html(response); // Actualiza la lista de pedidos
                const firstOption = $('#pedido option:first').val();
                if (firstOption) {
                    cargarPedido(firstOption); // Carga detalles del pedido encontrado
                } else {
                    $('#detalle_pedido').html('<tr><td colspan="3">No se encontró ningún pedido con el ID ingresado.</td></tr>');
                }
            },
            error: function () {
                alert("Error al buscar el pedido. Intente nuevamente.");
            }
        });
    } else {
        $('#pedido').html('<option value="">Ingrese un ID de pedido</option>');
        $('#detalle_pedido').html('<tr><td colspan="3">Ingrese un ID de pedido.</td></tr>');
    }
}


      
    </script>
    <script>
        $(document).ready(function() {
    $('#pedido').select2({
        width: 'resolve', // Ajusta el ancho automáticamente
        placeholder: 'Seleccione un pedido'
    });
});

     </script>
      
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
