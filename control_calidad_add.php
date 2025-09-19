<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registrar Control de Calidad</title>
    <?php session_start(); require 'menu/css_lte.ctp'; ?>
    <style>
    .content-wrapper {
        padding: 20px;
        min-height: 100vh;
        background-color: #ffffff;
        /* Fondo blanco */
        border-radius: 5px;
        /* Opcional */
    }

    .form-header {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border-radius: 5px 5px 0 0;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .table th {
        background-color: #007bff;
        color: white;
    }

    .table-bordered {
        margin-top: 15px;
    }

    .divider {
        margin: 20px 0;
        border-bottom: 1px solid #ddd;
    }

    .content-wrapper {
        padding: 10px;
        min-height: 100vh;
    }

    .btn-custom {
        background-color: #ffcc00;
        /* Amarillo vibrante */
        color: #fff;
        border: none;
    }

    .btn-custom:hover {
        background-color: #ffaa00;
        /* Un amarillo más oscuro al pasar el ratón */
        color: #000;
        float: right !important;

    }

    .btn-custom {
        margin-right: 10px;
        margin-top: -35px;
        /* Mueve el botón hacia arriba */
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="form-header d-flex justify-content-between align-items-center">
                        <h3>Registrar Control de Calidad</h3>
                        <div>
                            <div class="d-flex justify-content-end">
                                <a href="control_calidad_index.php" class="btn btn-custom btn-md" style="float: right;"
                                    data-title="Volver">
                                    <i class="fa fa-arrow-left"></i> Volver
                                </a>



                            </div>

                        </div>

                    </div>

                    <!-- Formulario -->
                    <form action="control_calidad_control.php" method="post" class="form-horizontal">
                        <input type="hidden" name="accion" value="1">

                        <!-- Información General -->
                        <div class="divider"></div>
                        <h4>Información General</h4>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="control" class="form-label">Producciones Finalizadas:</label>
                                <select class="form-control" name="vcontrol_id" id="control"
                                    onchange="cargarcontrol(this.value)" required>
                                    <option value="">Seleccione una producción</option>
                                    <?php 
                                    $control = consultas::get_datos("SELECT * FROM v_listar_produccion_finalizadas ORDER BY control_id DESC");
                                    foreach ($control as $con) { ?>
                                    <option value="<?php echo $con['control_id']; ?>">
                                        <?php echo "N°: " . $con['control_id'] . " - Fecha: " . $con['fecha']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="buscar_produccion" class="form-label">Buscar Producción (ID):</label>
                                <div class="input-group">
                                    <input type="text" id="buscar_produccion" class="form-control"
                                        placeholder="Ingrese ID" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary"
                                            onclick="buscarproduccion()">Buscar</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="fecha" class="form-label">Fecha Inspección:</label>
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fecha = consultas::get_datos("SELECT CURRENT_TIMESTAMP AS fecha");
                                $fecha_formateada = date('Y-m-d\TH:i', strtotime($fecha[0]['fecha']));
                                ?>
                                <input type="datetime-local" name="fecha_visible" class="form-control"
                                    value="<?php echo $fecha_formateada; ?>" disabled>
                                <input type="hidden" name="vfecha_inspeccion" value="<?php echo $fecha[0]['fecha']; ?>">
                            </div>
                        </div>

                        <!-- Resultados -->
                        <div class="divider"></div>
                        <h4>Resultados</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="selectresultado" class="form-label">Resultados:</label>
                                <?php $resultado = consultas::get_datos("SELECT id_resultado, descripcion FROM resultado_calidad"); ?>
                                <select class="form-control" id="selectresultado" name="vid_resultado" required>
                                    <option value="">Seleccione el Resultado</option>
                                    <?php foreach ($resultado as $resul) { ?>
                                    <option value="<?php echo htmlspecialchars($resul['id_resultado']); ?>">
                                        <?php echo htmlspecialchars($resul['descripcion']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="observacion" class="form-label">Observación:</label>
                                <textarea id="observacion" name="vobservacion" class="form-control"
                                    placeholder="Ingrese una observación..."></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Columna para Aprobado -->
                            <div class="col-lg-6">
                                <label for="aprobado" class="form-label">Aprobado:</label>
                                <input type="checkbox" name="vaprobado" id="aprobado" value="true">
                            </div>

                            <?php
// Obtener el código del usuario logueado
$usu_cod = $_SESSION['usu_cod'] ?? null; // Usa null como valor predeterminado si no está definido

if ($usu_cod) {
    // Ejecutar la consulta para obtener los datos del empleado
    $empleado = consultas::get_datos("SELECT e.emp_cod, e.emp_nombre, e.emp_apellido 
                                      FROM usuarios u
                                      JOIN empleado e ON u.emp_cod = e.emp_cod
                                      WHERE u.usu_cod = {$usu_cod}");

    if (!empty($empleado)) {
        // Si hay resultados
        $emp_nombre = htmlspecialchars($empleado[0]['emp_nombre']);
        $emp_apellido = htmlspecialchars($empleado[0]['emp_apellido']);
        $emp_cod = htmlspecialchars($empleado[0]['emp_cod']);
    } else {
        // Si no hay resultados, inicializa con valores predeterminados
        $emp_nombre = $emp_apellido = $emp_cod = '';
    }
} else {
    // Si no hay código de usuario en la sesión
    echo '<p class="text-danger">Error: No se encontró un usuario logueado.</p>';
    $emp_nombre = $emp_apellido = $emp_cod = '';
}
?>

                            <div class="col-lg-6">
                                <label for="responsable_inspeccion" class="form-label">Responsable de Inspección</label>
                                <?php if (!empty($emp_nombre) && !empty($emp_apellido)) { ?>
                                <!-- Mostrar el empleado si hay datos -->
                                <input type="text" class="form-control" id="responsable_inspeccion_display"
                                    value="<?php echo $emp_nombre . ' ' . $emp_apellido; ?>" readonly>
                                <input type="hidden" name="vresponsable_inspeccion" value="<?php echo $emp_cod; ?>">
                                <?php } else { ?>
                                <!-- Mensaje si no hay datos del empleado -->
                                <p class="text-danger">No se encontró un empleado asociado al usuario logueado.</p>
                                <?php } ?>
                            </div>
                        </div>


                        <!-- Detalle del Pedido -->
                        <div class="divider"></div>
                        <h4>Detalle del Pedido</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Artículo</th>
                                        <th class="text-center">Etapas</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Cantidad Rechazada</th>
                                        <th class="text-center">Cantidad Crítica</th>
                                    </tr>
                                </thead>
                                <tbody id="detalle_control">
                                    <tr>
                                        <td colspan="5" class="text-center">Seleccione un pedido para cargar el detalle.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Botón de Envío -->
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

    <?php require 'menu/footer_lte.ctp'; ?>
    <?php require 'menu/js_lte.ctp'; ?>
    <script>
    $(document).ready(function() {
        // Inicializar Select2 en los selects existentes
        inicializarSelect2();

        // Evento para cargar el control dinámicamente
        $('#control').on('change', function() {
            cargarcontrol($(this).val());
        });
    });

    // Función para inicializar Select2 de forma organizada
    function inicializarSelect2() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione una opción',
            allowClear: true
        });

        $('#control').select2({
            width: 'resolve',
            placeholder: 'Seleccione una producción'
        });

        $('#selectresultado').select2({
            width: 'resolve',
            placeholder: 'Seleccione un resultado'
        });
    }

    // Función AJAX para cargar detalles dinámicamente
    function cargarcontrol(control_id) {
        if (control_id) {
            $.ajax({
                url: "get_control_calidad.php",
                type: "POST",
                dataType: "json",
                data: {
                    control_id: control_id
                },
                success: function(response) {
                    $("#detalle_control").html(response.detalles);


                    $("#detalle_control").find(".select2").each(function() {
                        if (!$(this).hasClass('select2-hidden-accessible')) {
                            $(this).select2({
                                width: '100%',
                                placeholder: 'Seleccione un estado',
                                allowClear: true
                            });
                        }
                    });
                },
                error: function(xhr, status, error) {
                    $("#detalle_control").html(
                        '<tr><td colspan="5" class="text-center">Error al cargar el detalle de la producción.</td></tr>'
                        );
                }
            });

        } else {
            $("#detalle_control").html(
                '<tr><td colspan="5" class="text-center">Debe seleccionar una producción.</td></tr>');
        }
    }
    // Función para buscar producción
    function buscarproduccion() {
        const query = $('#buscar_produccion').val().trim();
        if (query) {
            $.ajax({
                url: 'buscar_control_calidad.php',
                type: 'POST',
                data: {
                    query: query
                },
                success: function(response) {
                    $('#control').html(response).select2({
                        width: 'resolve',
                        placeholder: 'Seleccione una producción'
                    });

                    const firstOption = $('#control option:first').val();
                    if (firstOption) {
                        cargarcontrol(firstOption);
                    } else {
                        $('#detalle_control').html(
                            '<tr><td colspan="5" class="text-center">No se encontró ningún pedido con el ID ingresado.</td></tr>'
                            );
                    }
                },
                error: function() {
                    alert("Error al buscar la producción. Intente nuevamente.");
                }
            });
        } else {
            $('#control').html('<option value="">Ingrese un ID de la producción</option>');
            $('#detalle_control').html(
                '<tr><td colspan="5" class="text-center">Ingrese un ID de la producción.</td></tr>');
        }
    }

    // Habilitar/deshabilitar los campos de cantidad según el estado seleccionado
    function toggleCantidad(selectElement) {
        var row = selectElement.closest("tr");
        var cantidadRechazada = row.querySelector(".cantidad-rechazada");
        var cantidadCritica = row.querySelector(".cantidad-critica");

        if (selectElement.value == "9") { // Estado "Rechazado"
            cantidadRechazada.readOnly = false;
            cantidadCritica.readOnly = true;
            cantidadCritica.value = "";
        } else if (selectElement.value == "10") { // Estado "Crítico"
            cantidadRechazada.readOnly = true;
            cantidadCritica.readOnly = false;
            cantidadRechazada.value = "";
        } else {
            cantidadRechazada.readOnly = true;
            cantidadCritica.readOnly = true;
            cantidadRechazada.value = "";
            cantidadCritica.value = "";
        }
    }
    /*document.getElementById("formControlCalidad").addEventListener("submit", function() {
        document.querySelectorAll("input[disabled]").forEach(input => input.removeAttribute("disabled"));
    });*/
    </script>
</body>

</html>