<?php

require_once '../../controllers/AuthController.php';

$mensaje = "";
$tipo_alerta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {

    $auth = new AuthController();

    $res = $auth->register($_POST, $_FILES);

    if ($res === "success") {

        $mensaje = "¡Registro exitoso! Redirigiendo al inicio de sesión...";
        $tipo_alerta = "success";

        header("refresh:2;url=login.php");

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro - ZULCOM</title>

    <link rel="stylesheet" href="/zulcom/public/css/auth.css">

    <style>

        .hidden {
            display: none;
        }

        .btn-toggle-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-mode {
            flex: 1;

            padding: 12px;

            cursor: pointer;

            border: 2px solid #7d5fff;

            background: #fff;
            color: #7d5fff;

            border-radius: 6px;

            font-weight: bold;

            transition: 0.3s;
        }

        .btn-mode.active {
            background: #7d5fff;
            color: #fff;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;

            border-radius: 6px;

            text-align: center;
            font-weight: bold;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

    </style>

</head>

<body class="auth-page">

<div class="card-form"
     style="
        width:100%;
        max-width:700px;
        margin:40px auto;
        background:#fff;
        padding:30px;
        border-radius:10px;
        box-shadow:0 4px 10px rgba(0,0,0,0.1);
     ">

    <h2 style="margin-bottom:10px;">
        Registro de Usuario
    </h2>

    <p id="form-desc"
       style="margin-bottom:20px;color:#666;">

        Tipo de cuenta:
        <strong>Persona Natural (Cliente)</strong>

    </p>

    <?php if (!empty($mensaje)): ?>

        <div class="alert alert-<?php echo $tipo_alerta; ?>">

            <?php echo $mensaje; ?>

        </div>

    <?php endif; ?>

    <!-- BOTONES -->
    <div class="btn-toggle-container">

        <button type="button"
                class="btn-mode active"
                id="btn-cliente"
                onclick="toggleForm('cliente')">

            Soy Cliente

        </button>

        <button type="button"
                class="btn-mode"
                id="btn-personal"
                onclick="toggleForm('personal')">

            Personal Empresa

        </button>

    </div>

    <hr style="margin-bottom:25px;">

    <!-- FORM -->
    <form method="POST"
          enctype="multipart/form-data">

        <input type="hidden"
               name="tipo_registro"
               id="tipo_registro"
               value="cliente">

        <!-- FILA -->
        <div class="form-row">

            <input type="text"
                   name="nombres"
                   placeholder="Nombres"
                   required>

            <input type="text"
                   name="apellidos"
                   placeholder="Apellidos"
                   required>

        </div>

        <!-- FILA -->
        <div class="form-row">

            <input type="text"
                   name="cedula"
                   placeholder="Cédula"
                   maxlength="10"
                   pattern="[0-9]{10}"
                   required>

            <input type="text"
                   name="telefono"
                   placeholder="Teléfono"
                   required>

        </div>

        <!-- EMAIL -->
        <div class="form-group">

            <input type="email"
                   name="email"
                   placeholder="Correo Electrónico"
                   required>

        </div>

        <!-- DOMICILIO -->
        <div class="form-group">

            <input type="text"
                   name="domicilio"
                   placeholder="Domicilio"
                   required>

        </div>

        <!-- PERSONAL -->
        <div id="campos-personal" class="hidden">

            <div class="box-personal">

                <input type="text"
                       name="codigo_empresa"
                       id="codigo_empresa"
                       placeholder="Código Empresa">

            </div>

            <div class="form-group">

                <select name="role" id="role">

                    <option value="Tecnico">
                        Técnico
                    </option>

                    <option value="Gerente">
                        Gerente
                    </option>

                    <option value="Administracion">
                        Administración
                    </option>

                </select>

            </div>

            <div class="form-row">

                <input type="file"
                       name="copia_cedula"
                       id="file1"
                       accept=".pdf">

                <input type="file"
                       name="record_policial"
                       id="file2"
                       accept=".pdf">

            </div>

        </div>

        <!-- BOTÓN -->
        <button type="submit"
                name="btn_registrar"
                class="btn-register">

            REGISTRAR

        </button>

    </form>

</div>

<!-- SCRIPT -->
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

        desc.innerHTML =
            "Tipo de cuenta: <strong>Personal Administrativo / Técnico</strong>";

        inputTipo.value = "personal";

        btnPersonal.classList.add('active');

        btnCliente.classList.remove('active');

        codigoEmpresa.required = true;

        file1.required = true;

        file2.required = true;

    } else {

        camposPersonal.classList.add('hidden');

        desc.innerHTML =
            "Tipo de cuenta: <strong>Persona Natural (Cliente)</strong>";

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