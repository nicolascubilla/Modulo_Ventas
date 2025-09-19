<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="shortcut icon" type="image/x-icon" href="/taller/favicon.ico">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
      

    <?php 
    session_start(); // Reanudar sesión
    require 'menu/css_lte.ctp'; ?>
    <style>
        .tailwind-btn {
    background-color: #3b82f6 !important;
    color: white !important;
    font-weight: bold;
    padding: 8px 16px;
    border-radius: 6px;
}

    </style>
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16">
                                <path d="M10 1.5v1h2a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h2v-1H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2h-2z"/>
                                <path d="M7.5 0a.5.5 0 0 0-.5.5v.5h-2v1h6v-1h-2v-.5a.5.5 0 0 0-.5-.5z"/>
                                <path d="M6 10.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5zm-1-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                            Mermas
                        </h4>
                        <div class="box-tools">
                            <a href="control_calidad_index.php" class="btn btn-primary btn-md" data-title="Volver" rel="tooltip"> 
                                <i class="fa fa-arrow-left"></i> 
                            </a>  
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="mermas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                       
                                        <th>ID Calidad</th>
                                        <th>Fecha Merma</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Motivo</th>
                                        <th>Acciones</th>
                                       
                                       
                                    </tr>
                                </thead>
                                <tbody>
    <?php 
    $mermas = consultas::get_datos("SELECT * FROM v_mermas");

    if (!empty($mermas)) {
        foreach ($mermas as $merma) { ?>
            <tr>
                <td><?= htmlspecialchars($merma['merma_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($merma['calidad_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($merma['fecha_merma'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($merma['cantidad'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($merma['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($merma['motivo'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="text-center">
                    <a href="mermas_print.php?merma_id=<?= $merma['merma_id']; ?>" 
                        class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="_blank">
                        <i class="glyphicon glyphicon-print"></i> Imprimir
                    </a>
                    <a href="merma_detalles.php?merma_id=<?= $merma['merma_id']; ?>" 
                        class="btn btn-info btn-sm" data-title="Detalles" rel="tooltip">
                        <i class="fa fa-info-circle"></i> Detalles
                    </a>
                </td>
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="7" class="text-center">
                <div class="alert alert-info">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    No se encontraron registros de mermas...
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

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Asignar equipo de trabajo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="ordenproduccion_control.php" method="post" accept-charset="UTF-8" class="form-horizontal">
                        <input type="hidden" name="vpre_cod" value=""/>
                        <input type="hidden" name="accion" value="1"/>
                        <div class="form-group">
                            <label class="control-label col-lg-2 col-md-2 col-sm-2" for="selectEquipo">Seleccionar equipo:</label>
                            <div class="input-group">
                                <?php $equipos = consultas::get_datos("select * from equipo_trabajo"); ?>
                                <select class="form-select array-select form-control select2" id="selectEquipo" name="vequipo_id" required style="width: 80%;">
                                    <option value="">Seleccione un equipo</option>
                                    <?php foreach($equipos as $equipo) { ?>
                                        <option value="<?php echo $equipo['equipo_id']; ?>"><?php echo $equipo['nombre_equipo']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btn-confirmar-orden">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
       
        
       
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
   
    <!-- jQuery -->
   
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<!-- DataTables Buttons (solo si usas 'copy', 'csv', 'excel', 'pdf', 'print') -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Inicialización segura -->
<script>
    $(function () {
        // Inicializa DataTables
        $('#mermas').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });

        // Modal dinámico: asigna valor al input oculto
        $('#confirmModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var preCod = button.data('pre_cod');
            $(this).find('input[name="vpre_cod"]').val(preCod);
        });

        // Tooltips (versión para Bootstrap 3)
        $('[rel="tooltip"]').tooltip();
    });
</script>


</body>
</html>
