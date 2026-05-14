<?php
require_once '../../controllers/AuthController.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $auth = new AuthController();

    $user = trim($_POST['username'] ?? "");
    $pass = trim($_POST['password'] ?? "");

    if (!empty($user) && !empty($pass)) {

        $res = $auth->login($user, $pass);

        if ($res !== true) {
            $error = ($res === false)
                ? "Credenciales incorrectas. Intente nuevamente."
                : $res;
        }

    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ZULCOM Login</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/zulcom/public/css/styles.css">

</head>

<body class="login-body">

    <!-- VIDEO OPCIONAL -->
    <!--
    <video autoplay muted loop class="bg-video">
        <source src="../../public/video/bg.mp4" type="video/mp4">
    </video>
    -->

    <div class="login-wrapper">

        <div class="glass-container">

            <h2>Inicio de Sesión</h2>

            <?php if (!empty($error)): ?>

                <div class="auth-error">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>

            <form action="login.php" method="POST">

                <div class="input-group">

                    <input 
                        type="text" 
                        name="username" 
                        required 
                        autocomplete="off"
                    >

                    <label>Usuario</label>

                </div>

                <div class="input-group">

                    <input 
                        type="password" 
                        name="password" 
                        required
                    >

                    <label>Contraseña</label>

                </div>

                <button type="submit">
                    Ingresar
                </button>

                <p class="link">

                    ¿No tienes cuenta?

                    <a href="register.php">
                        Regístrate
                    </a>

                </p>

            </form>

        </div>

    </div>

</body>

</html>