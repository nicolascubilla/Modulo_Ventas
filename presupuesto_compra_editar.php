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
                                <h3 class="box-title">Editar Presupuesto de Compra</h3>
                                <div class="box-tools">
                                    <a href="presupuesto_compra_index.php" class="btn btn-primary btn-md" data-title="Volver">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            <form action="presupuesto_compra_control_editar.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="3">
                              

                                <div class="box-body">
                                    <?php
                                    if (!empty($_GET['vpresupuesto_id'])) {
                                        $vpresupuesto_id = $_GET['vpresupuesto_id'];
                                        $presupuestocompra = consultas::get_datos("SELECT * FROM v_presupuesto_compra_cabecera_detalle_result WHERE presupuesto_id = $vpresupuesto_id");
    
                                        if (!empty($presupuestocompra)) {
                                            $cabecera = $presupuestocompra[0];
                                    ?>
                                            <div class="form-group row">
                                                <label for="presupuesto_id" class="control-label col-lg-2 col-md-2 col-sm-2">Presupuesto N°:</label>
                                                <div class="col-lg-3 col-md-4 col-sm-4">
                                                    <input type="text" class="form-control" value="<?php echo $cabecera['presupuesto_id']; ?>" disabled>
                                                    <input type="hidden" name="vpresupuesto_id" value="<?php echo $cabecera['presupuesto_id']; ?>">

                                                </div>
                                               
                                               
                                            </div>
                                            <input type="hidden" name="vid_pedido" value="<?php echo $cabecera['id_pedido']; ?>">

                                            <div class="form-group row">
                                                <label for="fecha" class="control-label col-sm-2">Fecha:</label>
                                                <div class="col-sm-4">
                                                    <input type="datetime-local" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($cabecera['fecha'])); ?>" disabled>
                                                </div>
                                                <input type="hidden" name="vfecha_presu" value="<?php echo $cabecera['fecha_presu']; ?>">
                                            </div>

                                            <div class="form-group row">
                                                <label for="usuario" class="control-label col-sm-2">Usuario:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" value="<?php echo $cabecera['usuario']; ?>" disabled>
                                                </div>
                                                <input type="hidden" name="vusu_cod" value="<?php echo $cabecera['usu_cod']; ?>">
                                            </div>

                                            <div class="form-group row">
                                                <label for="prv_cod" class="control-label col-lg-2">Proveedor:</label>
                                                <div class="col-lg-6">
                                                    <?php
                                                    $proveedores = consultas::get_datos("SELECT prv_cod, prv_razonsocial FROM proveedor");
                                                    ?>
                                                    <select class="form-control select2" name="vprv_cod" required>
                                                        <?php foreach ($proveedores as $proveedor) { ?>
                                                            <option value="<?php echo $proveedor['prv_cod']; ?>" <?php echo ($proveedor['prv_cod'] == $cabecera['prv_razonsocial'] ? 'selected' : ''); ?>>
                                                                <?php echo $proveedor['prv_razonsocial']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="sucursal" class="control-label col-lg-2">Sucursal:</label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" value="<?php echo $cabecera['sucursal']; ?>" disabled>
                                                </div>
                                                <input type="hidden" name="vid_sucursal" value="<?php echo $cabecera['id_sucursal']; ?>">
                                            </div>

                                            <div class="form-group row">
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
                                                        <tbody>
                                                            <?php foreach ($presupuestocompra as $detalle) { ?>
                                                                <tr>
                                                                    <td><?php echo $detalle['material']; ?></td>
                                                                    <td><input type="text" class="form-control" value="<?php echo $detalle['cantidad']; ?>" readonly></td>
                                                                    <td>
                                                                    <input type="number" name="vcosto_unitario[]" class="form-control" value="<?php echo $detalle['costo_unitario']; ?>" required>
                                                                        <input type="hidden" name="vmaterial_id[]" value="<?php echo $detalle['material_id']; ?>">
                                                                        
                                                                        <input type="hidden" name="vcantidad_material[]" value="<?php echo $detalle['cantidad']; ?>">
                                                                        
                                                    
                                                                    </td>
                                                                    <td>
                                                                    <input type="text" class="form-control" value="<?php echo number_format($detalle['subtotal'], 0, '.', ','); ?>" readonly>

                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                                                <td><input type="text" class="form-control" value="<?php echo $cabecera['total']; ?>" readonly></td>
                                                            </tr>
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
   document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('input[name="vcosto_unitario[]"]').addEventListener('keypress', function(e) {
        if (e.key === '.') {
            e.preventDefault();
        }
    });
});

</script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('input[name="vcosto_unitario[]"]').addEventListener('keypress', function(e) {
        if (e.key === ',') {
            e.preventDefault();
        }
    });
});

</script>

</body>

</html>
