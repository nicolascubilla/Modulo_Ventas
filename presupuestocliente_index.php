<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
    
        <title>Presupuesto</title>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start();/*Reanudar sesion*/
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->
        <style> .estado-finalizado {
            background-color: #28a745; /* Verde */
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
        }

        .estado-pendiente {
            background-color: #ffc107; /* Amarillo */
            color: black;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
        }

        .estado-anulado {
            background-color: #dc3545; /* Rojo */
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
        }

        </style>
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
                            <div class="alert alert-success" role="alert"id="mensaje">
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
                                            <i class="fa fa-plus"></i>Agregar
                                        </a>
                                        <?php
                                            if( !empty($_GET['estado']) && $_GET['estado']){
                                        ?>
                                        <a href="" class="btn btn-success" data-title="Exportar">
                                            <i class="fa fa-file-excel-o"> Excel</i>
                                        </a>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <form method="get" action="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="estado">Estado</label>
                                                <select class="form-control" name="estado" id="estado">
                                                    <option value="" <?php if (isset($_GET['estado']) && $_GET['estado'] == '') echo 'selected'; ?>>Todos</option>
                                                    <option value="NUEVO" <?php if (isset($_GET['estado']) && $_GET['estado'] == 'NUEVO') echo 'selected'; ?>>Nuevo</option>
                                                    <option value="EN PROCESO" <?php if (isset($_GET['estado']) && $_GET['estado'] == 'EN PROCESO') echo 'selected'; ?>>En Proceso</option>
                                                    <option value="FINALIZADO" <?php if (isset($_GET['estado']) && $_GET['estado'] == 'FINALIZADO') echo 'selected'; ?>>Finalizado</option>
                                                    <option value="PENDIENTE" <?php if (isset($_GET['estado']) && $_GET['estado'] == 'PENDIENTE') echo 'selected'; ?>>Pendiente</option>
                                                    <option value="ANULADO" <?php if (isset($_GET['estado']) && $_GET['estado'] == 'ANULADO') echo 'selected'; ?>>Anulado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="margin-top: 22px;">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                                <a href="presupuestocliente_index.php" class="btn btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                                <?php
                                                $condicion = "";
                                                if (!empty($_GET['estado'])) {
                                                    $estado = $_GET['estado'];
                                                    $condicion = "WHERE estado = '$estado'";
                                                }
                                                $presupuesto = consultas::get_datos("SELECT * FROM v_presupuesto_producc_cabecera $condicion ORDER BY pre_cod DESC");
                                                //var_dump($marcas);
                                                if (!empty($presupuesto)){?>
                                            
                                                <table id="example" class="table table-bordered table-hover">
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
                    <?php foreach ($presupuesto as $presupuesto) { ?>
                    <tr>
                        <td data-title="N"><?php echo $presupuesto['pre_cod']; ?></td>
                        <td data-title="Fecha"><?php echo $presupuesto['fecha']; ?></td>
                        <td data-title="Cliente"><?php echo $presupuesto['cliente']; ?></td>
                        <td data-title="Estado" class="text-center">
                            <span class="estado 
                                <?php 
                                    echo $presupuesto['estado'] == 'FINALIZADO' ? 'estado-finalizado' : 
                                        ($presupuesto['estado'] == 'PENDIENTE' ? 'estado-pendiente' : 
                                        ($presupuesto['estado'] == 'ANULADO' ? 'estado-anulado' : ''));
                                ?>">
                                <?php echo $presupuesto['estado']; ?>
                            </span>
                        </td>
                        <td data-title="Total"><?php echo $presupuesto['total']; ?></td>
                        <td data-title="Sucursal"><?php echo $presupuesto['suc_descri']; ?></td>
                                                            <td date-title="Aciones" class="text-center">

                                                            <?php if ($presupuesto['estado'] !== 'ANULADO' && $presupuesto['estado'] !== 'FINALIZADO') { ?> 
                                                                <a href="presupuestocli_edit.php?vpre_cod=<?php echo $presupuesto['pre_cod'];?>" class="btn btn-warning btn-md" data-title="editar"rel="tooltip">
                                                                <i class="fa fa-edit"></i>
                                                                </a>
                                                            <a onclick="anular(<?php echo "'".$presupuesto['pre_cod']."_".$presupuesto['cliente']."'"?>)" class="btn btn-danger btn-md" 
                                                                                data-title="Anular" rel="tooltip" data-toggle = "modal" data-target="#anular">
                                                                                    <i class="fa fa-remove"></i></a>
                                                                                    <?php } ?> 

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
       <!-- DataTables JS -->
       <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
                  <script>
           
           $(document).ready(function () {
                $('#example').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                    }
                })
            });
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

