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

    // =========================
    // LISTAR PLANES
    // =========================
    public function index() {

        return $this->planModel->getAll();
    }

    // =========================
    // OBTENER PLAN POR ID
    // =========================
    public function obtenerPorId($id) {

        return $this->planModel->getById($id);
    }

    // =========================
    // CREAR PLAN
    // =========================
    public function store() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $success = $this->planModel->create($_POST);

            if ($success) {

                echo "
                <script>
                    alert('¡Plan registrado con éxito!');
                    window.location.href = '../dashboard/administrador.php?page=ver_planes';
                </script>";

                exit();

            } else {

                echo "
                <script>
                    alert('Error al guardar el plan.');
                </script>";
            }
        }
    }

    // =========================
    // ACTUALIZAR PLAN
    // =========================
    public function update() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $success = $this->planModel->update($_POST);

            if ($success) {

                echo "
                <script>
                    alert('¡Plan actualizado correctamente!');
                    window.location.href = '../dashboard/administrador.php?page=ver_planes';
                </script>";

                exit();

            } else {

                echo "
                <script>
                    alert('Error al actualizar el plan.');
                </script>";
            }
        }
    }

    // =========================
    // ELIMINAR PLAN
    // =========================
    public function destroy($id) {

        if (!empty($id)) {

            $res = $this->planModel->delete($id);

            if ($res) {

                echo "
                <script>
                    alert('Plan eliminado correctamente');
                    window.location.href = '../dashboard/administrador.php?page=ver_planes';
                </script>";

                exit();

            } else {

                echo "
                <script>
                    alert('Error al eliminar. Es posible que el plan esté asignado a clientes.');
                    window.location.href = '../dashboard/administrador.php?page=ver_planes';
                </script>";

                exit();
            }
        }
    }
}

// =========================
// PROCESAMIENTO
// =========================
$controller = new PlanesController();

// CREAR
if (isset($_POST['btn_guardar_plan'])) {

    $controller->store();
}

// ACTUALIZAR
if (isset($_POST['btn_actualizar_plan'])) {

    $controller->update();
}

// ELIMINAR
if (
    isset($_GET['action']) &&
    $_GET['action'] === 'eliminar_plan' &&
    isset($_GET['id'])
) {

    $controller->destroy($_GET['id']);
}