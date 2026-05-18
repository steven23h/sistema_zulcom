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
        <div style='
            background:#d4edda;
            color:#155724;
            padding:15px;
            border-radius:5px;
            margin-bottom:20px;
            border:1px solid #c3e6cb;
        '>
            ¡Usuario registrado con éxito!
        </div>";

    } else {

        $mensaje = "
        <div style='
            background:#f8d7da;
            color:#721c24;
            padding:15px;
            border-radius:5px;
            margin-bottom:20px;
            border:1px solid #f5c6cb;
        '>
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

    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
    <link rel="stylesheet" href="/zulcom/public/css/styles.css">
</head>

<body>

<div class="dashboard-container">

    <!-- NAVBAR -->
    <?php include '../partials/navadministrador.php'; ?>

    <!-- CONTENIDO -->
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

        <!-- CONTENIDO DINÁMICO -->
        <div class="dashboard-content"
             style="
                background:#fff;
                padding:30px;
                border-radius:8px;
                min-height:500px;
                margin-top:20px;
                box-shadow:0 4px 6px rgba(0,0,0,0.05);
             ">

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