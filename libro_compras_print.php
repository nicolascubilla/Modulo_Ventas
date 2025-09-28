<?php
session_start();
require 'clases/conexion.php';

$desde     = $_GET['fecha_desde'] ?? '';
$hasta     = $_GET['fecha_hasta'] ?? '';
$estado    = $_GET['estado'] ?? '';
$sucursal  = $_GET['sucursal'] ?? '';
$proveedor = $_GET['proveedor'] ?? '';
$condicion = $_GET['condicion'] ?? '';

// Validar fechas
if (empty($desde) || empty($hasta)) {
    die("Error: Fechas son obligatorias");
}

// Construir la consulta para libro de compras
$sql = "SELECT * FROM v_libro_compras_rpt WHERE fecha_registro::date BETWEEN '$desde' AND '$hasta'";

if (!empty($estado)) {
    $sql .= " AND id_estado = " . (int)$estado;
}

if (!empty($sucursal)) {
    $sql .= " AND id_sucursal = " . (int)$sucursal;
}

if (!empty($proveedor)) {
    $sql .= " AND prv_cod = " . (int)$proveedor;
}

if (!empty($condicion)) {
    $sql .= " AND condicion = '" . pg_escape_string($condicion) . "'";
}

$sql .= " ORDER BY fecha_registro DESC, id_factura";

// Ejecutar consulta
$compras = consultas::get_datos($sql);

// Obtener nombres para mostrar en el reporte
$sucursal_nombre = 'Todas las sucursales';
if (!empty($sucursal)) {
    $result = consultas::get_datos("SELECT suc_descri FROM sucursal WHERE id_sucursal = " . (int)$sucursal);
    if ($result) {
        $sucursal_nombre = $result[0]['suc_descri'];
    }
}

$proveedor_nombre = 'Todos los proveedores';
if (!empty($proveedor)) {
    $result = consultas::get_datos("SELECT prv_razonsocial FROM proveedor WHERE prv_cod = " . (int)$proveedor);
    if ($result) {
        $proveedor_nombre = $result[0]['prv_razonsocial'];
    }
}

// Calcular totales
$total_general = 0;
$total_iva5 = 0;
$total_iva10 = 0;
if (!empty($compras)) {
    $total_general = array_sum(array_column($compras, 'monto_total'));
    $total_iva5 = array_sum(array_column($compras, 'suma_iva_5'));
    $total_iva10 = array_sum(array_column($compras, 'suma_iva_10'));
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Libro de Compras</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 10px; 
            font-size: 12px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
            font-size: 10px;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 5px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .total-row { background-color: #e6e6e6; font-weight: bold; }
        .header-info { margin-bottom: 15px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <h3 class="text-center">LIBRO DE COMPRAS</h3>
    
    <div class="header-info">
        <p><strong>Período:</strong> <?= htmlspecialchars($desde) ?> al <?= htmlspecialchars($hasta) ?></p>
        <p><strong>Sucursal:</strong> <?= htmlspecialchars($sucursal_nombre) ?></p>
        <p><strong>Proveedor:</strong> <?= htmlspecialchars($proveedor_nombre) ?></p>
        <?php if (!empty($condicion)): ?>
            <p><strong>Condición:</strong> <?= htmlspecialchars($condicion) ?></p>
        <?php endif; ?>
        <p><strong>Fecha de generación:</strong> <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <?php if (!empty($compras)): ?>
        <table>
            <thead>
                <tr>
                    <th width="5%">N°</th>
                    <th width="8%">Fecha</th>
                    <th width="10%">N° Factura</th>
                    <th width="15%">Proveedor</th>
                    <th width="8%">Timbrado</th>
                    <th width="8%">Condición</th>
                    <th width="10%">Método Pago</th>
                    <th width="8%">IVA 5%</th>
                    <th width="8%">IVA 10%</th>
                    <th width="10%">Total</th>
                    <th width="10%">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $index => $compra): ?>
                <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td><?= date('d/m/Y', strtotime($compra['fecha_registro'])) ?></td>
                    <td><?= htmlspecialchars($compra['id_factu_proveedor'] ?? $compra['id_factura']) ?></td>
                    <td><?= htmlspecialchars($compra['prv_razonsocial']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($compra['timbrado']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($compra['condicion']) ?></td>
                    <td><?= htmlspecialchars($compra['metodo_pago_nombre']) ?></td>
                    <td class="text-right"><?= number_format($compra['suma_iva_5'], 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($compra['suma_iva_10'], 0, ',', '.') ?></td>
                    <td class="text-right text-bold"><?= number_format($compra['monto_total'], 0, ',', '.') ?></td>
                    <td class="text-center">
                        <span style="padding: 2px 5px; background-color: 
                            <?= $compra['estado_nombre'] == 'ACTIVO' ? '#d4edda' : 
                              ($compra['estado_nombre'] == 'ANULADO' ? '#f8d7da' : '#fff3cd') ?>;">
                            <?= $compra['estado_nombre'] ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <!-- Totales -->
                <tr class="total-row">
                    <td colspan="7" class="text-right text-bold">TOTALES GENERALES:</td>
                    <td class="text-right text-bold"><?= number_format($total_iva5, 0, ',', '.') ?></td>
                    <td class="text-right text-bold"><?= number_format($total_iva10, 0, ',', '.') ?></td>
                    <td class="text-right text-bold"><?= number_format($total_general, 0, ',', '.') ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Resumen estadístico -->
        <div style="margin-top: 20px; padding: 10px; background-color: #f8f9fa; border: 1px solid #dee2e6;">
            <h4 class="text-center">Resumen Estadístico</h4>
            <div style="display: flex; justify-content: space-around; text-align: center;">
                <div>
                    <strong>Total Facturas:</strong><br>
                    <?= count($compras) ?>
                </div>
                <div>
                    <strong>Total IVA 5%:</strong><br>
                    <?= number_format($total_iva5, 0, ',', '.') ?>
                </div>
                <div>
                    <strong>Total IVA 10%:</strong><br>
                    <?= number_format($total_iva10, 0, ',', '.') ?>
                </div>
                <div>
                    <strong>Valor Total:</strong><br>
                    <?= number_format($total_general, 0, ',', '.') ?>
                </div>
            </div>
        </div>

    <?php else: ?>
        <p class="text-center">No se encontraron registros en el libro de compras según los filtros seleccionados</p>
    <?php endif; ?>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>