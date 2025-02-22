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
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i  class="fa fa-plus"></i>
                                    <h3 class="box-title">Agregar marca</h3>
                                    <div class="box-tools">
                                        <a href="marca_edit.php" class="btn btn-primary pull-right btn-sm" data-title="Volver" rel="tooltip"><i class="fa fa-arrow-left"></i>Volver</a>
                                            
                                    </div>
                                  </div>
                                
                                    <form action="marca_control.php"method="post" accept-charset="utf-8"class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vmar_cod" value="0">
                                      <div class="box-body">   
                                          <div class="form-group">
                                              <label class="col-lg-2 control-label">Descripcion</label>
                                              <div class="col-lg-8">
                                                  <input type="text" class="form-control" name=" vmar_descri" required="" minlength="3" autofocus="">
                                              </div>
                                          </div>
                                      </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary pull-right" data-title="precione para guardar" rel="tooltip">
                                                <i class=" fa fa-floppy-o"></i>  Registrar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
    </body>
</html>


