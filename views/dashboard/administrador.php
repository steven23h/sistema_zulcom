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

// 3. Controladores
require_once '../../controllers/ClientesController.php';
require_once '../../controllers/PlanesController.php';
require_once '../../controllers/TicketsController.php';
require_once '../../controllers/AuthController.php';

// 4. Lógica registro usuario
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {

    $auth = new AuthController();

    $res = $auth->register($_POST, $_FILES);

    if ($res === "success") {

        $mensaje = "<div class='alert success'>
                        ¡Usuario registrado con éxito!
                     </div>";
    } else {

        $mensaje = "<div class='alert error'>
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

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/zulcom2/public/css/styles.css">

    <!-- CSS EXTRA -->
    <link rel="stylesheet" href="/zulcom2/public/css/navbar.css">
    <link rel="stylesheet" href="/zulcom2/public/css/dashboard.css">

</head>

<body>

    <div class="dashboard-container">

        <?php include '../partials/navadministrador.php'; ?>

        <main class="main-content">

            <header class="content-header">

                <h1>PANEL DE CONTROL</h1>

                <div class="user-actions">

                    <span class="user-name">

                        Administrador:
                        <?php echo $_SESSION['nombres']; ?>

                    </span>

                    <a href="../../logout.php"
                        class="btn-logout"
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
                        define('ACCESO_PERMITIDO', true);
                        include '../auth/register.php';
                        break;

                    case 'ver_clientes':
                        include '../clientes/index.php';
                        break;

                    case 'crear_cliente':
                        include '../clientes/create.php';
                        break;

                    case 'editar_cliente':
                        include '../clientes/edit.php';
                        break;
                    case 'clientes_deudores':
                        include '../clientes/deudores.php';
                        break;

                    case 'clientes_nodeudores':
                        include '../clientes/pagados.php';
                        break;

                    case 'ver_planes':
                        include '../planes/index.php';
                        break;

                    case 'crear_plan':
                        include '../planes/create.php';
                        break;
                    case 'editar_plan':
                        include '../planes/edit.php';
                        break;
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
                    case 'tecnico_tickets':
                        include '../tecnico/index.php';
                        break;

                    case 'resolver_ticket':
                        include '../tecnico/resolver.php';
                        break;
                    case 'crear_factura':
                        include '../facturas/create.php';
                        break;

                    case 'ver_roles':
                        include '../rolespago/index.php';
                        break;

                    case 'crear_rol':
                        include '../rolespago/create.php';
                        break;

                    case 'ver_rol':
                        include '../rolespago/ver_rol.php';
                        break;

                    default:
                        echo "<h3>Bienvenido al Sistema Zulcom</h3>";
                        echo "<p>Seleccione1 una opción del menú lateral para gestionar el sistema.</p>";
                        break;
                }
                ?>




            </div>

        </main>

    </div>

</body>

</html>