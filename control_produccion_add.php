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
        .title-container { display: flex; align-items: center; gap: 10px; }
        .icon { width: 24px; height: auto; }
        .title { font-size: 2rem; margin: 0; }
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
                                    <h2 class="title">Agregar Control De Producción</h2>
                                </div>
                                <div class="box-tools">
                                    <a href="control_produccion_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        Volver <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Formulario principal -->
                            <form action="control_produccion_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="1">
                                <div class="box-body">
                                    <div class="container">
                                        <!-- Fila 1: Orden de Compra, Buscar Pedido, Fecha Avance -->
                                        <div class="row mt-3">
                                            <div class="col-lg-4 col-md-6">
                                                <label for="pedido" class="control-label">Ordenes Procesadas:</label>
                                                <select class="form-control select" name="vpedido_id" id="pedido" onchange="cargarpedido(this.value)" required>
                                                    <option value="">Seleccione un Pedido</option>
                                                    <?php 
                                                    $pedido = consultas::get_datos("SELECT * FROM v_listar_pedido_materia_pendiente ORDER BY pedido_id DESC");
                                                    foreach ($pedido as $ped) { ?>
                                                        <option value="<?php echo $ped['pedido_id']; ?>">
                                                            <?php echo "N°: " . $ped['pedido_id'] . " - Fecha: " . $ped['fecha']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <label for="buscar_pedido" class="control-label">Buscar Pedido (ID):</label>
                                                <div class="input-group">
                                                    <input type="text" id="buscar_pedido" class="form-control" placeholder="Ingrese ID" autocomplete="off">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary" onclick="buscarpedido()">Buscar</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <label for="fecha" class="control-label">Fecha Avance:</label>
                                                <?php
                                                date_default_timezone_set('America/Asuncion');
                                                $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha");
                                                $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha']));
                                                ?>
                                                <input type="datetime-local" name="fecha_visible" class="form-control" value="<?php echo $fecha_formateada; ?>" disabled>
                                                <input type="hidden" name="vfecha_avance" value="<?php echo $fecha[0]['fecha']; ?>">
                                            </div>
                                        </div>

                                        <!-- Fila 2: Progreso, Tiempo Invertido, Comentario -->
                                        <div class="row mt-3">
                                            <div class="col-lg-4 col-md-6">
                                                <label for="progreso" class="control-label">Progreso:</label>
                                                <textarea id="progreso" name="vprogreso" class="form-control" placeholder="Ingrese una descripción del progreso de la producción..."></textarea>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <label for="tiempo" class="control-label">Tiempo Invertido:</label>
                                                <input type="number" id="tiempo" name="vtiempo_invertido" class="form-control" placeholder="Ingrese tiempo invertido en horas..." step="0.01" min="0" max="999.99">
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <label for="comentario" class="control-label">Comentario:</label>
                                                <textarea id="comentario" name="vcomentario" class="form-control" placeholder="Ingrese un comentario adicional..."></textarea>
                                            </div>
                                        </div>

                                        <!-- Fila 3: Sucursal, Usuario -->
                                        <div class="row mt-3">
                                            <div class="col-lg-4 col-md-6">
                                                <label for="sucursal" class="control-label">Sucursal:</label>
                                                <input type="text" id="sucursal" name="vid_sucursal_visible" class="form-control" value="<?php echo $_SESSION['sucursal']; ?>" disabled>
                                                <input type="hidden" name="vid_sucursal" value="<?php echo $_SESSION['id_sucursal']; ?>">
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <label for="vusuario" class="control-label">Usuario:</label>
                                                <input type="text" name="vusuario" class="form-control" value="<?php echo $_SESSION['usu_nick']; ?>" disabled>
                                                <input type="hidden" name="vusu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">
                                            </div>
                                        </div>

                                        <!-- Detalle del Pedido -->
                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <h4>Detalle del Pedido:</h4>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Artículo</th>
                                                            <th>Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detalle_pedido">
                                                        <tr>
                                                            <td colspan="2">Seleccione un pedido para cargar el detalle.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Etapas de Producción -->
                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <h4>Etapas de Producción:</h4>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Orden</th>
                                                            <th>Nombre de la Etapa</th>
                                                            <th>Descripción</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detalle_etapas">
                                                        <tr>
                                                            <td colspan="4">Seleccione un artículo para ver las etapas.</td>
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
        <?php require 'menu/js_lte.ctp'; ?>
    

    <script>
        $(document).ready(function() {
            $('#pedido').select2({ width: 'resolve', placeholder: 'Seleccione un pedido' });
        });

        function cargarpedido(pedido_id) {
    if (pedido_id) {
        $.ajax({
            url: "get_control_produccion.php",
            type: "POST",
            dataType: "json",
            data: { pedido_id: pedido_id },
            success: function (response) {
                // Actualizar el detalle del pedido
                $("#detalle_pedido").html(response.detalles);

                // Actualizar las etapas de producción
                $("#detalle_etapas").html(response.etapas);
            },
            error: function () {
                console.error("Error al cargar los datos del pedido.");
                $("#detalle_pedido").html('<tr><td colspan="2">Error al cargar el detalle del pedido.</td></tr>');
                $("#detalle_etapas").html('<tr><td colspan="4">Error al cargar las etapas de producción.</td></tr>');
            }
        });
    } else {
        $("#detalle_pedido").html('<tr><td colspan="2">Debe seleccionar un pedido.</td></tr>');
        $("#detalle_etapas").html('<tr><td colspan="4">Seleccione un pedido para cargar las etapas de producción.</td></tr>');
    }
}


        function buscarpedido() {
    const query = document.getElementById('buscar_pedido').value.trim();
    if (query) {
        $.ajax({
            url: 'buscar_control_produccion.php',
            type: 'POST',
            data: { query: query },
            success: function(response) {
                $('#pedido').html(response);
                $('#pedido').select2({ width: 'resolve', placeholder: 'Seleccione un pedido' }); // Reinicia select2
                const firstOption = $('#pedido option:first').val();
                if (firstOption) {
                    cargarpedido(firstOption);
                } else {
                    $('#detalle_pedido').html('<tr><td colspan="3">No se encontró ningún pedido con el ID ingresado.</td></tr>');
                }
            },
            error: function() {
                alert("Error al buscar el pedido. Intente nuevamente.");
            }
        });
    } else {
        $('#pedido').html('<option value="">Ingrese un ID del pedido</option>');
        $('#detalle_pedido').html('<tr><td colspan="3">Ingrese un ID del pedido.</td></tr>');
    }
}

function cargarEtapas(art_cod) {
    if (art_cod) {
        $.ajax({
            url: "get_articulo_etapas.php",
            type: "POST",
            dataType: "json",
            data: { art_cod: art_cod },
            success: function (response) {
                if (response.etapas && response.etapas.length > 0) {
                    let etapasHtml = '';
                    response.etapas.forEach(function (etapa) {
                        etapasHtml += `
                            <tr>
                                <td>${etapa.orden}</td>
                                <td>${etapa.nombre_etapa}</td>
                                <td>${etapa.descripcion ?? 'Sin descripción'}</td>
                                <td>
                                    <input type="checkbox" name="vestado_etapa[${etapa.id_etapa}]" value="8">
                                    Cumplido
                                </td>
                            </tr>
                        `;
                    });
                    $('#detalle_etapas').html(etapasHtml);
                } else {
                    $('#detalle_etapas').html('<tr><td colspan="4">No se encontraron etapas para este artículo.</td></tr>');
                }
            },
            error: function () {
                console.error("Error al cargar las etapas de producción.");
                $('#detalle_etapas').html('<tr><td colspan="4">Error al cargar las etapas.</td></tr>');
            }
        });
    } else {
        $('#detalle_etapas').html('<tr><td colspan="4">Seleccione un artículo para ver las etapas.</td></tr>');
    }
}



 
    </script>
    <script>
    document.getElementById('tiempo').addEventListener('input', function (e) {
        let value = parseFloat(e.target.value);
        if (!isNaN(value)) {
            e.target.value = value.toFixed(2); // Formato con dos decimales
        }
    });
</script>
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
