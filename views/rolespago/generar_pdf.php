<?php

require_once '../../controllers/rolpagoController.php';

$controller = new RolPagoController();

$id = $_GET['id_trabajador'] ?? null;

if($id){

    $controller->generarPDF($id);

}