<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Agregar Factura de Compras</title>
<?php session_start(); require 'menu/css_lte.ctp'; ?>
<style>
    /* Ajustes personalizados para las columnas */
    .form-control {
        font-size: 14px; /* Tamaño más pequeño para los campos */
        padding: 4px 8px;
    }

    label {
        font-size: 15px; /* Tamaño más pequeño para etiquetas */
    }

    .table th, .table td {
        font-size: 13px;
        padding: 4px;
    }

    .input-group-btn button {
        font-size: 13px;
    }

    .box-header h3 {
        font-size: 18px; /* Reduce el tamaño del título */
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
                            <!-- Encabezado -->
                            <div class="box-header">
                                <h3 class="box-title">
                                <img width="50" height="50" src="https://img.icons8.com/ios/50/create-order--v1.png" alt="create-order--v1"/>
                                    Orden de Producción
                                </h3>
                                <div class="box-tools">
                                    <a href="orden_produccion_index.php" class="btn btn-primary btn-sm">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>

                            <!-- Formulario -->
                            <form action="ordenproduccion_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="1">

                                <!-- Selección de presupuesto -->
                                <div class="box-body">
                                    <!-- Selección de presupuesto y búsqueda -->
                                    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-3">
            <label for="presupuesto" class="control-label">Presupuesto:</label>
            <select class="form-control select2 custom-select" name="vpre_cod" id="presupuesto" onchange="cargarpresupuesto(this.value)" required>
                <option value="">Seleccione un Presupuesto</option>
                <?php 
                $presupuestos = consultas::get_datos("SELECT Distinct pre_cod, fecha_emision FROM v_presupuestos_pendientes ORDER BY pre_cod DESC");
                foreach ($presupuestos as $pre) { ?>
                    <option value="<?php echo $pre['pre_cod']; ?>">
                        <?php echo "N°: " . $pre['pre_cod'] . " - Fecha: " . $pre['fecha_emision']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-6 mb-3">
            <label for="buscar_presupuesto" class="control-label">Buscar presupuesto (ID):</label>
            <div class="input-group">
                <input type="text" id="buscar_presupuesto" class="form-control" placeholder="Ingrese ID" autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onclick="buscarpresupuesto()">Buscar</button>
                </span>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 mb-3">
            <label for="fecha" class="control-label">Fecha:</label>
            <?php
            date_default_timezone_set('America/Asuncion');
            $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha");
            $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha']));
            ?>
            <input type="datetime-local" id="fecha" name="fecha_orden_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" readonly>
            <input type="hidden" name="vfecha" value="<?php echo $fecha[0]['fecha']; ?>">
        </div>

        <div class="col-lg-6 mb-3">
            <label for="selectEquipo" class="control-label">Seleccionar equipo:</label>
            <?php $equipos = consultas::get_datos("SELECT * FROM equipo_trabajo"); ?>
            <select class="form-control select2 custom-select" id="selectEquipo" name="vequipo_id" required>
                <option value="">Seleccione un equipo</option>
                <?php foreach ($equipos as $equipo) { ?>
                    <option value="<?php echo $equipo['equipo_id']; ?>"><?php echo $equipo['nombre_equipo']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 mb-3">
            <label for="sucursal" class="control-label">Sucursal:</label>
            <input type="text" id="sucursal" name="vid_sucursal_visible" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" readonly>
            <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
        </div>

        <div class="col-lg-6 mb-3">
            <label for="vusuario" class="control-label">Usuario:</label>
            <input type="text" id="vusuario" name="vusuario_visible" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" readonly>
            <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
        </div>
    </div>
</div>

                                    <!-- Detalles de la Orden -->
                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <h4>Detalles de la orden:</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Artículo</th>
                                                            <th>Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detalle_presupuesto">
                                                        <tr>
                                                            <td colspan="2" class="text-center">Seleccione un presupuesto para cargar el detalle.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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
        <?php require 'menu/footer_lte.ctp'; ?>
        
        <!-- Archivos JS -->
        <script>
            $(document).ready(function() {
                $('#presupuesto').select2({
                    width: 'resolve',
                    placeholder: 'Seleccione un presupuesto'
                });
            });
        </script>

        <script>
                function cargarpresupuesto(pre_cod) {
    if (pre_cod) {
        console.log("Cargando detalles para el presupuesto ID: " + pre_cod); // Agregar un log para verificar la llamada
        $.ajax({
            url: "get_presupuesto_ordenes.php",
            type: "POST",
            data: { pre_cod: pre_cod },
            success: function (response) {
                console.log("Respuesta recibida: ", response); // Verifica lo que llega del servidor
                $("#detalle_presupuesto").html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error al cargar los detalles del presupuesto: " + textStatus);
            }
        });
    } else {
        $("#detalle_presupuesto").html('<tr><td colspan="3">Seleccione un presupuesto para cargar el detalle.</td></tr>');
    }
}

            function buscarpresupuesto() {
                const query = $("#buscar_presupuesto").val();
                if (query) {
                    $.ajax({
                        url: "buscar_presupuesto_ordenes.php",
                        type: "POST",
                        data: { query },
                        success: function(response) {
                            $("#presupuesto").html(response);
                            cargarpresupuesto($("#presupuesto").val());
                        },
                        error: function() {
                            alert("Error al buscar el presupuesto.");
                        }
                    });
                }
            }
        </script>
         <?php require 'menu/js_lte.ctp'; ?>
    </div>
</body>
</html>
