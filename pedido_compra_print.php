<?php
session_start();
require 'clases/conexion.php';

$desde    = $_GET['fecha_desde'] ?? '';
$hasta    = $_GET['fecha_hasta'] ?? '';
$estado   = $_GET['estado'] ?? '';
$sucursal = $_GET['sucursal'] ?? '';

// Validar fechas
if (empty($desde) || empty($hasta)) {
    die("Error: Fechas son obligatorias");
}

// Construir la consulta igual que en tu ejemplo de marcas
$sql = "SELECT * FROM v_pedido_compra_detalle WHERE fecha_pedido::date BETWEEN '$desde' AND '$hasta'";

if (!empty($estado)) {
    $sql .= " AND estado = '" . pg_escape_string($estado) . "'";
}

if (!empty($sucursal)) {
    $sql .= " AND id_sucursal = " . (int)$sucursal;
}

$sql .= " ORDER BY id_pedido DESC";

// Ejecutar consulta (igual que en tu ejemplo funcional)
$pedidos = consultas::get_datos($sql);

// Obtener nombre de sucursal
$sucursal_nombre = '';
if (!empty($sucursal)) {
    $result = consultas::get_datos("SELECT suc_descri FROM sucursal WHERE id_sucursal = " . (int)$sucursal);
    if ($result) {
        $sucursal_nombre = $result[0]['suc_descri'];
    }
}

// Ahora el HTML simple y directo
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informe Pedidos de Compras</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h3 class="text-center">Informe de Pedidos de Compras</h3>
    <p class="text-center">
        Período: <?= htmlspecialchars($desde) ?> al <?= htmlspecialchars($hasta) ?><br>
        <?php if (!empty($estado)) echo "Estado: " . htmlspecialchars($estado) . "<br>"; ?>
        <?php if (!empty($sucursal_nombre)) echo "Sucursal: " . htmlspecialchars($sucursal_nombre) . "<br>"; ?>
    </p>

    <?php if (!empty($pedidos)): ?>
    <table>
        <thead>
            <tr>
                <th># Pedido</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Sucursal</th>
                <th>Estado</th>
                <th>Observación</th>
                <th>Material</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['id_pedido'] ?></td>
                <td><?= $p['fecha_pedido'] ?></td>
                <td><?= $p['usuario'] ?></td>
                <td><?= $p['sucursal'] ?></td>
                <td><?= $p['estado'] ?></td>
                <td><?= $p['observacion'] ?></td>
                <td><?= $p['material'] ?></td>
                <td class="text-right"><?= $p['cantidad'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p class="text-center">No se encontraron registros según el filtro</p>
    <?php endif; ?>

    <script>
        // Imprimir automáticamente y cerrar después de imprimir
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 100);
        };
    </script>
</body>
</html>