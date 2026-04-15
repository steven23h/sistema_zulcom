<?php
/**
 * VISTA DE REGISTRO - ZULCOM
 */
require_once '../../controllers/AuthController.php';

$mensaje = "";
$tipo_alerta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    if ($res === "success") {
        $mensaje = "¡Registro exitoso! Redirigiendo al inicio de sesión...";
        $tipo_alerta = "success";
        // Redirige al login después de 2 segundos para que el usuario vea el éxito
        header("refresh:2;url=login.php");
    } else {
        // Aquí se captura el mensaje "Código de empresa incorrecto" que definimos en el controlador
        $mensaje = $res;
        $tipo_alerta = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/auth.css">
    <style>
        .hidden { display: none; }
        .btn-toggle-container { margin-bottom: 20px; display: flex; gap: 10px; }
        .btn-mode { 
            flex: 1; padding: 10px; cursor: pointer; border: 2px solid #7d5fff; 
            background: #fff; color: #7d5fff; border-radius: 5px; font-weight: bold;
        }
        .btn-mode.active { background: #7d5fff; color: #fff; }
        
        /* Estilos para las alertas */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body class="auth-page">
    <div class="card-form" style="width: 100%; max-width: 600px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333; margin: 0;">Registro de Usuario</h2>
        <p id="form-desc" style="color: #666; margin-bottom: 20px;">Tipo de cuenta: <strong>Persona Natural (Cliente)</strong></p>
        
        <?php if(!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_alerta; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="btn-toggle-container">
            <button type="button" class="btn-mode active" id="btn-cliente" onclick="toggleForm('cliente')">Soy Cliente</button>
            <button type="button" class="btn-mode" id="btn-personal" onclick="toggleForm('personal')">Personal Empresa</button>
        </div>

        <hr><br>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="tipo_registro" id="tipo_registro" value="cliente">

            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label>Nombres</label>
                    <input type="text" name="nombres" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="flex: 1;">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label>Cédula (10 dígitos)</label>
                    <input type="text" name="cedula" required pattern="[0-9]{10}" maxlength="10" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="flex: 1;">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Correo Electrónico</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Domicilio</label>
                <input type="text" name="domicilio" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div id="campos-personal" class="hidden">
                <div style="margin-bottom: 15px; background: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 5px solid #7d5fff;">
                    <label><strong>Código Único de Empresa</strong></label>
                    <input type="text" name="codigo_empresa" id="codigo_empresa" placeholder="Ingrese código de validación" style="width: 100%; padding: 10px; border: 1px solid #7d5fff; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Rol de Usuario</label>
                    <select name="role" id="role" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="Tecnico">Técnico</option>
                        <option value="Gerente">Gerente</option>
                        <option value="Administracion">Administración</option>
                    </select>
                </div>

                <div style="display: flex; gap: 20px; margin-bottom: 25px;">
                    <div style="flex: 1;">
                        <label>Copia Cédula (PDF)</label>
                        <input type="file" name="copia_cedula" id="file1" accept=".pdf">
                    </div>
                    <div style="flex: 1;">
                        <label>Récord Policial (PDF)</label>
                        <input type="file" name="record_policial" id="file2" accept=".pdf">
                    </div>
                </div>
            </div>

            <button type="submit" name="btn_registrar" style="width: 100%; padding: 12px; background: #7d5fff; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                REGISTRAR AHORA
            </button>
        </form>
    </div>

    <script>
    function toggleForm(tipo) {
        const camposPersonal = document.getElementById('campos-personal');
        const desc = document.getElementById('form-desc');
        const inputTipo = document.getElementById('tipo_registro');
        const btnCliente = document.getElementById('btn-cliente');
        const btnPersonal = document.getElementById('btn-personal');
        const codigoEmpresa = document.getElementById('codigo_empresa');
        const file1 = document.getElementById('file1');
        const file2 = document.getElementById('file2');

        if (tipo === 'personal') {
            camposPersonal.classList.remove('hidden');
            desc.innerHTML = "Tipo de cuenta: <strong>Personal Administrativo / Técnico</strong>";
            inputTipo.value = "personal";
            btnPersonal.classList.add('active');
            btnCliente.classList.remove('active');
            codigoEmpresa.required = true;
            file1.required = true;
            file2.required = true;
        } else {
            camposPersonal.classList.add('hidden');
            desc.innerHTML = "Tipo de cuenta: <strong>Persona Natural (Cliente)</strong>";
            inputTipo.value = "cliente";
            btnCliente.classList.add('active');
            btnPersonal.classList.remove('active');
            codigoEmpresa.required = false;
            file1.required = false;
            file2.required = false;
        }
    }
    </script>
</body>
</html>