<?php

require_once '../../controllers/rolpagoController.php';

header('Content-Type: application/json');

$controller = new RolPagoController();

echo json_encode(
    $controller->crearRolPago($_POST)
);