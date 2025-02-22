<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        
        <div class="content-wrapper">
            <div class="content">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="bi bi-file-earmark-ppt" style="font-size: 2rem;"></i>
                        <h4 class="box-title">Detalle Control De Producción</h4>
                        <div class="box-tools">
                            <a href="control_produccion_index.php" class="btn btn-primary btn-md" 
                               data-title="Volver" rel="tooltip"> 
                                <i class="fa fa-arrow-left"></i> 
                            </a>                                          
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php 
                            // Obtener el código de la orden desde el GET
                            $ord_cod = intval($_GET['vord_cod'] ?? 0);

                            if ($ord_cod) {
                                $controldetalle = consultas::get_datos("SELECT * FROM v_control_produccion_detalle WHERE ord_cod=".$ord_cod);

                                if (!empty($controldetalle)) {
                                    $ord_estado = $controldetalle[0]['ord_estado']; // Asumiendo que $controldetalle tiene al menos un registro
                                    ?>
                                    <div class="box-header">
                                        <i class="fa fa-list"></i>
                                        <h3 class="box-title">Detalles</h3>
                                    </div>
                                    <a href="control_produccion_print?vord_cod=<?php echo $ord_cod;?>" class="btn btn-default btn-md" data-title="Imprimir" rel="tooltip" target ="_blank"> <i class="fa fa-print"></i> </a> 
                                    <div class="table-responsive">
                                        <table class="table table-striped table-condensed table-hover dt-responsive">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>N° orden</th>
                                                    <th>Fecha Avance</th>
                                                    <th>Progreso</th>
                                                    <th>Tiempo Invertido</th>
                                                    <th>Comentarios</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($controldetalle as $det) { ?>                                                               
                                                <tr>
                                                    <td><?php echo $det['control_id']; ?></td>
                                                    <td><?php echo $det['ord_cod']; ?></td>
                                                    <td><?php echo $det['fecha_avance']; ?></td>
                                                    <td><?php echo $det['progreso']; ?></td>
                                                    <td><?php echo $det['tiempo_invertido']; ?></td>
                                                    <td><?php echo $det['comentarios']; ?></td>
                                                </tr>
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>   
                                       

                                    <?php if ($ord_estado !== 'Completado'): ?>
                                        <form action="control_produccion_control.php" method="post">
                                            <input type="hidden" name="accion" value="2">
                                            <input type="hidden" name="ord_cod" value="<?php echo $det['ord_cod']; ?>">
                                            <input type="hidden" name="fecha_avance" value="<?php echo date('Y-m-d'); ?>">
                                            <input type="hidden" name="progreso" value="100">
                                            <input type="hidden" name="tiempo_invertido" value="0">
                                            <input type="hidden" name="comentarios" value="Orden completada">
                                            <button type="submit" class="btn btn-primary">Completado</button>
                                        </form>
                                    <?php endif; ?>

                                <?php } else { ?>
                                  <div class="alert alert-info">
                                    <span class="glyphicon glyphicon-info-sign"></span>
                                    No se encontraron detalles del control de producción...
                                  </div>
                                <?php } 
                            } else { ?>
                                <div class="box-header">
                                    <h3 class="box-title">Código de control no proporcionado.</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
     <!-- Pie de Página -->
     <?php require 'menu/footer_lte.ctp'; ?>

<!-- JavaScript -->
<?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
