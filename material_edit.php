<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
    <title>LP3 - Editar Material</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
    session_start(); /* Reanudar sesión */
    require 'menu/css_lte.ctp'; /* ARCHIVOS CSS */
    ?>

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; /* CABECERA PRINCIPAL */ ?>
        <?php require 'menu/toolbar_lte.ctp'; /* MENU PRINCIPAL */ ?>
        <div class="content-wrapper">
            <!-- CONTENEDOR PRINCIPAL -->
            <div class="content">
                <!-- FILA -->
                <div class="row">
                    <div class=" col-xs-12 col-lg-12 col-md-12">
                        <?php if(!empty($_SESSION['mensaje'])) { ?>
                        <div class="alert alert-info" role="alert" id="mensaje">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php 
                            echo $_SESSION['mensaje'];
                            $_SESSION['mensaje'] = ''; 
                            ?>
                        </div>
                        <?php } ?>
                        <div class="box box-primary">
                            <div class="box-header">
                                <i class="ion ion-edit"></i>
                                <h3 class="box-title">Editar Material</h3>
                                <div class="box-tools">
                                    <a href="material_index.php" class="btn btn-primary pull-right btn-sm">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>  
                            </div><!-- BOX HEADER -->
                            
                            <!-- Obtener el ID del material desde la URL -->
                            <?php
                            $vmaterial_id = isset($_GET['vmaterial_id']) ? $_GET['vmaterial_id'] : null;

                            if ($vmaterial_id) {
                                $material = consultas::get_datos("SELECT * FROM material WHERE material_id = $vmaterial_id");
                            } else {
                                die('Error: No se proporcionó un ID de material.');
                            }
                            ?>

                            <form action="material_control.php" method="post" accept-charset='UTF-8' class="form-horizontal">
                                <input type="hidden" name="accion" value="2">
                                <input type="hidden" name="vmaterial_id" value="<?php echo $vmaterial_id; ?>">
                                
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Nombre del Material</label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <input type="text" class="form-control" name="vnombre_material" 
                                                   value="<?php echo $material[0]['nombre_material']; ?>" required minlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Descripción</label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <textarea class="form-control" name="vdescripcion" rows="3"><?php echo $material[0]['descripcion']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Unidad de Medida</label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <input type="text" class="form-control" name="vunidad_medida" 
                                                   value="<?php echo $material[0]['unidad_medida']; ?>" required minlength="2"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Costo Unitario</label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <input type="number" class="form-control" name="vcosto_unitario" 
                                                   value="<?php echo $material[0]['costo_unitario']; ?>" required min="0" step="0.01"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; /* ARCHIVOS JS */ ?>
        <script>
            $("#mensaje").delay(4000).slideUp(200,function(){
                $(this).alert('close');
            });
        </script>
    </div>
</body>
</html>
