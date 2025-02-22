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
        <div class="content"> <!--FILA-->
                    <div class="row">
                    <div class=" col-xs-12 col-lg-12 col-md-12">
                    <?php if(!empty($_SESSION['mensaje'])) {?>
                        <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']=''; ?>
                            </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bus-front" viewBox="0 0 16 16">
  <path d="M5 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-6-1a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm1-6c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9c1.876 0 3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44.303 44.303 0 0 0 8 4Zm0-1c-1.837 0-3.353.107-4.448.22a.5.5 0 1 1-.104-.994A44.304 44.304 0 0 1 8 2c1.876 0 3.426.109 4.552.226a.5.5 0 1 1-.104.994A43.306 43.306 0 0 0 8 3Z"/>
  <path d="M15 8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1V2.64c0-1.188-.845-2.232-2.064-2.372A43.61 43.61 0 0 0 8 0C5.9 0 4.208.136 3.064.268 1.845.408 1 1.452 1 2.64V4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v3.5c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2V8ZM8 1c2.056 0 3.71.134 4.822.261.676.078 1.178.66 1.178 1.379v8.86a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 11.5V2.64c0-.72.502-1.301 1.178-1.379A42.611 42.611 0 0 1 8 1Z"/>
</svg>
                                <i class="bi bi-bus-front"></i>
                                    <h3 class="box-title">Importador</h3>
                                    <div class="box-tools">
                                    <a href="importador_add.php" class="btn btn-primary btn-md"
                                    data-title="Agregar" rel="tooltip">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    <a href="importador_print.php" class="btn btn-default btn-md"
                                    data-title="Imprimir" rel="tooltip">
                                    <i class="fa fa-print"></i></a>
                                    </div>
                                 </div>
                                 <div class="box-body">
                                 <div class="row">
                                 <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                 <?php
                                  $importador = consultas::get_datos(' select * from importador');
                                   //var_dump($importador);
                                   if (!empty($importador)){?>

                          <table class="table table-bordered table-striped table-condensed table-hover dt-responsive">
                                    <thead>
                                        <tr>

                                            <th>CODIGO</th>
                                            <th>Nombre</th>
                                            <th>Direccion</th>
                                            <th>vehiculo</th>
                                            <th class="text-center">Acciones</th>
                                            </tr>
                                            </thead>
                                    <tbody>
                                    <?PHP foreach ($importador as $importador) {?>
                                        <tr>
                                            <td data-title="Codigo"><?php  echo $importador['impor_cod'];?> </td>
                                            <td data-title="Nombre"><?php  echo $importador['impor_nomb'];?> </td>
                                            <td data-title="Direccion"><?php  echo $importador['impor_direc'];?> </td>
                                            <td data-title="Vehiculo"><?php  echo $importador['impor_vehiculo'];?> </td>
                                             <td date-title="Aciones" class="text-center">
                                             <a href="marca_edit.php?vimpor_cod=<?php echo $importador['impor_cod'];?>" class="btn btn-warning btn-md" data-title="Editar"rel="tooltip">
                                             <i class="fa fa-edit"></i>
                                             </a>
                                             <a href="marca_del.php?vmar_cod=<?php echo $importador['impor_cod'];?>" class="btn btn-danger btn-md" data-title="Borrar"rel="tooltip">
                                             <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>


                                                                   <?php }?>
                                                                   </tbody>
                                </table>
                                                                   
                                                                   <?php }?>







                                    

                                    

                                    
                                    
                   