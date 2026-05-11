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

    public function obtenerPorId($id) {
        return $this->clienteModel->getById($id);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // NUEVA FUNCIÓN PARA ACTUALIZAR
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->clienteModel->update($_POST); // Asegúrate que tu modelo Cliente tenga el método update
            
            if ($success) {
                // Esto evita el error de conversión y hace la redirección limpia
                echo "<script>
                    alert('¡Datos actualizados correctamente!');
                    window.location.href = '../views/dashboard/administrador.php?page=ver_clientes';
                </script>";
            } else {
                echo "Error al actualizar los datos del cliente.";
            }
        }
    }
}

// LÓGICA DE ACTIVACIÓN DE MÉTODOS
$controller = new ClientesController();

if (isset($_POST['btn_guardar_cliente'])) {
    $controller->store();
}

if (isset($_POST['btn_actualizar_cliente'])) {
    $controller->update();
}
// Este es el "escuchador" que busca el action de tu enlace
if (isset($_GET['action']) && $_GET['action'] === 'eliminar_cliente') {
    $controller->destroy($_GET['id']);
}