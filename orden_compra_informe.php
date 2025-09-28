<?php
session_start();
require 'clases/conexion.php';

$desde     = $_GET['fecha_desde'] ?? '';
$hasta     = $_GET['fecha_hasta'] ?? '';
$estado    = $_GET['estado'] ?? '';
$sucursal  = $_GET['sucursal'] ?? '';
$proveedor = $_GET['proveedor'] ?? '';

// Validar fechas
if (empty($desde) || empty($hasta)) {
    die("Error: Fechas son obligatorias");
}

// **CONSULTA CORREGIDA - usando los nombres exactos de campos de tu vista**
$sql = "SELECT * FROM v_orden_compra_cabecera_detalle WHERE fecha_orden::date BETWEEN '$desde' AND '$hasta'";

if (!empty($estado)) {
    $sql .= " AND estado = '" . pg_escape_string($estado) . "'";
}

// **CORRECCIÓN: Usar el nombre correcto del campo de sucursal**
if (!empty($sucursal)) {
    $sql .= " AND id_sucursal = " . (int)$sucursal;
}

// **CORRECCIÓN: Usar el nombre correcto del campo de proveedor**
if (!empty($proveedor)) {
    $sql .= " AND prv_cod = " . (int)$proveedor;
}

$sql .= " ORDER BY orden_id DESC, nombre_material";

// Ejecutar consulta
$ordenes = consultas::get_datos($sql);

// Obtener nombres para mostrar en el reporte
$sucursal_nombre = '';
if (!empty($sucursal)) {
    $result = consultas::get_datos("SELECT suc_descri FROM sucursal WHERE id_sucursal = " . (int)$sucursal);
    if ($result) {
        $sucursal_nombre = $result[0]['suc_descri'];
    }
}

$proveedor_nombre = '';
if (!empty($proveedor)) {
    $result = consultas::get_datos("SELECT prv_razonsocial FROM proveedor WHERE prv_cod = " . (int)$proveedor);
    if ($result) {
        $proveedor_nombre = $result[0]['prv_razonsocial'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informe Órdenes de Compra</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 15px; 
            font-size: 12px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
            font-size: 11px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 6px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .total { background-color: #e6e6e6; font-weight: bold; }
    </style>
</head>
<body>
    <h3 class="text-center">Informe de Órdenes de Compra</h3>
    <p class="text-center">
        <strong>Período:</strong> <?= htmlspecialchars($desde) ?> al <?= htmlspecialchars($hasta) ?><br>
        <?php if (!empty($estado)) echo "<strong>Estado:</strong> " . htmlspecialchars($estado) . "<br>"; ?>
        <?php if (!empty($sucursal_nombre)) echo "<strong>Sucursal:</strong> " . htmlspecialchars($sucursal_nombre) . "<br>"; ?>
        <?php if (!empty($proveedor_nombre)) echo "<strong>Proveedor:</strong> " . htmlspecialchars($proveedor_nombre) . "<br>"; ?>
    </p>

    <?php if (!empty($ordenes)): ?>
        <?php
        $orden_actual = null;
        $items_por_orden = 0;
        ?>
        
        <?php foreach ($ordenes as $index => $o): ?>
            <?php if ($orden_actual != $o['orden_id']): ?>
                <?php if ($orden_actual !== null): ?>
                    <!-- Cerrar tabla anterior -->
                    </tbody>
                    </table>
                    <br>
                <?php endif; ?>

                <!-- Nueva orden -->
                <?php 
                $orden_actual = $o['orden_id'];
                $items_por_orden = 0;
                ?>
                
                <table>
                    <thead>
                        <tr>
                            <th colspan="9" style="background-color: #d4edda;">
                                ORDEN #<?= $o['orden_id'] ?> - 
                                Proveedor: <?= $o['proveedor'] ?> - 
                                Fecha: <?= $o['fecha_orden'] ?> - 
                                Estado: <?= $o['estado'] ?>
                            </th>
                        </tr>
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">Material</th>
                            <th width="10%">Cantidad</th>
                            <th width="12%">Precio Unit.</th>
                            <th width="15%">Subtotal</th>
                            <th width="10%">Plazo Entrega</th>
                            <th width="10%">Usuario</th>
                            <th width="8%">Total Orden</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php endif; ?>

            <?php 
            $items_por_orden++;
            // **CORRECCIÓN: Usar el cálculo correcto del subtotal**
            $subtotal = $o['cantidad'] * $o['costo_unitario'];
            ?>
            
            <tr>
                <td><?= $items_por_orden ?></td>
                <td><?= htmlspecialchars($o['nombre_material']) ?></td>
                <td class="text-right"><?= number_format($o['cantidad'], 2) ?></td>
                <td class="text-right"><?= number_format($o['costo_unitario'], 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($subtotal, 0, ',', '.') ?></td>
                <td class="text-center"><?= $o['plazo_entrega'] ?> días</td>
                <td><?= htmlspecialchars($o['usuario']) ?></td>
                <td class="text-right text-bold"><?= number_format($o['total'], 0, ',', '.') ?></td>
            </tr>

            <?php if ($index == count($ordenes) - 1 || $ordenes[$index + 1]['orden_id'] != $o['orden_id']): ?>
                <!-- Total y letras para la orden actual -->
                <tr class="total">
                    <td colspan="4" class="text-right text-bold">TOTAL ORDEN <?= $orden_actual ?>:</td>
                    <td class="text-right text-bold"><?= number_format($o['total'], 0, ',', '.') ?></td>
                    <td colspan="3" class="text-center"><small><?= $o['totalletra'] ?></small></td>
                </tr>
            <?php endif; ?>

        <?php endforeach; ?>
        </tbody>
        </table>

        <!-- Resumen general simplificado -->
        <div style="margin-top: 20px; padding: 10px; background-color: #f8f9fa; border: 1px solid #dee2e6;">
            <h4 class="text-center">Resumen General</h4>
            <p class="text-center">
                <strong>Total de Órdenes:</strong> <?= count(array_unique(array_column($ordenes, 'orden_id'))) ?> |
                <strong>Total de Items:</strong> <?= count($ordenes) ?>
            </p>
        </div>

    <?php else: ?>
        <p class="text-center">No se encontraron órdenes de compra según los filtros seleccionados</p>
    <?php endif; ?>

    <script>
        // Imprimir automáticamente--
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>