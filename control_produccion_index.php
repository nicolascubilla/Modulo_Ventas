<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
     <!-- CSS de DataTables -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Cabecera Principal -->
    <?php require 'menu/header_lte.ctp'; ?>

    <!-- Menú Principal -->
    <?php require 'menu/toolbar_lte.ctp'; ?>

    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">

                    <!-- Mensaje de Error -->
                    <?php if (!empty($_SESSION['mensaje'])) : ?>
                        <div class="alert alert-danger" role="alert" id="mensaje">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php
                            echo $_SESSION['mensaje'];
                            $_SESSION['mensaje'] = '';
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Caja de Cargos -->
                    <div class="box box-primary">
                        <div class="box-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                        </svg>     
                            <h3 class="box-title">Gestion Control Produccion</h3>
                            <div class="box-tools">
                            <a href="control_produccion_add.php" class="btn btn-primary btn-sm pull-right" data-title="Agregar" rel="tooltip" data-placement="top">
                                        <i class="fa fa-plus"></i> Agregar Control
                                    </a>
                            </div>
                        </div>
    
                            <!-- Tabla de Cargos -->
                            <?php
                            $contolpro = consultas::get_datos("SELECT * FROM v_control_produccion_cabe");
                            if (!empty($contolpro)) :
                            ?>
                              <table id="controlTable" class="table table-striped table-condensed table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th>N° Orden</th>
                                        <th>N° Pedido</th>
                                        <th>Fecha Avance</th>
                                        <th>Estado</th>
                                        <th>Progreso</th>
                                        <th>Tiempo Invertido</th>
                                        <th>Comentarios</th>
                                        <th>Sucursal</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contolpro as $contol) : ?>
                                        <tr>
                                            <td><?php echo $contol['control_id']; ?></td>
                                            <td><?php echo $contol['pedido_id']; ?></td>
                                            <td><?php echo $contol['fecha_avance']; ?></td>
                                            <td><?php echo $contol['estado']; ?></td>
                                            <td><?php echo $contol['progreso']; ?></td>
                                            <td><?php echo $contol['tiempo_invertido']; ?></td>
                                            <td><?php echo $contol['comentarios']; ?></td>
                                            <td><?php echo $contol['suc_descri']; ?></td>
                                            <td><?php echo $contol['usu_nick']; ?></td>
                                            <td>
    <a href="control_produccion_det.php?vord_cod=<?php echo $contol['control_id'];?>" class="btn btn-primary btn-md" data-title="Detalles" rel="tooltip">
        <i class="fa fa-list"></i>                                                                    
    </a>     
</td>

                                    </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <div class="alert alert-danger">
                                    <span class="glyphicon glyphicon-info-sign"></span>
                                    Aún no se registraron Producciones...
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
           
            </div>
       
        <?php require 'menu/footer_lte.ctp'; ?>
      

    <?php require 'menu/js_lte.ctp'; ?>
    
      <!-- DataTables JS -->
      <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#controlTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]
           
            }); 
        });
    </script>

    <script>
             // Ocultar mensaje después de 4 segundos
             $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
    
        
    </script>


</body>
</html>
