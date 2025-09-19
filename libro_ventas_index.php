<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Ventas</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    .badge-valido {
        background-color: #28a745;
        color: white;
    }

    .badge-anulado {
        background-color: #dc3545;
        color: white;
    }

    .table-actions {
        white-space: nowrap;
    }

    .bg-blue {
        background-color: #3c8dbc !important;
        color: white;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .text-right {
        text-align: right;
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Libro de Ventas</h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                    <li class="active">Libro de Ventas</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Filtros de Búsqueda</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <form id="formLibroVentas" method="post">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Fecha Desde *</label>
                                                <input type="date" name="fecha_desde" class="form-control" required
                                                    value="<?= date('Y-m-01') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Fecha Hasta *</label>
                                                <input type="date" name="fecha_hasta" class="form-control" required
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tipo Comprobante</label>
                                                <select name="tipo_comprobante" class="form-control">
                                                    <option value="">Todos</option>
                                                    <?php foreach($tipos_comprobante as $tipo): ?>
                                                    <option value="<?= $tipo['id_tipo'] ?>"><?= $tipo['descripcion'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-top: 25px;">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-search"></i> Buscar
                                                </button>
                                                <button type="button" id="btnExportarExcel" class="btn btn-primary">
                                                    <i class="fa fa-file-excel"></i> Exportar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Resultados</h3>
                                <div class="box-tools pull-right">
                                    <span id="totalRegistros" class="badge bg-blue">0 registros</span>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="tablaLibroVentas" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="bg-blue">
                                                <th>Fecha</th>
                                                <th>Tipo</th>
                                                <th>N° Comprobante</th>
                                                <th>Cliente</th>
                                                <th>RUC/CI</th>
                                                <th class="text-right">Gravada (₲)</th>
                                                <th class="text-right">IVA (₲)</th>
                                                <th class="text-right">Total (₲)</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Los datos se cargarán via AJAX -->
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gray">
                                                <th colspan="5" class="text-right">TOTALES:</th>
                                                <th class="text-right" id="totalGravada">0</th>
                                                <th class="text-right" id="totalIva">0</th>
                                                <th class="text-right" id="totalGeneral">0</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
    $(document).ready(function() {
        // Inicializar DataTable
        const table = $('#tablaLibroVentas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 8]
                },
                {
                    "className": "text-right",
                    "targets": [5, 6, 7]
                }
            ],
            "dom": '<"top"f>rt<"bottom"lip><"clear">',
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "libro_ventas_cargar.php",
                "type": "POST",
                "data": function(d) {
                    d.fecha_desde = $('input[name="fecha_desde"]').val();
                    d.fecha_hasta = $('input[name="fecha_hasta"]').val();
                    d.tipo_comprobante = $('select[name="tipo_comprobante"]').val();
                }
            },
            "drawCallback": function(settings) {
                // Actualizar totales
                const api = this.api();
                $('#totalGravada').html(api.column(5).data().sum().toFixed(2));
                $('#totalIva').html(api.column(6).data().sum().toFixed(2));
                $('#totalGeneral').html(api.column(7).data().sum().toFixed(2));
                $('#totalRegistros').text(api.page.info().recordsTotal + ' registros');
            }
        });

        // Extensión para sumar columnas
        $.fn.dataTable.Api.register('sum()', function() {
            return this.flatten().reduce(function(a, b) {
                if (typeof a === 'string') a = a.replace(/[^\d.-]/g, '');
                if (typeof b === 'string') b = b.replace(/[^\d.-]/g, '');
                return parseFloat(a || 0) + parseFloat(b || 0);
            }, 0);
        });

        // Buscar al enviar el formulario
        $('#formLibroVentas').on('submit', function(e) {
            e.preventDefault();
            table.ajax.reload();
        });

        // Exportar a Excel
        $('#btnExportarExcel').click(function() {
            const params = new URLSearchParams();
            params.append('fecha_desde', $('input[name="fecha_desde"]').val());
            params.append('fecha_hasta', $('input[name="fecha_hasta"]').val());
            params.append('tipo_comprobante', $('select[name="tipo_comprobante"]').val());

            window.open('libro_ventas_exportar.php?' + params.toString(), '_blank');
        });

        // Configurar fechas por defecto (primer día del mes hasta hoy)
        const hoy = new Date();
        const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);

        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        $('input[name="fecha_desde"]').val(formatDate(primerDiaMes));
        $('input[name="fecha_hasta"]').val(formatDate(hoy));
    });
    </script>
</body>

</html>