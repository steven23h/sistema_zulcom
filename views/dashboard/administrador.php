<?php
// 1. Gestión de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Bloqueo de seguridad
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administracion') {
    header("Location: ../auth/login.php");
    exit();
}

// 3. Controladores y Lógica
require_once '../../controllers/AuthController.php';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    if ($res === "success") {
        $mensaje = "<div class='alert success'>¡Usuario registrado con éxito!</div>";
    } else {
        $mensaje = "<div class='alert error'>Error: $res</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ZULCOM - Panel de Control</title>

    <!-- ✅ SOLO UN CSS GLOBAL -->
    <link rel="stylesheet" href="/zulcom/css/styles.css">
</head>

<body>
    <div class="dashboard-container">

        <?php include '../partials/navadministrador.php'; ?>

        <main class="main-content">
            <header class="content-header">
                <h1>PANEL DE CONTROL</h1>

                <div class="user-actions">
                    <span class="user-name">
                        Administrador: <?php echo $_SESSION['nombres']; ?>
                    </span>

                    <a href="../../logout.php" class="btn-logout"
                       onclick="return confirm('¿Cerrar sesión?')">
                       Cerrar Sesión
                    </a>
                </div>
            </header>

            <div class="card">

                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'inicio';

                switch ($page) {

                    case 'registrar':
                        echo $mensaje;
                        define('ACCESO_PERMITIDO', true);
                        include '../auth/register.php';
                        break;

                    case 'ver_planes':
                        include '../planes/index.php';
                        break;

                    case 'crear_plan':
                        include '../planes/create.php';
                        break;

                    case 'ver_roles':
                        include '../rolespago/ver_roles.php';
                        break;

                    default:
                        echo "<h3>Bienvenido al Sistema de Gestión Zulcom</h3>";
                        echo "<p>Selecciona una opción en el menú lateral para gestionar el sistema.</p>";
                        break;
                }
                ?>

            </div>
        </main>
    </div>
</body>

</html>