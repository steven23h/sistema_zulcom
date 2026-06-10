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
    // 🔥 OBTENER TODOS LOS CLIENTES PARA EL MÓDULO DE COORDENADAS
public function getClientesCoordenadas() {
    // Ajusta los nombres de las columnas 'coordenadas' e 'ip' según los tengas en tu tabla 'clientes'
    $sql = "SELECT id_cliente, nombre, apellido, cedula, ip, coordenadas, direccion 
            FROM clientes 
            ORDER BY apellido ASC";
            
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // 🔥 RESOLVER TICKET (Sube imágenes fijas en disco y actualiza MySQL)
    public function resolver() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Extraer el ID enviado por el formulario de resolución
            $id = $_POST['id_ticket'] ?? null;
            if (!$id) {
                die("Error: No se ha provisto el identificador ID del ticket.");
            }

            // Forzar zona horaria local de Ecuador
            date_default_timezone_set('America/Guayaquil');

            // Configurar el directorio físico donde se guardarán las fotos
            $uploadDir = __DIR__ . '/../public/uploads/evidencias/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fotoAntesPath = null;
            $fotoDespuesPath = null;

            // 📸 Procesamiento y guardado seguro de la Foto Antes
            if (isset($_FILES['foto_antes']) && $_FILES['foto_antes']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['foto_antes']['name'], PATHINFO_EXTENSION);
                $filename = "ticket_" . $id . "_antes_" . time() . "." . $ext;
                if (move_uploaded_file($_FILES['foto_antes']['tmp_name'], $uploadDir . $filename)) {
                    $fotoAntesPath = 'public/uploads/evidencias/' . $filename;
                }
            }

            // 📸 Procesamiento y guardado seguro de la Foto Después
            if (isset($_FILES['foto_despues']) && $_FILES['foto_despues']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['foto_despues']['name'], PATHINFO_EXTENSION);
                $filename = "ticket_" . $id . "_despues_" . time() . "." . $ext;
                if (move_uploaded_file($_FILES['foto_despues']['tmp_name'], $uploadDir . $filename)) {
                    $fotoDespuesPath = 'public/uploads/evidencias/' . $filename;
                }
            }

            // Recopilar la información y homogeneizar nombres de variables con el Modelo
            $data = [
                'solution'     => $_POST['solucion'] ?? '',
                'materiales'   => $_POST['materiales'] ?? '',
                'foto_antes'   => $fotoAntesPath,
                'foto_despues' => $fotoDespuesPath,
                'status'       => $_POST['estado'] ?? 'completado',
                'solutionDate' => date('Y-m-d'),
                'solutionTime' => date('H:i:s')
            ];

            // Ejecución
            if ($this->ticketModel->resolver($id, $data)) {
                echo "<script>
                    alert('¡Ticket resuelto, materiales y evidencias guardados con éxito en Zulcom!');
                    window.location.href='../views/dashboard/tecnico.php?page=mis_tickets';
                </script>";
                exit;
            } else {
                echo "<script>
                    alert('Hubo un problema de escritura SQL en la base de datos.');
                    window.history.back();
                </script>";
                exit;
            }
        }
    }
}

// 🔥 INICIALIZACIÓN AUTOMÁTICA SI RECIBE UN POST DIRECTO
$controller = new TecnicoController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->resolver();
}
?>