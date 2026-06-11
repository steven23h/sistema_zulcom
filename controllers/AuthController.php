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

   
     
    public function listUsers() {
        return $this->userModel->getAll();
    }

    public function login($username, $password) {
        $user = $this->userModel->getByUsername(trim($username));
        if ($user && password_verify(trim($password), $user['password'])) {
            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombres'] = $user['nombres'];
            $_SESSION['apellidos'] = $user['apellidos'];
            $_SESSION['role'] = $user['role'];

            $path = ($user['role'] == 'Administracion') ? 'administrador.php' : strtolower($user['role']) . '.php';
            header("Location: ../dashboard/" . $path);
            exit();
        }
        return false;
    }

    private function validarCedulaEcuador($cedula) {
        if (strlen($cedula) !== 10 || !ctype_digit($cedula)) return false;
        $region = (int)substr($cedula, 0, 2);
        if ($region < 1 || $region > 24) return false;
        return true; 
    }

    public function register($post, $files) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $cedula = isset($post['cedula']) ? trim($post['cedula']) : '';
        $email = isset($post['email']) ? trim($post['email']) : '';
        $telefono = isset($post['telefono']) ? trim($post['telefono']) : '';
        $codigoEmpresaCorrecto = "ZULCOM2024";

        if (empty($cedula) || empty($email) || empty($post['nombres']) || empty($post['apellidos']) || empty($telefono)) {
            return "Todos los campos marcados como obligatorios son requeridos.";
        }

        if (!$this->validarCedulaEcuador($cedula)) {
            return "La cédula ingresada no es válida para el territorio ecuatoriano.";
        }

        // VALIDACIÓN PREVIA DE DUPLICADOS EXACTOS
        $checkCedula = $this->db->prepare("SELECT id FROM users WHERE cedula = ? LIMIT 1");
        $checkCedula->execute([$cedula]);
        if ($checkCedula->rowCount() > 0) {
            return "El número de cédula ya se encuentra registrado con otro colaborador.";
        }

        $checkEmail = $this->db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $checkEmail->execute([$email]);
        if ($checkEmail->rowCount() > 0) {
            return "El correo electrónico ya se encuentra registrado.";
        }

        $checkTelefono = $this->db->prepare("SELECT id FROM users WHERE telefono = ? LIMIT 1");
        $checkTelefono->execute([$telefono]);
        if ($checkTelefono->rowCount() > 0) {
            return "El número de teléfono ya se encuentra registrado por otro colaborador.";
        }

        if (!isset($post['codigo_empresa']) || trim($post['codigo_empresa']) !== $codigoEmpresaCorrecto) {
            return "Código de empresa incorrecto.";
        }

        $rolPost = isset($post['role']) ? trim($post['role']) : 'Tecnico';
        $rolFinal = ($rolPost === 'Administracion') ? 'Administracion' : 'Tecnico';

        if (!isset($files['copia_cedula']) || $files['copia_cedula']['error'] !== UPLOAD_ERR_OK ||
            !isset($files['record_policial']) || $files['record_policial']['error'] !== UPLOAD_ERR_OK) {
            return "Los archivos PDF requeridos son obligatorios.";
        }

        $dir = __DIR__ . '/../public/uploads/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $cc = time() . "_cc_" . basename($files['copia_cedula']['name']);
        $rp = time() . "_rp_" . basename($files['record_policial']['name']);

        if (!move_uploaded_file($files['copia_cedula']['tmp_name'], $dir . $cc) ||
            !move_uploaded_file($files['record_policial']['tmp_name'], $dir . $rp)) {
            return "Error al guardar los documentos en el servidor.";
        }

        // Generar Username Único
        $partsNom = explode(' ', trim($post['nombres']));
        $partsApe = explode(' ', trim($post['apellidos']));
        $usernameBase = strtolower($partsNom[0] . "." . $partsApe[0]);
        
        $checkUser = $this->db->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $checkUser->execute([$usernameBase]);
        $username = ($checkUser->rowCount() > 0) ? $usernameBase . rand(10, 99) : $usernameBase;

        $passwordHash = password_hash($cedula, PASSWORD_BCRYPT);

        $data = [
            ':cedula' => $cedula,
            ':telefono' => $telefono,
            ':domicilio' => trim($post['domicilio']),
            ':nombres' => trim($post['nombres']),
            ':apellidos' => trim($post['apellidos']),
            ':email' => $email,
            ':username' => $username,
            ':password' => $passwordHash,
            ':role' => $rolFinal,
            ':cc' => $cc,
            ':rp' => $rp
        ];

        try {
            if ($this->userModel->create($data)) {
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'Administracion') {
                    return "success_admin";
                } else {
                    $newUserQuery = $this->db->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
                    $newUserQuery->execute([$username]);
                    $newUser = $newUserQuery->fetch(PDO::FETCH_ASSOC);

                    $_SESSION['user_id'] = $newUser['id'];
                    $_SESSION['nombres'] = $data[':nombres'];
                    $_SESSION['apellidos'] = $data[':apellidos'];
                    $_SESSION['role'] = $rolFinal;
                    
                    return "success_login";
                }
            }
            return "Error al guardar el registro.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000 || strpos($e->getMessage(), '1062') !== false) {
                if (strpos($e->getMessage(), 'cedula') !== false) return "El número de cédula ya se encuentra registrado con otro colaborador.";
                if (strpos($e->getMessage(), 'email') !== false) return "El correo electrónico ya se encuentra registrado.";
                if (strpos($e->getMessage(), 'telefono') !== false) return "El número de teléfono ya está en uso.";
            }
            return "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>