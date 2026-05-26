<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Plan.php';

class PlanesController {
    private $db;
    private $planModel;

    public function __construct() {
        $this->db = Database::connect();
        $this->planModel = new Plan($this->db);
    }

    public function index() {
        return $this->planModel->getAll();
    }

    public function obtenerPorId($id) {
        // Validar que el ID sea numérico
        $id = filter_var($id, FILTER_VALIDATE_INT);
        return $id ? $this->planModel->getById($id) : null;
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->planModel->create($_POST);
            if ($success) {
                echo "<script>
                    alert('¡Plan registrado con éxito!');
                    window.location.href = '../views/dashboard/administrador.php?page=ver_planes';
                </script>";
            } else {
                echo "<script>alert('Error al guardar el plan.');</script>";
            }
        }
    }

    public function destroy($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id) {
            $res = $this->planModel->delete($id);
            if ($res) {
                echo "<script>
                    alert('Plan eliminado correctamente');
                    window.location.href = '../views/dashboard/administrador.php?page=ver_planes';
                </script>";
            } else {
                echo "<script>
                    alert('Error al eliminar: Es posible que el plan esté asignado a clientes.');
                    window.location.href = '../views/dashboard/administrador.php?page=ver_planes';
                </script>";
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->planModel->update($_POST);
            if ($success) {
                echo "<script>
                    alert('¡Plan actualizado correctamente!');
                    window.location.href = '../views/dashboard/administrador.php?page=ver_planes';
                </script>";
            } else {
                echo "<script>alert('Error al actualizar el plan.');</script>";
            }
        }
    }
}

// LÓGICA DE PROCESAMIENTO
$controller = new PlanesController();

if (isset($_POST['btn_guardar_plan'])) {
    $controller->store();
}

if (isset($_POST['btn_actualizar_plan'])) {
    $controller->update();
}

if (isset($_GET['action']) && $_GET['action'] === 'eliminar_plan') {
    $controller->destroy($_GET['id'] ?? null);
}

// He eliminado la llave extra que estaba aquí
