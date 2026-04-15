<?php
// controllers/PlanesController.php
require_once __DIR__ . '/../models/Plan.php';

class PlanesController {
    private $planModel;

    public function __construct() {
        $this->planModel = new Plan();
    }
    
// Cambia el nombre del método aquí
public function listarPlanes() {
    return $this->planModel->findAll();
}

  public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $success = $this->planModel->create($_POST);
        if ($success) {
            // Cambiamos la ruta para que regrese al formulario de creación
            header("Location: ../views/dashboard/administrador.php?page=crear_plan&status=success");
        } else {
            header("Location: ../views/dashboard/administrador.php?page=crear_plan&status=error");
        }
        exit();
    }
}
}

// IMPORTANTE: Esta parte activa el proceso
if (isset($_POST['btn_guardar_plan'])) {
    $controller = new PlanesController();
    $controller->store();
}