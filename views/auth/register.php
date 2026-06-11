<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensaje_local = "";

// Bloque de procesamiento de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar']) && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administracion')) {
    
    require_once '../../controllers/AuthController.php';
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    if ($res === "success_login" || $res === "success") {
        $path = ($_SESSION['role'] === 'Administracion') ? 'administrador.php' : strtolower($_SESSION['role']) . '.php';
        header("Location: ../dashboard/" . $path);
        exit();
    } else {
        $mensaje_local = "<div class='alert error'>Error: " . htmlspecialchars($res) . "</div>";
    }
}

// Variable de control para mantener los datos en caso de error
$esError = (isset($res) && $res !== 'success_admin' && $res !== 'success' && $res !== 'success_login');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Colaboradores - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/register.css">
</head>
<body>

<div class="container-form">
    <h2>👤 Registro de Nuevo Personal</h2>
    <p>Complete la información requerida para dar de alta al nuevo usuario en el sistema.</p>
    
    <?php if (!empty($mensaje_local)) echo $mensaje_local; ?>

    <form method="POST" enctype="multipart/form-data" id="main-form">
        
        <div class="form-grid">
            <div class="form-group">
                <input type="text" name="nombres" placeholder="Nombres" required 
                       value="<?= $esError ? htmlspecialchars($_POST['nombres']) : ''; ?>">
            </div>
            <div class="form-group">
                <input type="text" name="apellidos" placeholder="Apellidos" required 
                       value="<?= $esError ? htmlspecialchars($_POST['apellidos']) : ''; ?>">
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <input type="text" name="cedula" pattern="[0-9]{10}" maxlength="10" 
                       title="La cédula debe tener exactamente 10 dígitos numéricos" placeholder="Cédula" required 
                       value="<?= $esError ? htmlspecialchars($_POST['cedula']) : ''; ?>">
            </div>
            <div class="form-group">
                <input type="text" name="telefono" placeholder="Teléfono" required 
                       value="<?= $esError ? htmlspecialchars($_POST['telefono']) : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <input type="email" name="email" placeholder="Correo electrónico" required 
                   value="<?= $esError ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>

        <div class="form-group">
            <input type="text" name="domicilio" placeholder="Domicilio" required 
                   value="<?= $esError ? htmlspecialchars($_POST['domicilio']) : ''; ?>">
        </div>

        <div class="form-grid">
            <div class="form-group">
                <input type="text" name="codigo_empresa" placeholder="Código Empresa" required>
            </div>
            <div class="form-group">
                <select name="role" required>
                    <option value="Tecnico">Técnico</option>
                    <option value="Administracion">Administración</option>
                </select>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <span class="file-label">Copia de Cédula (PDF):</span>
                <input type="file" name="copia_cedula" accept=".pdf" required>
            </div>
            <div class="form-group">
                <span class="file-label">Récord Policial (PDF):</span>
                <input type="file" name="record_policial" accept=".pdf" required>
            </div>
        </div>

        <button type="submit" name="btn_registrar" class="btn-save">
            REGISTRAR PERSONAL
        </button>
    </form>
</div>

</body>
</html>