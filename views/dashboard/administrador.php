<?php
// =========================
// SESIÓN
// =========================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =========================
// SEGURIDAD
// =========================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administracion') {
    header("Location: ../auth/login.php");
    exit();
}

// =========================
// CONTROLADORES
// =========================
require_once '../../controllers/AuthController.php';
require_once '../../controllers/ClientesController.php';
require_once '../../controllers/PlanesController.php';
require_once '../../controllers/TicketsController.php';

// =========================
// MENSAJES
// =========================
$mensaje = "";

// =========================
// REGISTRO USUARIO
// =========================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {

    $auth = new AuthController();

    $res = $auth->register($_POST, $_FILES);

    if ($res === "success") {

        $mensaje = "
        <div class='alert-success'>
            ¡Usuario registrado con éxito!
        </div>";

    } else {

        $mensaje = "
        <div class='alert-error'>
            Error: $res
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>ZULCOM - Panel de Control</title>

    <!-- SOLO CSS GLOBAL -->
    <link rel="stylesheet" href="/zulcom/public/css/styles.css">

</head>

<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <?php include '../partials/navadministrador.php'; ?>

    <!-- MAIN -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="content-header">

            <div class="header-left">

                <h1>PANEL DE CONTROL</h1>

            </div>

            <div class="user-actions">

                <span class="user-name">

                    Administrador:
                    <?php echo $_SESSION['nombres']; ?>

                </span>

                <a href="../../logout.php"
                   class="logout-btn"
                   onclick="return confirm('¿Cerrar sesión?')">

                    Cerrar Sesión

                </a>

            </div>

        </header>

        <!-- CONTENIDO -->
        <div class="dashboard-content">

            <?php

            $page = $_GET['page'] ?? 'inicio';

            switch ($page) {

                // =========================
                // INICIO
                // =========================
                case 'inicio':

                    echo "<h3>Bienvenido al Sistema de Gestión Zulcom</h3>";
                    echo "<p>Selecciona una opción en el menú lateral para gestionar el sistema.</p>";

                break;

                // =========================
                // REGISTRO
                // =========================
                case 'registrar':

                    echo $mensaje;

                    define('ACCESO_PERMITIDO', true);

                    include '../auth/register.php';

                break;

                // =========================
                // CLIENTES
                // =========================
                case 'ver_clientes':

                    include '../clientes/index.php';

                break;

                case 'crear_cliente':

                    include '../clientes/create.php';

                break;

                case 'editar_cliente':

                    include '../clientes/edit.php';

                break;

                // =========================
                // PLANES
                // =========================
                case 'ver_planes':

                    include '../planes/index.php';

                break;

                case 'crear_plan':

                    include '../planes/create.php';

                break;

                case 'editar_plan':

                    include '../planes/edit.php';

                break;

                // =========================
                // TICKETS
                // =========================
                case 'ver_tickets':

                    include '../tickets/index.php';

                break;

                case 'crear_ticket':

                    include '../tickets/create.php';

                break;

                case 'editar_ticket':

                    include '../tickets/edit.php';

                break;

                case 'ver_ticket':

                    include '../tickets/ver_ticket.php';

                break;

                // =========================
                // TÉCNICO
                // =========================
                case 'tecnico_tickets':

                    include '../tecnico/index.php';

                break;

                case 'resolver_ticket':

                    include '../tecnico/resolver.php';

                break;

                // =========================
                // ROLES DE PAGO
                // =========================
                case 'crear_rol':

                    include '../rolespago/roles_pago.php';

                break;

                case 'ver_roles':

                    include '../rolespago/listar_roles.php';

                break;

                // =========================
                // DEFAULT
                // =========================
                default:

                    echo "<h3>Página no encontrada</h3>";
                    echo "<p>La opción solicitada no existe.</p>";

                break;
            }

            ?>

        </div>

    </main>

</div>

</body>
</html>