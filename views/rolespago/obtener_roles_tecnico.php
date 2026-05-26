<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../config/database.php';

header('Content-Type: application/json');

try {

    if (!isset($_SESSION['user_id'])) {

        echo json_encode([]);
        exit;
    }

    $pdo = Database::connect();

    $id_trabajador = $_SESSION['user_id'];

    $sql = "
        SELECT *
        FROM roles_pago
        WHERE id_trabajador = ?
        ORDER BY created_at DESC
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id_trabajador]);

    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($roles);

} catch (Exception $e) {

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}