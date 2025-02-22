<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="shortcut icon" href="/lp3/favicon.ico" type="image/x-icon">
    <?php 
    session_start(); 
    require 'menu/css_lte.ctp'; 
    ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        
        <div class="content-wrapper"> 
            <div class="content">
                <div class="box box-primary">
                    <!-- Mensaje de Error -->
                    <?php if (!empty($_SESSION['mensaje'])) : ?>
                        <div class="alert alert-danger" role="alert" id="mensaje">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php
                            echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8');
                            $_SESSION['mensaje'] = ''; // Limpiar mensaje después de mostrarlo
                            ?>
                        </div>  
                    <?php endif; ?>
                    
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            </svg>
                            Control de Calidad
                        </h4>
                        <div class="box-tools">
                            <a href="control_calidad_index.php" class="btn btn-primary btn-md" data-title="Volver" rel="tooltip"> 
                                <i class="fa fa-arrow-left"></i> 
                            </a>  
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>N° Orden</th>
                                        <th>Responsable</th>
                                        <th>Fecha Inspección</th>
                                        <th>Resultado</th>
                                        <th>Observación</th>
                                        <th>Aprobado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $ord_cod = isset($_GET['ord_cod']) ? intval($_GET['ord_cod']) : 0;
                                    $control = consultas::get_datos("SELECT * FROM v_control_calidad_detalle WHERE ord_cod = " . $ord_cod);

                                    if (!empty($control)) {
                                        foreach ($control as $con) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($con['calidad_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($con['ord_cod'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($con['responsable_inspeccion'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($con['fecha_inspeccion'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($con['resultado'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($con['observaciones'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo ($con['aprobado'] === "No") ? "<span style='color:red;'><strong>" . htmlspecialchars($con['aprobado'], ENT_QUOTES, 'UTF-8') . "</strong></span>" : htmlspecialchars($con['aprobado'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-info">
                                                    <span class="glyphicon glyphicon-info-sign"></span>
                                                    No se encontraron detalles del control de calidad...
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
