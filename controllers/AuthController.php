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

    // Algoritmo de validación de Cédula de Ecuador en Backend
    private function validarCedulaEcuador($cedula) {
        if (strlen($cedula) !== 10 || !ctype_digit($cedula)) return false;
        
        $region = (int)substr($cedula, 0, 2);
        if ($region < 1 || $region > 24) return false;
        
        $ultimo_digito = (int)substr($cedula, 9, 10);
        $pares = 0;
        $impares = 0;
        
        for ($i = 0; $i < 9; $i++) {
            $mult = ($i % 2 === 0) ? (int)$cedula[$i] * 2 : (int)$cedula[$i];
            if ($mult > 9) $mult -= 9;
            ($i % 2 === 0) ? $impares += $mult : $pares += $mult;
        }
        
        $suma_total = $pares + $impares;
        $decena_superior = (int)ceil($suma_total / 10) * 10;
        $verificador = $decena_superior - $suma_total;
        if ($verificador === 10) $verificador = 0;
        
        return $verificador === $ultimo_digito;
    }

    public function register($post, $files) {
        $tipo = isset($post['tipo_registro']) ? trim($post['tipo_registro']) : 'cliente';
        $cedula = isset($post['cedula']) ? trim($post['cedula']) : '';
        $email = isset($post['email']) ? trim($post['email']) : '';
        $codigoEmpresaCorrecto = "ZULCOM2024";

        // 1. Validar campos obligatorios generales
        if (empty($cedula) || empty($email) || empty($post['nombres']) || empty($post['apellidos']) || empty($post['telefono'])) {
            return "Todos los campos marcados como obligatorios son requeridos.";
        }

        // 2. Validar algoritmo de la cédula en Backend
        if (!$this->validarCedulaEcuador($cedula)) {
            return "La cédula ingresada no es válida para el territorio ecuatoriano.";
        }

        // 3. Validar si la cédula ya existe
        $checkCedula = $this->db->prepare("SELECT id FROM users WHERE cedula = ? LIMIT 1");
        $checkCedula->execute([$cedula]);
        if ($checkCedula->rowCount() > 0) {
            return "El número de cédula ya se encuentra registrado en el sistema.";
        }

        // 4. Validar si el correo ya existe
        $checkEmail = $this->db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $checkEmail->execute([$email]);
        if ($checkEmail->rowCount() > 0) {
            return "El correo electrónico ya se encuentra registrado.";
        }

        $rolFinal = 'User';
        $cc = null;
        $rp = null;

        // 5. Validaciones específicas para Personal
        if ($tipo === 'personal') {
            if (!isset($post['codigo_empresa']) || trim($post['codigo_empresa']) !== $codigoEmpresaCorrecto) {
                return "Código de empresa incorrecto o no proporcionado.";
            }

            $rolFinal = isset($post['role']) ? trim($post['role']) : 'Tecnico';

            // Validar que los archivos existan y no tengan errores de subida
            if (!isset($files['copia_cedula']) || $files['copia_cedula']['error'] !== UPLOAD_ERR_OK ||
                !isset($files['record_policial']) || $files['record_policial']['error'] !== UPLOAD_ERR_OK) {
                return "Los archivos requeridos para el personal son obligatorios.";
            }

            // Validar formatos MIME permitidos (solo PDF en este caso para asegurar uniformidad)
            $allowedTypes = ["application/pdf"];
            if (!in_array($files['copia_cedula']['type'], $allowedTypes) || !in_array($files['record_policial']['type'], $allowedTypes)) {
                return "Solo se permiten archivos en formato PDF para los documentos del personal.";
            }

            $dir = __DIR__ . '/../public/uploads/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $cc = time() . "_cc_" . basename($files['copia_cedula']['name']);
            $rp = time() . "_rp_" . basename($files['record_policial']['name']);

            if (!move_uploaded_file($files['copia_cedula']['tmp_name'], $dir . $cc) ||
                !move_uploaded_file($files['record_policial']['tmp_name'], $dir . $rp)) {
                return "Error al subir y guardar los documentos en el servidor.";
            }
        }

        // 6. Generar el nombre de usuario único básico
        $partsNom = explode(' ', trim($post['nombres']));
        $partsApe = explode(' ', trim($post['apellidos']));
        $usernameBase = strtolower($partsNom[0] . "." . $partsApe[0]);
        
        // Verificar si el username base existe para evitar colisiones
        $checkUser = $this->db->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $checkUser->execute([$usernameBase]);
        $username = ($checkUser->rowCount() > 0) ? $usernameBase . rand(10, 99) : $usernameBase;

        $passwordHash = password_hash($cedula, PASSWORD_BCRYPT);

        $data = [
            ':cedula' => $cedula,
            ':telefono' => trim($post['telefono']),
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

        return $this->userModel->create($data) ? "success" : "Error crítico al registrar los datos en la base de datos.";
    }
}