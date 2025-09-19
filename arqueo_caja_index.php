<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arqueos de Caja</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <style>
    .card-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .badge-estado {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .badge-abierta {
        background-color: #28a745;
        color: white;
    }

    .badge-cerrada {
        background-color: #6c757d;
        color: white;
    }

    .table-actions {
        white-space: nowrap;
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <!-- Encabezado -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h3 class="mb-0">Arqueos de Caja</h3>
                            <p class="text-muted">Listado de arqueos registrados en el sistema</p>
                        </div>
                        <div class="col-md-6 text-right">

                            <a href="generar_arqueo_caja.php" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Nuevo Arqueo
                            </a>

                        </div>
                    </div>

                    <!-- Card Principal -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-actions">
                                <h3 class="card-title">Listado de Arqueos</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablaArqueos" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Caja</th>
                                            <th>Efectivo</th>
                                            <th>Tarjetas</th>
                                            <th>Cheques</th>
                                            <th>Total</th>
                                            <th>Usuario</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Ejemplo de datos estáticos - En producción vendrían de la BD -->
                                        <tr>
                                            <td>ARQ-2025-001</td>
                                            <td>07/07/2025 19:45</td>
                                            <td>CAJA-1</td>
                                            <td class="text-right">₲ 1,250,000</td>
                                            <td class="text-right">₲ 450,000</td>
                                            <td class="text-right">₲ 300,000</td>
                                            <td class="text-right">₲ 2,000,000</td>
                                            <td>nico</td>
                                            <td><span class="badge badge-estado badge-cerrada">CERRADA</span></td>
                                            <td class="table-actions">
                                                <a href="arqueo_ver.php?id=1" class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="arqueo_imprimir.php?id=1" class="btn btn-secondary btn-sm"
                                                    title="Imprimir">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ARQ-2025-002</td>
                                            <td>08/07/2025 08:30</td>
                                            <td>CAJA-1</td>
                                            <td class="text-right">₲ 800,000</td>
                                            <td class="text-right">₲ 320,000</td>
                                            <td class="text-right">₲ 150,000</td>
                                            <td class="text-right">₲ 1,270,000</td>
                                            <td>nico</td>
                                            <td><span class="badge badge-estado badge-abierta">ABIERTA</span></td>
                                            <td class="table-actions">
                                                <a href="arqueo_ver.php?id=2" class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="arqueo_editar.php?id=2" class="btn btn-warning btn-sm"
                                                    title="Editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="arqueo_imprimir.php?id=2" class="btn btn-secondary btn-sm"
                                                    title="Imprimir">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Totales:</th>
                                            <th class="text-right">₲ 2,050,000</th>
                                            <th class="text-right">₲ 770,000</th>
                                            <th class="text-right">₲ 450,000</th>
                                            <th class="text-right">₲ 3,270,000</th>
                                            <th colspan="3"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            Mostrando <strong>2</strong> de <strong>2</strong> registros
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
        <?php require 'menu/js_lte.ctp'; ?>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

        <script>
        $(document).ready(function() {
            $('#tablaArqueos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },
                "order": [
                    [1, "desc"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [9]
                    },
                    {
                        "className": "text-center",
                        "targets": [0, 8, 9]
                    }
                ],
                "initComplete": function() {
                    $('.dataTables_filter input').addClass('form-control').css('width', '300px');
                    $('.dataTables_length select').addClass('form-control');
                }
            });
        });
        </script>
    </div>
</body>

</html>