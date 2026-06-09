<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Ticket.php';

class TicketsController {
    private $db;
    private $ticketModel;

    public function __construct() {
        $this->db = Database::connect();
        $this->ticketModel = new Ticket($this->db);
    }

    // 🔥 LISTAR TODOS (ADMIN)
    public function index() {
        return $this->ticketModel->getAll();
    }

    // 🔥 CREAR
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($_POST['id_cliente'])) {
                echo "<script>
                    alert('Debe seleccionar un cliente válido usando el botón Buscar.');
                    history.back();
                </script>";
                exit;
            }

            $this->ticketModel->create($_POST);

            echo "<script>
                alert('Ticket creado correctamente');
                window.location.href='../views/dashboard/administrador.php?page=ver_tickets';
            </script>";
            exit;
        }
    }

    // 🔥 ACTUALIZAR
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->ticketModel->update($_POST);

            echo "<script>
                alert('Ticket actualizado');
                window.location.href='../views/dashboard/administrador.php?page=ver_tickets';
            </script>";
            exit;
        }
    }

    // 🔥 VER DETALLE
    public function show($id) {
        return $this->ticketModel->getById($id);
    }

    // 🔥 ELIMINAR
    public function destroy($id) {
        if ($id) {
            $this->ticketModel->delete($id);

            echo "<script>
                alert('Ticket eliminado correctamente');
                window.location.href='../views/dashboard/administrador.php?page=ver_tickets';
            </script>";
            exit;
        }
    }
}

// 🔥 INSTANCIA
$controller = new TicketsController();

// =============================
// 🔥 ACCIONES ENRUTADAS
// =============================
if (isset($_POST['btn_guardar_ticket'])) {
    $controller->store();
}

if (isset($_POST['btn_actualizar_ticket'])) {
    $controller->update();
}

if (isset($_GET['action']) && $_GET['action'] == 'ver_ticket') {
    $ticket = $controller->show($_GET['id']);
}

if (isset($_GET['action']) && $_GET['action'] === 'eliminar_ticket') {
    $controller->destroy($_GET['id']);
}
?>