<?php
require_once 'config/database.php';

header('Content-Type: application/json');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

$query = "SELECT 
            c.cli_razon_social as cliente,
            ct.saldo,
            TO_CHAR(ct.fecha_vencimiento, 'DD/MM/YYYY') as vencimiento
          FROM cuentas_cobrar ct
          JOIN clientes c ON ct.cli_cod = c.cli_cod
          WHERE ct.cta_cod = ?";

$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode([
        'cliente' => $data['cliente'],
        'saldo' => (float)$data['saldo'],
        'vencimiento' => $data['vencimiento']
    ]);
} else {
    echo json_encode(['error' => 'Cuenta no encontrada']);
}