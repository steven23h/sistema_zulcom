<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {

    private $db;
    private $userModel;

    public function __construct() {
        $this->db = Database::connect();
        $this->userModel = new User($this->db);
    }

    public function login($username, $password) {

        $user = $this->userModel->getByUsername(trim($username));

        if ($user && password_verify(trim($password), $user['password'])) {

            if (session_status() == PHP_SESSION_NONE) session_start();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombres'] = $user['nombres'];
            $_SESSION['apellidos'] = $user['apellidos'];
            $_SESSION['role'] = $user['role'];

            // redirección por rol
            if ($user['role'] == 'Administracion') {
                $path = 'administrador.php';
            } elseif ($user['role'] == 'User') {
                $path = 'user_dashboard.php';
            } else {
                $path = strtolower($user['role']) . '.php';
            }

            header("Location: ../dashboard/" . $path);
            exit();
        }

        return false;
    }

    public function register($post, $files) {

        $tipo = $post['tipo_registro'];
        $cedula = trim($post['cedula']);
        $codigoEmpresaCorrecto = "ZULCOM2024";

        // validar cédula duplicada
        $check = $this->db->prepare("SELECT id FROM users WHERE cedula = ?");
        $check->execute([$cedula]);

        if ($check->rowCount() > 0) {
            return "La cédula ya existe.";
        }

        $rolFinal = 'User';
        $cc = null;
        $rp = null;

        if ($tipo === 'personal') {

            // validar código empresa
            if (trim($post['codigo_empresa']) !== $codigoEmpresaCorrecto) {
                return "Código de empresa incorrecto.";
            }

            $rolFinal = $post['role'];

            $dir = __DIR__ . '/../public/uploads/';
            if (!file_exists($dir)) mkdir($dir, 0777, true);

            // validar PDFs
            if ($files['copia_cedula']['type'] !== "application/pdf" ||
                $files['record_policial']['type'] !== "application/pdf") {
                return "Solo se permiten archivos PDF.";
            }

            $cc = time() . "_cc_" . $files['copia_cedula']['name'];
            $rp = time() . "_rp_" . $files['record_policial']['name'];

            move_uploaded_file($files['copia_cedula']['tmp_name'], $dir . $cc);
            move_uploaded_file($files['record_policial']['tmp_name'], $dir . $rp);
        }

        // generar usuario
        $partsNom = explode(' ', trim($post['nombres']));
        $partsApe = explode(' ', trim($post['apellidos']));
        $username = strtolower($partsNom[0] . "." . $partsApe[0]);

        $passwordHash = password_hash($cedula, PASSWORD_BCRYPT);

        $data = [
            ':cedula' => $cedula,
            ':telefono' => trim($post['telefono']),
            ':domicilio' => trim($post['domicilio']),
            ':nombres' => trim($post['nombres']),
            ':apellidos' => trim($post['apellidos']),
            ':email' => trim($post['email']),
            ':username' => $username,
            ':password' => $passwordHash,
            ':role' => $rolFinal,
            ':cc' => $cc,
            ':rp' => $rp
        ];

        return $this->userModel->create($data)
            ? "success"
            : "Error al guardar.";
    }
}