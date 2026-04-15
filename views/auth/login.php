<?php
require_once '../../controllers/AuthController.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new AuthController();
    
    $userInput = isset($_POST['username']) ? trim($_POST['username']) : "";
    $passInput = isset($_POST['password']) ? trim($_POST['password']) : "";

    if (!empty($userInput) && !empty($passInput)) {
        // Intentamos el login
        $resultado = $auth->login($userInput, $passInput);
        
        // Si el resultado no es true, significa que hubo un error
        if ($resultado !== true) {
            // Si tu controlador devuelve un mensaje específico lo capturamos, 
            // de lo contrario usamos uno por defecto.
            $error = ($resultado === false) ? "Credenciales incorrectas. Intente de nuevo." : $resultado;
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
    <title>Zulcom - Login</title>
    <link rel="stylesheet" href="../../public/css/auth.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Inicio de Sesión</h2>
            </div>
            <div class="auth-body">
                
                <?php if(!empty($error)): ?>
                    <div class="auth-error" style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #f5c6cb; text-align: center;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" name="username" id="username" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <button type="submit" class="auth-button">Entrar al Sistema</button>
                </form>
            </div>
            
            <div class="auth-footer" style="text-align: center; margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                <p>¿No tienes una cuenta?</p>
                <a href="register.php" class="auth-link-button" style="color: #7d5fff; text-decoration: none; font-weight: bold;">Regístrate aquí</a>
            </div>
        </div>
    </div>
</body>
</html>