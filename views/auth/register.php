<?php
require_once '../../controllers/AuthController.php';

$mensaje = "";
$tipo_alerta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    if ($res === "success") {
        $mensaje = "¡Registro exitoso!";
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


<title>Registro</title>

<link rel="stylesheet" href="../../public/css/register.css">
</head>
<body>


    <!-- HEADER -->
    <div class="container-form">

        <h2>Registro</h2>
        <p id="form-desc">Tipo: <strong>Cliente</strong></p>

        <?php if(!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_alerta; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- BOTONES -->
        <div class="btn-toggle-container">
            <button type="button" class="btn-mode active" id="btn-cliente">Cliente</button>
            <button type="button" class="btn-mode" id="btn-personal">Personal</button>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="tipo_registro" id="tipo_registro" value="cliente">

            <div class="form-row">
                <input type="text" name="nombres" placeholder="Nombres" required>
                <input type="text" name="apellidos" placeholder="Apellidos" required>
            </div>

            <div class="form-row">
                <input type="text" name="cedula" maxlength="10" placeholder="Cédula" required>
                <input type="text" name="telefono" placeholder="Teléfono" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Correo" required>
            </div>

            <div class="form-group">
                <input type="text" name="domicilio" placeholder="Domicilio" required>
            </div>

            <!-- PERSONAL -->
            <div id="campos-personal" class="hidden">

                <div class="box-personal">
                    <input type="text" name="codigo_empresa" placeholder="Código Empresa">
                </div>

                <div class="form-group">
                    <select name="role">
                        <option value="Tecnico">Técnico</option>
                        <option value="Gerente">Gerente</option>
                        <option value="Administracion">Administración</option>
                    </select>
                </div>

                <div class="form-row">
                    <input type="file" name="copia_cedula">
                    <input type="file" name="record_policial">
                </div>

            </div>

            <button type="submit" name="btn_registrar" class="btn-register">
                REGISTRAR
            </button>

        </form>

    </div>

</div>

<script src="../../public/js/register.js"></script>

</body>
</html>