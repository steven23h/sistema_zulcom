<?php

require_once '../../controllers/rolpagoController.php';

header('Content-Type: application/json');

$controller = new RolPagoController();

$mes = $_GET['mes'] ?? null;
$colaborador = $_GET['colaborador'] ?? null;

echo json_encode(
    $controller->listarRolesPago($mes, $colaborador)
);