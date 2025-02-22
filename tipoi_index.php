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
                            <div class="alert alert-info" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']=''; ?>
                            </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Tipos de impuesto</h3>
                                    <div class="box-tools">
                                        <a href="tipoi_print.php" 
                                           class="btn btn-default pull-right btn-sm" 
                                           data-title="Imprimir" rel="tooltip" target="_blank"> 
                                            <i class="fa fa-print"></i> </a>
                                        <a  class="btn btn-primary pull-right btn-sm" role="button"
                                           data-toggle="modal" data-target="#registrar">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>  
                                </div><!--BOX HEADER-->
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-12 col-md-12">
                                            <?php 
                                            //CONSULTA A LA TABLA MARCA
                                            $tipos= consultas::get_datos("select*from tipo_impuesto order by tipo_cod");
                                            if (!empty($tipos)) { ?>
                                            <div class="table-responsive">
                                                <table class=" table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>Descripcion</th>
                                                            <th>Porcentaje</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                         foreach ($tipos as $tipo) { ?>
                                                        <tr>
                                                            <td data-title='descripcion'> <?php echo $tipo['tipo_descri']?> </td>
                                                            <td data-title='porcentaje'> <?php echo $tipo['tipo_porcen']?> </td>
                                                            <td data-title='acciones'class="text-center">
                                                                <a onclick="editar(<?php echo"'".$tipo['tipo_cod']."_".$tipo['tipo_descri']."_".$tipo['tipo_porcen']."'"; ?>)" 
                                                                   class="btn btn-warning btn-sm" role='button'
                                                                   data-title='editar' rel="tooltip" data-placement='top'
                                                                   data-toggle="modal" data-target="#editar">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>
                                                                <a onclick="borrar(<?php echo"'".$tipo['tipo_cod']."_".$tipo['tipo_descri']."_".$tipo['tipo_porcen']."'"; ?>)" 
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
                                                No se han registrado cargos...
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
                  <!--FORMULARIO MODAL AGREGAR-->
                  <div class="modal fade" id="registrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                          aria-label="close">x</button>
                                  <h4 class="modal-title"><strong>Registrar tipos de impuesto</strong></h4>
                              </div>
                              <form action="tipoi_control.php" method="post" accept-charset="UTF-8"
                                  class="form-horizontal">
                                  <input type="hidden" value="1" name="accion"/>
                                  <input type="hidden" value="0" name="vtipo_cod"/>
                                  <div class="box-body">
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Descripcion</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="vtipo_descri" required="">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Porcentaje</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" name="vtipo_porcen" required="">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="box-footer">
                                      <button type="reset" data-dismiss="modal" class="btn btn-warning">Cerrar</button>
                                      <button type="submit" class="btn btn-success pull-right">Registrar</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                   <!--FORMULARIO MODAL EDITAR-->
                  <div class="modal fade" id="editar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" 
                                          aria-label="close">x</button>
                                  <h4 class="modal-title"><strong>Editar cargos</strong></h4>
                              </div>
                              <form action="tipoi_control.php" method="post" accept-charset="UTF-8"
                                  class="form-horizontal">
                                  <input type="hidden" value="2" name="accion"/>
                                  <input id="cod" type="hidden" value="0" name="vtipo_cod"/>
                                  <div class="box-body">
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Descripcion</label>
                                          <div class="col-sm-10">
                                              <input id="descri" type="text" class="form-control" name="vtipo_descri" required="">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-sm-2 control-label">Porcentaje</label>
                                          <div class="col-sm-10">
                                              <input id="porcen" type="text" class="form-control" name="vtipo_porcen" required="">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="box-footer">
                                      <button type="reset" data-dismiss="modal" class="btn btn-warning">Cerrar</button>
                                      <button type="submit" class="btn btn-success pull-right">Actualizar</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
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
            
            function editar(datos){
                var dat= datos.split("_");
                $('#cod').val(dat[0]);
                $('#descri').val(dat[1]);
                $('#porcen').val(dat[2]);
            }
            function borrar(datos){
                var dat= datos.split("_");
                $("#si").attr('href','tipoi_control.php?vtipo_cod='+dat[0]+'&vtipo_descri='+dat[1]+'&vtipo_porcen='+dat[2]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span>\n\
                   Desea borrar el tipo de impuesto<i><strong> '+dat[1]+'</strong></i>?');
            }
        </script>
        <script>
            $('.modal').on('showm.bs.modal', function() {
              $(this).find('input:text:visible:first').focus();
            });
        </script>
        
    </body>
</html>