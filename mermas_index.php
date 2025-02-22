<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orden de Producción</title>
    <link rel="stylesheetbb" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
       
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">

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
                            <table class="table table-bordered table-striped">
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
    <td><?php echo htmlspecialchars($merma['merma_id'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($merma['calidad_id'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($merma['fecha_merma'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($merma['cantidad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($merma['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($merma['motivo'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
    <button class="tailwind-btn 0 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
  detalles
</button>
<button onclick="window.print()" class="btn btn-warning" data-bs-toggle="tooltip" title="Imprimir esta página">
    <i class="bi bi-printer"></i> Imprimir
</button>






    </td>
</tr>

                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="alert alert-info">
                                                    <span class="glyphicon glyphicon-info-sign"></span>
                                                    No se encontraron registros de mermas...
                                                </div>
                                          
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">

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

    <!-- Archivos JS -->
    <?php require 'menu/js_lte.ctp'; ?>
    <!-- jQuery -->
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
        // Inicialización de DataTables
        $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

        // Lógica del modal
        $('#confirmModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var preCod = button.data('pre_cod'); // Extrae información de atributos de datos
            var modal = $(this);
            modal.find('input[name="vpre_cod"]').val(preCod); // Actualiza el valor del input oculto
        });
    </script>
    <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</body>
</html>
