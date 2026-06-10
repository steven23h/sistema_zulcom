<?php
require_once '../../controllers/AuthController.php';

$mensaje = "";
$tipo_alerta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    if ($res === "success") {
        $mensaje = "¡Registro exitoso! El usuario del personal ha sido creado correctamente.";
        $tipo_alerta = "success";
    } else {
        $mensaje = $res;
        $tipo_alerta = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Personal</title>
    <link rel="stylesheet" href="../../public/css/register.css">
</head>
<body>

    <div class="container-form">

        <h2>Registro de Personal</h2>
        <p id="form-desc">Acceso restringido para colaboradores autorizados.</p>

        <?php if(!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_alerta; ?>">
                <?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" id="main-form">

            <div class="form-row">
                <input type="text" name="nombres" placeholder="Nombres" required>
                <input type="text" name="apellidos" placeholder="Apellidos" required>
            </div>

            <div class="form-row">
                <input type="text" name="cedula" maxlength="10" placeholder="Cédula" required>
                <input type="text" name="telefono" placeholder="Teléfono" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Correo electrónico" required>
            </div>

            <div class="form-group">
                <input type="text" name="domicilio" placeholder="Domicilio" required>
            </div>

            <div class="box-personal">
                <input type="text" name="codigo_empresa" placeholder="Código Empresa" required>
            </div>

            <div class="form-group">
                <select name="role" required>
                    <option value="Tecnico">Técnico</option>
                    <option value="Administracion">Administración</option>
                </select>
            </div>

            <div class="form-row">
                <input type="file" name="copia_cedula" accept="application/pdf" required>
                <input type="file" name="record_policial" accept="application/pdf" required>
            </div>

            <button type="submit" name="btn_registrar" class="btn-register">
                REGISTRAR
            </button>

        </form>

    </div>

    <script src="../../public/js/register.js"></script>
</body>
</html>