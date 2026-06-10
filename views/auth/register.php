<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensaje_local = "";

// Solo procesa este bloque si se accede desde el login público (fuera del panel de administración)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar']) && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administracion')) {
    
    require_once '../../controllers/AuthController.php';
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    if ($res === "success_login" || $res === "success") {
        $path = ($_SESSION['role'] === 'Administracion') ? 'administrador.php' : strtolower($_SESSION['role']) . '.php';
        header("Location: ../dashboard/" . $path);
        exit();
    } else {
        $mensaje_local = "<div class='alert error' style='background-color: #f8d7da; color: #721c24; padding: 15px; margin: 15px auto; border-radius: 5px; font-weight: bold; text-align: center;'>Error: $res</div>";
    }
}
?>

<div class="container-form">
    
    <?php if(!empty($mensaje_local)) echo $mensaje_local; ?>

    <form method="POST" enctype="multipart/form-data" id="main-form">
        <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
            <input type="text" name="nombres" placeholder="Nombres" required style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="<?php echo (isset($res) && $res !== 'success_admin' && $res !== 'success' && $res !== 'success_login') ? htmlspecialchars($_POST['nombres']) : ''; ?>">
            <input type="text" name="apellidos" placeholder="Apellidos" required style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="<?php echo (isset($res) && $res !== 'success_admin' && $res !== 'success' && $res !== 'success_login') ? htmlspecialchars($_POST['apellidos']) : ''; ?>">
        </div>

        <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
            <input type="text" name="cedula" pattern="[0-9]{10}" maxlength="10" title="La cédula debe tener exactamente 10 dígitos numéricos" placeholder="Cédula" required style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="<?php echo (isset($res) && $res !== 'success_admin' && $res !== 'success' && $res !== 'success_login') ? htmlspecialchars($_POST['cedula']) : ''; ?>">
            <input type="text" name="telefono" placeholder="Teléfono" required style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" value="<?php echo (isset($res) && $res !== 'success_admin' && $res !== 'success' && $res !== 'success_login') ? htmlspecialchars($_POST['telefono']) : ''; ?>">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <input type="email" name="email" placeholder="Correo electrónico" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" value="<?php echo (isset($res) && $res !== 'success_admin' && $res !== 'success' && $res !== 'success_login') ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <input type="text" name="domicilio" placeholder="Domicilio" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" value="<?php echo (isset($res) && $res !== 'success_admin' && $res !== 'success' && $res !== 'success_login') ? htmlspecialchars($_POST['domicilio']) : ''; ?>">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <input type="text" name="codigo_empresa" placeholder="Código Empresa" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <select name="role" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                <option value="Tecnico">Técnico</option>
                <option value="Administracion">Administración</option>
            </select>
        </div>

        <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1; text-align: left;">
                <span style="font-size: 12px; color: #555; display: block; margin-bottom: 4px; font-weight: bold;">Copia de Cédula (PDF):</span>
                <input type="file" name="copia_cedula" accept=".pdf" required style="width: 100%;">
            </div>
            <div style="flex: 1; text-align: left;">
                <span style="font-size: 12px; color: #555; display: block; margin-bottom: 4px; font-weight: bold;">Récord Policial (PDF):</span>
                <input type="file" name="record_policial" accept=".pdf" required style="width: 100%;">
            </div>
        </div>

        <button type="submit" name="btn_registrar" style="width: 100%; padding: 12px; background-color: #3b2a82; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 14px; margin-top: 15px;">
            REGISTRAR
        </button>
    </form>
</div>