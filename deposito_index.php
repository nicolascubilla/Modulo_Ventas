<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <title>LP3</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-danger" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php echo $_SESSION['mensaje'];
                                    $_SESSION['mensaje'] = '';
                                    ?>
                                </div>
                            <?php } ?>                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-clipboard"></i>
                                    <h3 class="box-title">Depósitos</h3>
                                    <div class="box-tools">
                                        <a href="deposito_add.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="deposito_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="print">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form action="deposito_index.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" name="buscar" class="form-control" autofocus=""
                                                                       placeholder="Ingrese descripción a buscar"/>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary" 
                                                                            data-title="Presione para buscar" rel="tooltip">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </span>                                                                
                                                            </div>                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php $depositos = consultas::get_datos("select * from v_deposito where dep_descri ilike '%".(isset($_REQUEST['buscar']) ? $_REQUEST['buscar']:"")."%'order by dep_cod");
                                        if (!empty($depositos)) { ?>
                                        <table class="table table-striped table-condensed table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th> 
                                                    <th>Sucursal</th> 
                                                    <th class="text-center">Acciones</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($depositos as $deposito) { ?>
                                                    <tr>
                                                        <td data-title='Descripción'><?php echo $deposito['dep_descri']; ?></td>
                                                        <td data-title='Sucursal'><?php echo $deposito['suc_descri']; ?></td>
                                                        <td data-title='Acciones' class="text-center">
                                                            <a href="deposito_edit.php?vdep_cod=<?php echo $deposito['dep_cod']; ?>" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a onclick="borrar(<?php echo "'".$deposito['dep_cod']."_".$deposito['dep_descri']."_".$deposito['id_sucursal']."'";?>)" class="btn btn-danger btn-sm" 
                                                                accesskey=""data-title="Borrar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#borrar">
                                                                <i class="glyphicon glyphicon-trash"></i>
                                                            </a>                                                    
                                                        </td>
                                                    </tr>                                                 
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php } else { ?>
                                        <div class="alert alert-info">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                            Aún no se registraron depósitos...
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
            <!--FORMULARIO MODAL BORRAR-->
                <div class="modal" id="borrar" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                <h4 class="modal-title custom_align">Atención!!!</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" id="confirmacion"></div>
                            </div>
                            <div class="modal-footer">
                                <a id="si" role="button" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok-sign"></span> SI
                                </a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remove"></span> NO
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <!--FIN FORMULARIO MODAL BORRAR-->                    
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
            $(".modal").on("shown.bs.modal", function () {
                $(this).find("input:text:visible:first").focus();
            });
        </script>  
        <script>
            function borrar(datos){
                var dat = datos.split("_");
                $("#si").attr('href','deposito_control.php?vdep_cod='+dat[0]+'&vdep_descri='+dat[1]+'&vsuc_descri='+dat[2]+'&accion=3');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                Desea borrar el deposito <i><strong>'+dat[1]+'</strong></i>?');
            }
        </script>
    </body>
</html>