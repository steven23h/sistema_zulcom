<?php
// actions/descargar_contrato.php
require_once __DIR__ . '/../controllers/DocxController.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $controller = new DocxController();
    $controller->generateContract($id);
} else {
    echo "Error: ID de cliente no proporcionado.";
}