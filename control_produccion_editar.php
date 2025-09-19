<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar Presupuesto</title>
    <?php
    session_start();
    require 'menu/css_lte.ctp';
    ?>
    <style>
        .form-group label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .custom-select {
            width: 100%;
            height: 40px;
            font-size: 14px;
            padding: 5px;
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
                                <i class="fa fa-edit"></i>
                                <h3 class="box-title">Editar Avances Producción</h3>
                                <div class="box-tools">
                                    <a href="control_produccion_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                            <form action="control_produccion_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="2">
                              

                                <div class="box-body">
                                    <?php
                                    if (!empty($_GET['vcontrol_id'])) {
                                        $vcontrol_id = $_GET['vcontrol_id'];
                                        $control_pro = consultas::get_datos("SELECT * FROM v_control_produccion_cabe_detall WHERE control_id = $vcontrol_id");
    
                                        if (!empty($control_pro)) {
                                            $cabecera = $control_pro[0];
                                    ?>
                                           
                                               
                                               
                                                <div class="form-group row">
    <label for="control_id" class="control-label col-lg-2 col-md-2 col-sm-2">Control ID N°:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <input type="text" class="form-control" value="<?php echo $cabecera['control_id']; ?>" disabled>
        <!-- <input type="hidden" name="vcontrol_id" value="<?php echo $cabecera['control_id']; ?>">-->
        <input type="hidden" name="vpedido_id" value="<?php echo $cabecera['pedido_id']; ?>">
       
    </div>

    <label for="fecha" class="control-label col-lg-2 col-md-2 col-sm-2">Fecha:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <input type="datetime-local" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($cabecera['fecha_avance'])); ?>" disabled>
        <input type="hidden" name="vfecha_avance" 
        value="<?php echo date('Y-m-d H:i:s', strtotime($cabecera['fecha_avance'])); ?>">
    </div>
</div>

<div class="form-group row">
    <label for="estado" class="control-label col-lg-2 col-md-2 col-sm-2">Estado:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <input type="text" class="form-control" value="<?php echo $cabecera['estado_control']; ?>" disabled>
    </div>
    
    <label for="progreso" class="control-label col-lg-2 col-md-2 col-sm-2">Progreso:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
    <input type="text" class="form-control" name="vprogreso" id="progreso" value="<?php echo htmlspecialchars($cabecera['progreso']); ?>">
    </div>
</div>

<div class="form-group row">
    <label for="tiempo" class="control-label col-lg-2 col-md-2 col-sm-2">Tiempo Invertido:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
    <input type="number" class="form-control" name="vtiempo_invertido" id="tiempo" value="<?php echo htmlspecialchars($cabecera['tiempo_invertido']); ?>">
    </div>
    
    <label for="comentario" class="control-label col-lg-2 col-md-2 col-sm-2">Comentario:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
     <input type="text" class="form-control" name="vcomentario" id="comentario" value="<?php echo htmlspecialchars($cabecera['comentarios']); ?>">
    </div>
</div>

<div class="form-group row">
    <label for="usuario" class="control-label col-lg-2 col-md-2 col-sm-2">Usuario:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <input type="text" class="form-control" value="<?php echo $cabecera['usu_nick']; ?>" disabled>
    </div>
    <input type="hidden" name="vusu_cod" value="<?php echo $cabecera['usu_cod']; ?>">
    
    <label for="sucursal" class="control-label col-lg-2 col-md-2 col-sm-2">Sucursal:</label>
    <div class="col-lg-3 col-md-4 col-sm-4">
        <input type="text" class="form-control" value="<?php echo $cabecera['suc_descri']; ?>" disabled>
    </div>
    <input type="hidden" name="vid_sucursal" value="<?php echo $cabecera['id_sucursal']; ?>">
</div>

<div class="form-group row">
    <div class="col-lg-12">
        <h4>Detalle del Control Producción</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Etapa</th>
                    <th>Estado Etapa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($control_pro as $detalle) { ?>
                    <tr>
                        <td><?php echo $detalle['descripcion_articulo']; ?></td>
                        <input type="hidden" name="vart_cod[]" value="<?php echo $detalle['art_cod']; ?>">

                        <td>
                            <input type="text" class="form-control" value="<?php echo $detalle['cantidad']; ?>" readonly>
                            <input type="hidden" name="vcantidad[]" value="<?php echo $detalle['cantidad']; ?>">
                        </td>
                        <td>
                        <span class="form-control" style="background-color: #e9ecef;"><?php echo $detalle['nombre_etapa']; ?></span>

                            <input type="hidden" name="vid_etapa[]" value="<?php echo $detalle['id_etapa']; ?>">
                        </td>
                        <td>
    <input type="checkbox" name="vestado_etapa[<?php echo $detalle['id_etapa']; ?>]" class="form-check-input"
        value="8" <?php echo ($detalle['id_estado_etapa'] == 8) ? 'checked' : '';?>>
    <!-- Solo se enviará '8' si está marcado, de lo contrario, el valor predeterminado será '1' -->
    <?php echo ($detalle['id_estado_etapa'] == 8) ? 'Cumplido' : 'Pendiente'; ?>
</td>





                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

                                    <?php }
                                    } ?>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-save"></i> Guardar Cambios
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
    <?php require 'menu/js_lte.ctp'; ?>
    <script>
    document.getElementById('tiempo').addEventListener('input', function (e) {
        let value = parseFloat(e.target.value);
        if (!isNaN(value)) {
            e.target.value = value.toFixed(2); // Formato con dos decimales
        }
    });
</script>

</body>

</html>
