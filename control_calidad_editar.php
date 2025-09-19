<?php
session_start();
require 'menu/css_lte.ctp';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrar Control de Calidad</title>
    <style>
        .content-wrapper { padding: 20px; min-height: 100vh; background-color: #fff; border-radius: 5px; }
        .form-header { background-color: #007bff; color: #fff; padding: 10px; border-radius: 5px 5px 0 0; }
        .form-group { margin-bottom: 15px; }
        .form-label { font-weight: bold; display: block; margin-bottom: 5px; }
        .btn-primary { background-color: #007bff; border: none; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-custom {
            background-color: #ffcc00; color: #fff; border: none;
            margin-right: 10px; margin-top: -35px;
        }
        .btn-custom:hover { background-color: #ffaa00; color: #000; }
        .table th { background-color: #007bff; color: #fff; }
        .divider { margin: 20px 0; border-bottom: 1px solid #ddd; }
        .checkbox-lg { transform: scale(1.5); margin-right: 8px; }
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
                    <h3>Editar Control de Calidad</h3>
                    <div class="d-flex justify-content-end">
                <a href="control_calidad_index.php" class="btn btn-custom btn-md" style="float: right;" data-title="Volver">
    <i class="fa fa-arrow-left"></i> Volver
</a>
</div>
</div>
                <form action="control_calidad_control_update.php" method="post" class="form-horizontal">
                    <input type="hidden" name="accion" value="2">

                    <div class="divider"></div>
                    <h4>Información General</h4>

                    <?php
                    if (!empty($_GET['vcalidad_id'])) {
                        $calidad_id = $_GET['vcalidad_id'];
                        $datos = consultas::get_datos("SELECT * FROM v_control_calidad_cab_detall WHERE calidad_id = $calidad_id");

                        if (!empty($datos)) {
                            $cabecera = $datos[0];
                            $resultado = consultas::get_datos("SELECT id_resultado, descripcion FROM resultado_calidad");
                    ?>

<input type="hidden" name="vcalidad_id" value="<?= htmlspecialchars($cabecera['calidad_id']); ?>">
                    <!-- Fila 1 -->
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label>CONTROL ID</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cabecera['control_id']); ?>" readonly>
                            <input type="hidden" name="vcontrol_id" value="<?= htmlspecialchars($cabecera['control_id']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Fecha</label>
                            <input type="datetime-local" class="form-control"
                                   value="<?= date('Y-m-d\TH:i', strtotime($cabecera['fecha_inspeccion'])); ?>" disabled>
                            <input type="hidden" name="vfecha_inspeccion" value="<?= htmlspecialchars($cabecera['fecha_inspeccion']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="selectresultado">Resultado</label>
                            <select class="form-control select2" id="selectresultado" name="vid_resultado" required>
                                <option value="">Seleccione el Resultado</option>
                                <?php foreach ($resultado as $resul) { ?>
                                    <option value="<?= htmlspecialchars($resul['id_resultado']); ?>"
                                        <?= $resul['descripcion'] === $cabecera['resultado'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($resul['descripcion']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Fila 2 -->
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label>Observación</label>
                            <input type="text" class="form-control" name="vobservaciones" value="<?= htmlspecialchars($cabecera['observaciones']); ?>">
                        </div>

                        <div class="col-md-4">
    <label class="form-label d-block">Aprobado</label>
    <div class="form-check">
    <input type="checkbox" class="form-check-input checkbox-lg" id="aprobado_check" name="vaprobado" value="TRUE" <?= ($cabecera['aprobado'] === 'APROBADO') ? 'checked' : ''; ?>>

        <label class="form-check-label" for="aprobado_check">Sí</label>
        
      
    </div>
</div>


                        <div class="col-md-4">
                            <?php
                            $usu_cod = $_SESSION['usu_cod'] ?? null;
                            $emp_nombre = $emp_apellido = $emp_cod = '';

                            if ($usu_cod) {
                                $empleado = consultas::get_datos("SELECT e.emp_cod, e.emp_nombre, e.emp_apellido 
                                                                  FROM usuarios u JOIN empleado e ON u.emp_cod = e.emp_cod 
                                                                  WHERE u.usu_cod = {$usu_cod}");
                                if (!empty($empleado)) {
                                    $emp_nombre = htmlspecialchars($empleado[0]['emp_nombre']);
                                    $emp_apellido = htmlspecialchars($empleado[0]['emp_apellido']);
                                    $emp_cod = htmlspecialchars($empleado[0]['emp_cod']);
                                }
                            }
                            ?>
                            <label class="form-label">Responsable de Inspección</label>
                            <input type="text" class="form-control" value="<?= $emp_nombre . ' ' . $emp_apellido; ?>" readonly>
                            <input type="hidden" name="vresponsable_inspeccion" value="<?= $emp_cod; ?>">
                        </div>
                    </div>

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
                            <tbody>
                                <?php
                                $estados = consultas::get_datos("SELECT id_estado, nombre FROM estado WHERE id_estado IN (4,9,10) ORDER BY id_estado ASC");
                                foreach ($datos as $detalle) {
                                ?>


                                    <tr>
                                    <td>
    <!-- Este input hidden se envía al backend -->
    <input type="hidden" name="vart_cod[]" value="<?= htmlspecialchars($detalle['art_cod']); ?>">
     <!-- Etapa (input oculto que estás preguntando) -->
     <input type="hidden" name="vid_etapa[]" value="<?= htmlspecialchars($detalle['id_etapa']); ?>">

    
    <!-- Esta es la descripción que se muestra en pantalla -->
    <?= htmlspecialchars($detalle['art_descri']); ?>
</td>

                                        <td><input type="text" class="form-control" value="<?= htmlspecialchars($detalle['nombre_etapa']); ?>" readonly></td>
                                        <td><input type="number"  class="form-control" value="<?= htmlspecialchars($detalle['cantidad']); ?>" readonly></td>
                                        <td>
    <?php
    $esAprobado = ($detalle['nombre'] === 'APROBADO'); // o $detalle['nombre'] === 'APROBADO', según tu lógica
    ?>
    <select name="vid_estado[]" class="form-control select2 <?= $esAprobado ? 'estado-aprobado' : ''; ?>" <?= $esAprobado ? 'disabled' : ''; ?> required>

        <option value="">Seleccione</option>
        <?php foreach ($estados as $estado) { ?>
            <option value="<?= $estado['id_estado']; ?>"
                <?= ($estado['nombre'] === $detalle['nombre']) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($estado['nombre']); ?>
            </option>
        <?php } ?>
    </select>
    <?php if ($esAprobado): ?>
        <!-- Si está deshabilitado, agregamos un input hidden para enviar el valor igualmente -->
        <input type="hidden" name="vid_estado[]" value="<?= $detalle['id_estado']; ?>">
    <?php endif; ?>
</td>

                                        <td><input type="number"  class="form-control" value="<?= htmlspecialchars($detalle['cantidad_rechazada']); ?>" readonly></td>
                                        <td><input type="number"  class="form-control" value="<?= htmlspecialchars($detalle['cantidad_critica']); ?>" readonly></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="fa fa-floppy-o"></i> Guardar
                        </button>
                    </div>

                    <?php } // cierre if datos ?>
                    <?php } // cierre if GET ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'menu/footer_lte.ctp'; ?>
<?php require 'menu/js_lte.ctp'; ?>

<script>
    function inicializarSelect2() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione una opción',
            allowClear: true
        });

        $('#selectresultado').select2({
            width: 'resolve',
            placeholder: 'Seleccione un resultado'
        });
    }
    $(document).ready(function() {
    inicializarSelect2();

    // Desactivar select2 visualmente si tiene clase 'estado-aprobado'
    $('.estado-aprobado').each(function () {
        const $select = $(this);
        const $select2Instance = $select.select2();

        // disable visualmente el select2
        $select.prop('disabled', true);
        $select.select2("destroy"); // Destruye la instancia para que se vea como un select normal
    });
});



    $(document).ready(inicializarSelect2);
</script>
<script>
    $(document).ready(function() {
        $('#aprobado_check').on('change', function () {
            $('#vaprobado').val(this.checked ? 't' : 'f');
        });
    });
</script>

</body>
</html>
