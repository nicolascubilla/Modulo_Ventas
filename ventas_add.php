<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <?php require 'menu/css_lte.ctp'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
    .form-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
    }

    .section-title {
        color: #3c8dbc;
        border-bottom: 2px solid #f4f4f4;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .table-detalle th {
        background-color: #f8f9fa;
    }

    .btn-eliminar-item {
        padding: 5px 10px;
    }

    .totales-venta {
        font-weight: bold;
        background-color: #f8f9fa;
    }

    .select2-container--default .select2-selection--single {
        height: 34px;
        padding: 3px;
    }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        <?php


$clientes = consultas::get_datos("SELECT cli_cod, cli_nombre FROM clientes");
$articulos = consultas::get_datos("SELECT a.art_cod, a.art_descri, a.art_preciov, 
       t.tipo_porcen as iva_porcentaje
FROM articulo a
JOIN tipo_impuesto t ON a.tipo_cod = t.tipo_cod
ORDER BY a.art_descri");
?>
        <input type="hidden" class="iva-porcentaje" value="${iva}">


        <div class="content-wrapper">
            <section class="content-header">
                <h1>Registrar Nueva Venta</h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                    <li><a href="ventas_listado.php">Ventas</a></li>
                    <li class="active">Nueva Venta</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos de la Venta</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <form id="ventaForm" action="venta_guardar.php" method="post">
                                <input type="hidden" name="accion" value="1">
                                <div class="box-body">
                                    <!-- Campos ocultos necesarios -->
                                    <input type="hidden" name="vemp_cod" value="<?= $_SESSION['emp_cod'] ?>">
                                    <input type="hidden" name="vid_sucursal" value="<?= $_SESSION['id_sucursal'] ?>">
                                    <input type="hidden" name="vusu_cod" value="<?= $_SESSION['usu_cod'] ?>">
                                    <input type="hidden" name="vid_estado" value="1">

                                    <!-- Cabecera de Venta -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cliente *</label>
                                                <select name="vcli_cod" id="cli_cod" class="form-control select2"
                                                    required>
                                                    <option value="">Seleccione cliente</option>
                                                    <?php foreach($clientes as $c): ?>
                                                    <option value="<?= $c['cli_cod'] ?>"><?= $c['cli_nombre'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Control de Producción *</label>
                                                <select name="vcontrol_id" id="control_id" class="form-control select2"
                                                    required>
                                                    <option value="">Seleccione control</option>
                                                    <?php 
                                                    $controles = consultas::get_datos("
                                                        SELECT  co.control_id, p.pre_cod, c.cli_cod,  c.cli_nombre
                                                        FROM presupuesto_produccion p
                                                        JOIN clientes c ON c.cli_cod = p.cli_cod
                                                        JOIN orden_produccion o ON p.pre_cod = o.pre_cod 
                                                        JOIN pedido_materia_prima pe ON o.ord_cod = pe.ord_cod
                                                        JOIN control_produccion co ON pe.pedido_id = co.pedido_id
                                                        JOIN control_calidad coc ON co.control_id = coc.control_id 
                                                        WHERE co.id_estado = 3 AND coc.aprobado = 't'
                                                    ");
                                                    foreach($controles as $ctrl): ?>
                                                    <option value="<?= $ctrl['control_id'] ?>"
                                                        data-cli="<?= $ctrl['cli_cod'] ?>">
                                                        Control #<?= $ctrl['control_id'] ?> - Cliente:
                                                        <?= $ctrl['cli_nombre'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha *</label>
                                                <input type="datetime-local" name="vven_fecha" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="id_tipo_comprobante" class="control-label">Tipo Comprobante
                                                *</label>
                                            <select class="form-control select2" name="vid_tipo_comprobante"
                                                id="id_tipo_comprobante" required>
                                                <option value="">Seleccione un tipo comprobante</option>
                                                <?php 
                                                $tipos = consultas::get_datos("select * from tipos_comprobante where activo = 't'");
                                                foreach ($tipos as $tipo) { ?>
                                                <option value="<?= $tipo['id_tipo'] ?>"
                                                    data-letra="<?= $tipo['letra'] ?>">
                                                    <?= $tipo['descripcion'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>N° Comprobante</label>
                                                <input type="text" name="vnro_comprobante" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha Vencimiento *</label>
                                                <input type="datetime-local" name="vven_fecha_vencimiento"
                                                    class="form-control" required>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detalle de Venta -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="detalleVenta"
                                                    class="table table-bordered table-hover table-detalle">
                                                    <thead>
                                                        <tr>
                                                            <th width="40%">Artículo *</th>
                                                            <th width="10%">Cantidad *</th>
                                                            <th width="15%">P. Unitario *</th>
                                                            <th width="15%">Descuento %</th>
                                                            <th width="15%">Subtotal</th>
                                                            <th width="5%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Filas dinámicas se agregarán aquí -->
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="totales-venta">
                                                            <td colspan="4" class="text-right">
                                                                <strong>SUBTOTAL:</strong>
                                                            </td>
                                                            <td><input type="text" name="vsubtotal"
                                                                    class="form-control text-right" readonly></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="totales-venta">
                                                            <td colspan="4" class="text-right">
                                                                <strong>DESCUENTO:</strong>
                                                            </td>
                                                            <td><input type="text" name="vdescuento"
                                                                    class="form-control text-right" value="0.00"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="totales-venta">
                                                            <td colspan="4" class="text-right"><strong>IVA 5%:</strong>
                                                            </td>
                                                            <td><input type="text" name="iva5"
                                                                    class="form-control text-right" readonly></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="totales-venta">
                                                            <td colspan="4" class="text-right"><strong>IVA 10%:</strong>
                                                            </td>
                                                            <td><input type="text" name="iva10"
                                                                    class="form-control text-right" readonly></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="totales-venta">
                                                            <td colspan="4" class="text-right"><strong>EXENTO:</strong>
                                                            </td>
                                                            <td><input type="text" name="exento"
                                                                    class="form-control text-right" readonly></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="totales-venta">
                                                            <td colspan="4" class="text-right"><strong>TOTAL:</strong>
                                                            </td>
                                                            <td><input type="text" name="total"
                                                                    class="form-control text-right" readonly></td>
                                                            <td></td>

                                                            <!-- Corregir el cierre erróneo -->
                                                            <!--<input type="hidden" name="iva5" value="0">
                                                            <input type="hidden" name="iva10" value="0">
                                                            <input type="hidden" name="exento" value="0">-->

                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Condiciones de Pago -->
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-4">
                                            <label for="id_condicion_pago" class="control-label">Condición de Pago
                                                *</label>
                                            <select class="form-control select2" name="vid_condicion_pago"
                                                id="id_condicion_pago" required>
                                                <option value="">Seleccione condición de pago</option>
                                                <?php 
                                                $condiciones = consultas::get_datos("select * from condiciones_pago where activo = 't'");
                                                foreach ($condiciones as $condicion) { ?>
                                                <option value="<?= $condicion['id_condicion'] ?>">
                                                    <?= $condicion['descripcion'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Observaciones</label>
                                                <textarea name="vobservaciones" class="form-control"
                                                    rows="1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="reset" class="btn btn-default">Cancelar</button>
                                    <button type="submit" class="btn btn-success pull-right">
                                        <i class="fa fa-save"></i> Registrar Venta
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>
    </div>

    <?php require 'menu/js_lte.ctp'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/es.js"></script>

    <script>
    $(document).ready(function() {
        // Inicializar Select2
        $('.select2').select2({
            language: "es",
            width: '100%'
        });

        // Función para calcular subtotal de una fila
        function calcularSubtotalFila(row) {
            const cantidad = parseFloat(row.find('.cantidad').val()) || 0;
            const precio = parseFloat(row.find('.precio').val()) || 0;
            const subtotal = cantidad * precio;
            row.find('.subtotal').val(subtotal.toFixed(2));
            return subtotal;
        }

        // Función para calcular subtotal con descuento
        function calcularSubtotalConDescuento(row) {
            const cantidad = parseFloat(row.find('.cantidad').val()) || 0;
            const precio = parseFloat(row.find('.precio').val()) || 0;
            const descuento = parseFloat(row.find('.descuento').val()) || 0;
            const subtotal = cantidad * precio * (1 - descuento / 100);
            row.find('.subtotal').val(subtotal.toFixed(2));
            return subtotal;
        }

        // Función para calcular IVA de una fila
        function calcularIvaFila(row) {
            const subtotal = parseFloat(row.find('.subtotal').val()) || 0;
            const ivaPorcentaje = parseFloat(row.find('.iva-porcentaje').val()) || 0;
            return subtotal * (ivaPorcentaje / 100);
        }

        // Función para calcular totales generales
        function calcularTotales() {
            let subtotal = 0;
            let iva5 = 0;
            let iva10 = 0;
            let exento = 0;
            let descuentoGlobal = parseFloat($('input[name="descuento"]').val()) || 0;

            $('#detalleVenta tbody tr').each(function() {
                const rowSubtotal = parseFloat($(this).find('.subtotal').val()) || 0;
                subtotal += rowSubtotal;

                const ivaPorcentaje = parseFloat($(this).find('.iva-porcentaje').val()) || 0;

                if (ivaPorcentaje === 5) {
                    iva5 += calcularIvaFila($(this));
                } else if (ivaPorcentaje === 10) {
                    iva10 += calcularIvaFila($(this));
                } else {
                    exento += rowSubtotal;
                }
            });

            const total = (subtotal - descuentoGlobal) + iva5 + iva10;

            $('input[name="vsubtotal"]').val(subtotal.toFixed(2));
            $('input[name="iva5"]').val(iva5.toFixed(2));
            $('input[name="iva10"]').val(iva10.toFixed(2));
            $('input[name="exento"]').val(exento.toFixed(2));
            $('input[name="total"]').val(total.toFixed(2));
        }

        // Evento para cambios en cantidad y precio
        $(document).on('input', '.cantidad, .precio', function() {
            const row = $(this).closest('tr');
            calcularSubtotalFila(row);
            calcularTotales();
        });

        // Evento para cambios en descuento
        $(document).on('change', '.descuento', function() {
            const row = $(this).closest('tr');
            calcularSubtotalConDescuento(row);
            calcularTotales();
        });

        // Cargar artículos desde control de producción
        $('#control_id').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const cliCod = selectedOption.data('cli');
            $('#cli_cod').val(cliCod).trigger('change');

            const control_id = $(this).val();

            if (control_id) {
                $.ajax({
                    url: 'get_detalle_venta_por_control.php',
                    type: 'POST',
                    data: {
                        control_id: control_id
                    },
                    success: function(response) {
                        const articulos = JSON.parse(response);
                        $('#detalleVenta tbody').empty();

                        let contador = 0;

                        articulos.forEach(item => {
                            const nuevaFila = `
                            <tr>
                                <td>
                                    <input type="hidden" name="detalle[${contador}][art_cod]" value="${item.art_cod}">
                                    <input type="hidden" class="iva-porcentaje" value="${item.iva_porcentaje}">
                                    <input type="text" class="form-control" value="${item.art_descri}" readonly>
                                </td>
                                <td><input type="number" name="detalle[${contador}][cantidad]" class="form-control cantidad" value="${item.pre_cant}" required></td>
                                <td><input type="number" name="detalle[${contador}][precio_unitario]" class="form-control precio text-right" value="${item.art_preciov}" step="0.01" required></td>
                                <td><input type="number" name="detalle[${contador}][descuento]" class="form-control descuento text-right" value="0" min="0" max="100"></td>
                                  <input type="hidden" name="detalle[${contador}][tipo_cod]" value="${item.tipo_cod}">
                                <td><input type="text" class="form-control subtotal text-right" readonly></td>
                                <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-eliminar-item"><i class="fa fa-trash"></i></button></td>
                            </tr>`;
                            $('#detalleVenta tbody').append(nuevaFila);

                            // Calcular subtotal inmediatamente
                            const row = $('#detalleVenta tbody tr').last();
                            calcularSubtotalFila(row);

                            contador++;
                        });

                        calcularTotales();
                    },
                    error: function(xhr) {
                        alert('Error al cargar artículos: ' + xhr.responseText);
                    }
                });
            }
        });

        // Agregar filas dinámicas manualmente
        let contadorFilas = 0;
        $('#agregarFila').click(function() {
            contadorFilas++;
            const nuevaFila = `
            <tr>
                <td>
                    <select name="detalle[${contadorFilas}][art_cod]" class="form-control select2 articulo" required>
                        <option value="">Seleccione artículo</option>
                        <?php foreach($articulos as $art): ?>
                        <option value="<?= $art['art_cod'] ?>" 
                            data-precio="<?= $art['art_preciov'] ?>" 
                            data-iva="<?= $art['iva_porcentaje'] ?>">
                            <?= $art['art_descri'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="detalle[${contadorFilas}][cantidad]" class="form-control cantidad" min="1" value="1" required></td>
                <td><input type="number" name="detalle[${contadorFilas}][precio_unitario]" class="form-control precio text-right" step="0.01" required></td>
                <td><input type="number" name="detalle[${contadorFilas}][descuento]" class="form-control descuento text-right" min="0" max="100" value="0"></td>
                <td><input type="text" class="form-control subtotal text-right" readonly></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-eliminar-item"><i class="fa fa-trash"></i></button></td>
            </tr>`;

            $('#detalleVenta tbody').append(nuevaFila);
            $('.select2').select2();

            // Inicializar precio y IVA cuando se selecciona artículo
            $(`select[name="detalle[${contadorFilas}][art_cod]"]`).on('change', function() {
                const selected = $(this).find(':selected');
                const precio = selected.data('precio') || 0;
                const iva = selected.data('iva') || 0;

                const row = $(this).closest('tr');
                row.find('.precio').val(precio.toFixed(2));
                row.find('.iva-porcentaje').val(iva);

                // Calcular subtotal inmediatamente
                calcularSubtotalFila(row);
                calcularTotales();
            });
        });

        // Eliminar fila del detalle
        $(document).on('click', '.btn-eliminar-item', function() {
            $(this).closest('tr').remove();
            calcularTotales();
        });

        // Calcular cuando cambia el descuento global
        $('input[name="descuento"]').on('change', calcularTotales);

        // Generar número de comprobante al cambiar tipo
        $('select[name="vid_tipo_comprobante"]').change(function() {
            const tipo = $(this).val();
            if (tipo) {
                $.ajax({
                    url: 'get_next_comprobante.php',
                    type: 'POST',
                    data: {
                        tipo_comprobante: tipo
                    },
                    success: function(response) {
                        $('input[name="vnro_comprobante"]').val(response);
                    },
                    error: function(xhr) {
                        alert('Error al generar número de comprobante: ' + xhr
                            .responseText);
                    }
                });
            }
        });
        // Antes de enviar el formulario, reorganizar los datos
        $('#ventaForm').on('submit', function(e) {
            e.preventDefault();

            // Reindexar las filas del detalle
            $('#detalleVenta tbody tr').each(function(index) {
                $(this).find('[name^="detalle["]').each(function() {
                    const name = $(this).attr('name');
                    const newName = name.replace(/\[(\d+)\]/, '[' + index + ']');
                    $(this).attr('name', newName);
                });
            });

            // Enviar el formulario normalmente
            this.submit();
        });
        // Establecer fechas por defecto
        const now = new Date();
        const vencimiento = new Date();
        vencimiento.setDate(now.getDate() + 30);

        // Cambiar en JavaScript
        $('input[name="vven_fecha"]').val(now.toISOString().slice(0, 16));
        $('input[name="vven_fecha_vencimiento"]').val(vencimiento.toISOString().slice(0, 16));

        // Validación de fechas
        $('input[name="ven_fecha_vencimiento"]').on('change', function() {
            const fechaVenta = new Date($('input[name="ven_fecha"]').val());
            const fechaVenc = new Date($(this).val());

            if (fechaVenc < fechaVenta) {
                alert('La fecha de vencimiento no puede ser anterior a la fecha de venta');
                $(this).val(fechaVenta.toISOString().slice(0, 10));
            }
        });

        // Inicializar con una fila
        $('#agregarFila').click();
    });
    const form = document.getElementById('miFormulario');

    form.addEventListener('submit', function(e) {
        const input = document.getElementById('nombre');
        if (!input.value.trim()) {
            input.setCustomValidity("Este campo es obligatorio");
            input.reportValidity();
            e.preventDefault();
        } else {
            input.setCustomValidity(""); // limpia errores
        }
    });
    </script>