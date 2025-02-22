<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <link rel="stylesheetbb" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet"  href="https://code.jquery.com/jquery-3.7.0.js">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/js/dataTables.semanticui.min.js">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/css/uikit.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.uikit.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
        <title>Presupuesto</title>
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
<!--Aqui va el contenido de Marca-->
<div class="content">
    <!--fila-->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <?php if (!empty($_SESSION ['mensaje'])){?>
            <div class="alert alert-danger" role="alert"id="mensaje">
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                <?php echo $_SESSION ['mensaje'];
                $_SESSION['mensaje']= '';
                ?>
                
            </div>  
           <?php  } ?>
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Presupuesto</h3>
                    <div class="box-tools">
                        <a href="presupuestcliente_add.php" class="btn btn-primary btn-md"
                           data-title="Agregar" rel="tooltip">
                            <i class="fa fa-plus"></i></a>
                           
                        
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <?php
                            $presupuesto = consultas::get_datos('select * from v_presupuesto_producc_cabecera order by pre_cod desc');
                            //var_dump($marcas);
                            if (!empty($presupuesto)){?>
                           
                            <table id="example" class="hover display cell-border" style="width:100%">
                                    <thead>
                                 
                                        <tr>
                                             <th>Cod</th>
                                            <th>fecha</th>
                                            <th>cliente</th>    
                                             <th>Estado</th>
                                             <th>Total</th>
                                             <th>Sucursal</th>
                                         
                                            <th class="text-center">Acciones</th>
                                                                                              
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP foreach ($presupuesto as $presupuesto) {?>
                                        <tr>
                                            <td data-title="N"><?php  echo $presupuesto['pre_cod'];?> </td>
                                             <td data-title="fecha"><?php  echo $presupuesto['fecha'];?> </td>
                                            <td data-title="cliente"><?php  echo $presupuesto['cliente'];?> </td>
                                              <td data-title="Estado"><?php echo ($presupuesto['estado']==="ANULADO")? "<span style='color:red';><strong>".$presupuesto['estado']."</strong></span>":$presupuesto['estado'];?></td>
                                              <td data-title="Total"><?php  echo $presupuesto['total'];?> </td>
                                              <td data-title="Sucursal"><?php  echo $presupuesto['suc_descri'];?> </td>
                                            <td date-title="Aciones" class="text-center">
                                                <a href="presupuestocli_edit.php?vpre_cod=<?php echo $presupuesto['pre_cod'];?>" class="btn btn-warning btn-md" data-title="editar"rel="tooltip">
                                                <i class="fa fa-edit"></i>
                                                </a>
                                               <a onclick="anular(<?php echo "'".$presupuesto['pre_cod']."_".$presupuesto['cliente']."'"?>)" class="btn btn-danger btn-md" 
                                                                   data-title="Anular" rel="tooltip" data-toggle = "modal" data-target="#anular">
                                                                    <i class="fa fa-remove"></i></a>
                                                                 <a href="presupuesto_det.php?vpre_cod=<?php echo $presupuesto['pre_cod'];?>" class="btn btn-primary btn-md" data-title="Detalles" rel="tooltip">
                                                                    <i class="fa fa-list"></i>                                                                    
                                                                </a>     
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                            
                                        <?php }?>
                                        
                                     
                                    </tbody>
                                </table>
                   
                           
                          <?php } else { ?>
                            <div class="alert alert-info flat">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                No se han registrado presupuesto...
                            </div>
                                
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- Inicio Modal Anular-->
            <div class="modal fade" id="anular" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title custom-align"> <strong>Atención!!!</strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="confirmacion">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <a id="si" role="buttom" class="btn btn-primary">
                                <i class="fa fa-check"></i> Si
                            </a>
                            <button type="reset" data-dismiss="modal" class="btn btn-default" 
                                    data-title="Cancelar" rel="tooltip">
                                <i class="fa fa-close"></i> No
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->    
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
          $("#mensaje").delay(4000).slideUp(200, function(){
          $(this).alert('close');    
          });
        </script>
         <script>
            function anular(datos){
                var dat = datos.split("_");
                $("#si").attr('href', 'presupuestocli_control.php?vpre_cod=' + dat[0] + '&accion=3');
                $("#confirmacion").html("<span class='glyphicon glyphicon-warning-sign'>\n\
                </span> Desea anular el presupuesto N° <strong>" 
                + dat[0] + "</strong> del cliente <strong>" + dat[1] + "</strong>?");
            }
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-qFOQ9YFAeGj1gDOuUD61g3D+tLDv3u1ECYWqT82WQoaWrOhAY+5mRMTTVsQdWutbA5FORCnkEPEgU0OF8IzGvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css"></script>
          <script src="https://cdn.datatables.net/1.13.7/css/dataTables.semanticui.min.css"></script>
          
           <script src="https://cdn.datatables.net/1.13.7/js/dataTables.uikit.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
   
  
   <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  
        <script>
           
          $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
        </script>
        <script>
            function anular(datos){
              
                console.log(datos);
                var dat = datos.split("_");
                $("#si").attr('href', 'presupuestocli_control.php?vpre_cod=' + dat[0] + '&accion=3');
                $("#confirmacion").html("<span class='glyphicon glyphicon-warning-sign'>\n\
                </span> Desea anular el pedido de venta N° <strong>" 
                + dat[0] + "</strong> del cliente <strong>" + dat[1] + "</strong>?");
            }
        </script>
       
    </body>
</html>

