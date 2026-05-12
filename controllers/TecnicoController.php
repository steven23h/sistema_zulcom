<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Ticket.php';

class TecnicoController {
    private $db;
    private $ticketModel;

    public function __construct() {
        $this->db = Database::connect();
        $this->ticketModel = new Ticket($this->db);
    }

    // 🔥 LISTAR SOLO SUS TICKETS
    public function index($id_tecnico) {
        return $this->ticketModel->getByTecnico($id_tecnico);
    }

    // 🔥 VER DETALLE
    public function show($id) {
        return $this->ticketModel->getById($id);
    }

    // 🔥 RESOLVER TICKET
    public function resolver() {
        if (isset($_POST['resolver_ticket'])) {

            $id = $_POST['id'];

            date_default_timezone_set('America/Guayaquil');

            $data = [
                'solution' => $_POST['solution'],
                'status' => $_POST['status'],
                'solutionDate' => date('Y-m-d'),
                'solutionTime' => date('H:i:s')
            ];

            $this->ticketModel->resolver($id, $data);

            echo "<script>
                alert('Ticket resuelto correctamente');
                window.location.href='../views/dashboard/tecnico.php?page=tecnico_tickets';
            </script>";
            exit;
        }
    }
}

// 🔥 INSTANCIA
$controller = new TecnicoController();

// 🔥 ACCIÓN RESOLVER
if (isset($_POST['resolver_ticket'])) {
    $controller->resolver();
}