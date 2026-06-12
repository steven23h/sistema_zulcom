<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensaje_local = "";

// CORREGIDO: Se eliminó la restricción de rol en el POST para permitir que el Administrador registre
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {

    require_once '../../controllers/AuthController.php';
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    // CORREGIDO: Ahora valida correctamente "success_admin" para procesar el redireccionamiento
    if ($res === "success_login" || $res === "success_admin" || $res === "success") {
        $path = (isset($_SESSION['role']) && $_SESSION['role'] === 'Administracion') ? 'administrador.php' : strtolower($_SESSION['role']) . '.php';
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
    <link rel="stylesheet" href="/zulcom2/css/styles.css">
</head>

<body>

    <div class="container-form personal-form-card">

        <h2>👤 Registro de Nuevo Personal</h2>

        <p class="form-subtitle">
            Complete la información requerida para dar de alta al nuevo usuario en el sistema.
        </p>

        <?php if (!empty($mensaje_local)) echo $mensaje_local; ?>

        <form method="POST" enctype="multipart/form-data" id="main-form">

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" name="nombres" required
                        value="<?= $esError ? htmlspecialchars($_POST['nombres']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" required
                        value="<?= $esError ? htmlspecialchars($_POST['apellidos']) : ''; ?>">
                </div>

            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>Cédula</label>
                    <input type="text"
                        name="cedula"
                        pattern="[0-9]{10}"
                        maxlength="10"
                        required
                        value="<?= $esError ? htmlspecialchars($_POST['cedula']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text"
                        name="telefono"
                        required
                        value="<?= $esError ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                </div>

            </div>
            <div class="form-grid">

                <div class="form-group">
                    <label>Fecha de Ingreso</label>
                    <input
                        type="date"
                        name="fecha_ingreso"
                        required
                        value="<?= $esError ? htmlspecialchars($_POST['fecha_ingreso'] ?? '') : ''; ?>">
                </div>

            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email"
                    name="email"
                    required
                    value="<?= $esError ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label>Domicilio</label>
                <input type="text"
                    name="domicilio"
                    required
                    value="<?= $esError ? htmlspecialchars($_POST['domicilio']) : ''; ?>">
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>Código Empresa</label>
                    <input type="text"
                        name="codigo_empresa"
                        required>
                </div>

                <div class="form-group">
                    <label>Rol</label>
                    <select name="role" required>
                        <option value="Tecnico">Técnico</option>
                        <option value="Administracion">Administración</option>
                    </select>
                </div>

            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>Copia de Cédula (PDF)</label>
                    <input type="file"
                        name="copia_cedula"
                        accept=".pdf"
                        required>
                </div>

                <div class="form-group">
                    <label>Récord Policial (PDF)</label>
                    <input type="file"
                        name="record_policial"
                        accept=".pdf"
                        required>
                </div>

            </div>

            <div class="acciones-form">

                <button
                    type="submit"
                    name="btn_registrar"
                    class="btn-save">
                    REGISTRAR PERSONAL
                </button>

            </div>

        </form>

    </div>
</body>
</html>