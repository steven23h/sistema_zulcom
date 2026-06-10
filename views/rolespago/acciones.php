<?php

session_start();

require_once '../../controllers/RolPagoController.php';

$controller = new RolPagoController();

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'pdf':

        $controller->generarPDF($_GET['id_trabajador']);
        break;

    case 'eliminar':

        $controller->eliminarRol($_GET['id']);

        header("Location: ../dashboard/administrador.php?page=ver_roles");
        exit;

        break;
}
