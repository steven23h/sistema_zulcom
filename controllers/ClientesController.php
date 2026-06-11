<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClientesController {
    private $db;
    private $clienteModel;

    public function __construct() {
        $this->db = Database::connect();
        $this->clienteModel = new Cliente($this->db);
    }

    public function index() {
        return $this->clienteModel->getAll();
    }

    public function listarPagados() {
        return $this->clienteModel->obtenerNoDeudores();
    }

    public function listarDeudores() {
        return $this->clienteModel->obtenerDeudores();
    }

    public function obtenerPorId($id) {
        return $this->clienteModel->getById($id);
    }

    // FILTRO DE VALIDACIÓN DEL LADO DEL SERVIDOR
    private function validarDatos($data) {
        if (!preg_match('/^[0-9]{10}([0-9]{3})?$/', $data['cedula'])) {
            return "La cédula o RUC ingresado no cuenta con un formato válido para Ecuador.";
        }
        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            return "La dirección de correo electrónico no es válida.";
        }
        if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
            return "La dirección IP local o pública es incorrecta.";
        }
        return "OK";
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validacion = $this->validarDatos($_POST);
            if ($validacion !== "OK") {
                echo "<script>alert('$validacion'); window.history.back();</script>";
                exit;
            }

            $success = $this->clienteModel->create($_POST);
            if ($success) {
                echo "<script>
                    alert('¡Cliente registrado con éxito!');
                    window.location.href = '../views/dashboard/administrador.php?page=ver_clientes';
                </script>";
            } else {
                echo "Error al guardar el cliente.";
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validacion = $this->validarDatos($_POST);
            if ($validacion !== "OK") {
                echo "<script>alert('$validacion'); window.history.back();</script>";
                exit;
            }

            $success = $this->clienteModel->update($_POST);
            if ($success) {
                echo "<script>
                    alert('¡Datos actualizados correctamente!');
                    window.location.href = '../views/dashboard/administrador.php?page=ver_clientes';
                </script>";
            } else {
                echo "Error al actualizar los datos del cliente.";
            }
        }
    }

    public function destroy($id) {
        if ($id) {
            $res = $this->clienteModel->delete($id);
            if ($res) {
                echo "<script>
                    alert('Cliente eliminado correctamente');
                    window.location.href = 'administrador.php?page=ver_clientes';
                </script>";
            } else {
                echo "<script>alert('Error al eliminar el cliente');</script>";
            }
        }
    }
}

$controller = new ClientesController();

if (isset($_POST['btn_guardar_cliente'])) {
    $controller->store();
}

if (isset($_POST['btn_actualizar_cliente'])) {
    $controller->update();
}

if (isset($_GET['action']) && $_GET['action'] === 'eliminar_cliente') {
    $controller->destroy($_GET['id']);
}