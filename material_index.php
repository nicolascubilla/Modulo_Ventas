<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <title>LP3</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start();/*Reanudar sesion*/
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp';?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <!--CONTENEDOR PRINCIPAL-->
                <div class="content">
                    <!--FILA-->
                    <div class="row">
                        <div class=" col-xs-12 col-lg-12 col-md-12">
                            <?php if(!empty($_SESSION['mensaje'])) {?>
                            <div class="alert alert-success" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']=''; ?>
                            </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Materiales</h3>
                                    <div class="box-tools">
                                        <a href="articulos_print.php" 
                                           class="btn btn-default pull-right btn-sm" 
                                           data-title="Imprimir" rel="tooltip" target="_blank"> 
                                            <i class="fa fa-print"></i> </a>
                                        <a  href="material_add.php" 
                                            class="btn btn-primary btn-sm" data-title="Agregar Materias" rel="tooltip" >
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>  
                                </div><!--BOX HEADER-->
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-12 col-md-12">
                                            <!--BUSCADOR-->
                                            <form action="articulos_index.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-xs-12 col-md-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control" name="buscar"
                                                                       placeholder="Buscar..." autofocus=""/>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary btn-flat"
                                                                            data-title="buscar" data-placement="bottom"
                                                                            rel="tooltip"><span class="fa fa-search"></span></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php 
                                            $valor='';
                                            if(isset($_REQUEST['buscar'])){
                                                $valor=$_REQUEST['buscar'];
                                            }
                                            $material = consultas::get_datos("SELECT * FROM v_material ");

                                            if (!empty($material)) { ?>
                                            <div class="table-responsive">
                                                <table class=" table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>Nombre del Material</th>
                                                            <th>Descripción</th>
                                                            <th>Unidad de medida</th>
                                                            <th>Costo unitario</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                         foreach ($material as $mate) { ?>
                                                        <tr>
                                                            <td data-title='N°'> <?php echo $mate['material_id']?> </td>
                                                            <td data-title='Nombre del Material'> <?php echo $mate['nombre_material']?> </td>
                                                            <td data-title='Descripción'> <?php echo $mate['descripcion']?> </td>
                                                            <td data-title='Unidad de medida'> <?php echo $mate['unidad_medida']?> 
                                                            <td data-title="Costo unitario"><?php echo number_format($mate['costo_unitario'],0,",",".");?></td>
                                                            <td class="text-center">
    <a href="material_edit.php?vmaterial_id=<?php echo $mate['material_id']; ?>"
        class="btn btn-warning btn-sm" role='button'
        data-title='editar' rel="tooltip" data-placement='top'>
        <span class="glyphicon glyphicon-edit"></span>
    </a>
    <a onclick="borrar(<?php echo "'".$mate['material_id']."_".$mate['nombre_material']."_".$mate['descripcion']."'"; ?>)" 
        class="btn btn-danger btn-sm" role='button'
        data-title='borrar' rel="tooltip" data-placement='top'
        data-toggle="modal" data-target="#borrar">
        <span class="glyphicon glyphicon-trash"></span>
    </a>
</td>

                                                        </tr>
                                                         <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado Materiales...
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--PIE DE PAGINA-->
                   <!--FORMULARIO MODAL BORRAR-->
                  <div class="modal fade" id="borrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                          aria-label="close">x</button>
                                  <h4 class="modal-title"><strong>Atenci&oacute;n!!!</strong></h4>
                              </div>
                              <div class="modal-body">
                                  <div class="alert alert-warning" id="confirmacion"></div>
                              </div>
                              <div class="modal-footer">
                                  <a id="si" role="button" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span>Si</a>
                                      <button type="button" class="btn btn-default" data-dismiss="modal">
                                      <span class="glyphicon glyphicon-remove"></span>No</button>
                              </div>
                          </div>
                      </div>
                  </div>
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200,function(){
                $(this).alert('close');
            });
            function borrar(datos){
                var dat= datos.split("_");
                $("#si").attr('href','material_control.php?vmaterial_id='+dat[0]+'&nombre_material='+dat[1]+"&vnombre_material="+dat[2]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span>\n\
                   Desea borrar el material<i><strong> '+dat[1]+" "+dat[2]+'</strong></i>?');
            }
        </script>
        <script>
            $('.modal').on('showm.bs.modal', function() {
              $(this).find('input:text:visible:first').focus();
            });
        </script>
        
    </body>
</html>