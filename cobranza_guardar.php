<?php
session_start();
require_once 'config/database.php';

// Validar datos
$datos = [
    'cta_cod' => filter_input(INPUT_POST, 'cta_cod', FILTER_VALIDATE_INT),
    'fecha' => filter_input(INPUT_POST, 'fecha'),
    'monto' => filter_input(INPUT_POST, 'monto', FILTER_VALIDATE_FLOAT),
    'id_forma_pago' => filter_input(INPUT_POST, 'id_forma_pago', FILTER_VALIDATE_INT),
    'observaciones' => filter_input(INPUT_POST, 'observaciones')
];

// Validar campos requeridos
if (empty($datos['cta_cod']) || $datos['monto'] <= 0) {
    header('Location: cobranza_nueva.php?error=1');
    exit;
}

try {
    $pdo->beginTransaction();
    
    // 1. Registrar cobranza
    $sql = "INSERT INTO cobranzas (...) VALUES (...)";
    $stmt = $pdo->prepare($sql);
    //$stmt->execute([...]);
    $cob_cod = $pdo->lastInsertId();
    
    // 2. Actualizar saldo en cuenta
    $sqlUpdate = "UPDATE cuentas_cobrar SET saldo = saldo - ? WHERE cta_cod = ?";
    $pdo->prepare($sqlUpdate)->execute([$datos['monto'], $datos['cta_cod']]);
    
    // 3. Registrar movimiento de caja si es efectivo
    if ($datos['id_forma_pago'] == 1) { // ID para efectivo
        $sqlMov = "INSERT INTO movimientos_caja (...) VALUES (...)";
     //   $pdo->prepare($sqlMov)->execute([...]);
    }
    
    $pdo->commit();
    header("Location: cobranza_ver.php?id=$cob_cod");
} catch (PDOException $e) {
    $pdo->rollBack();
    header('Location: cobranza_nueva.php?error=1');
};