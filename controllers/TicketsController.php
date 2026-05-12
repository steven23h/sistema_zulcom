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
                    alert('Debe seleccionar un cliente');
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

        $sql = "SELECT t.*, 
                       c.nombre, c.apellido, c.cedula, c.correo, c.telefono1, c.telefono2, c.direccion, c.ciudad, c.provincia, c.referencias,
                       u.nombres AS tecnico_nombre, u.apellidos AS tecnico_apellido
                FROM tickets t
                LEFT JOIN clientes c ON t.id_cliente = c.id_cliente
                LEFT JOIN users u ON t.id_tecnico = u.id
                WHERE t.id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
// 🔍 BUSCAR CLIENTE (AJAX)
// =============================
if (isset($_GET['buscar_cliente'])) {

    $cedula = $_GET['cedula'] ?? '';

    $db = Database::connect();

    $sql = "SELECT * FROM clientes WHERE cedula = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$cedula]);

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode($cliente ?: ["error" => "Cliente no encontrado"]);
    exit;
}


// =============================
// 🔥 ACCIONES
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