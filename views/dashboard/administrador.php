<?php
// 1. Gestión de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
<<<<<<< HEAD

=======
require_once '../../controllers/ClientesController.php';
require_once '../../controllers/PlanesController.php';
require_once '../../controllers/TicketsController.php';
 // Se agrega para que las acciones de planes funcionen
>>>>>>> master
// 2. Bloqueo de seguridad
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administracion') {
    header("Location: ../auth/login.php");
    exit();
}
<<<<<<< HEAD

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

=======
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ZULCOM - Panel de Control</title>
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
>>>>>>> master
        <?php include '../partials/navadministrador.php'; ?>

        <main class="main-content">
            <header class="content-header">
<<<<<<< HEAD
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

=======
                <div class="header-left">
                    <h1>PANEL DE CONTROL</h1>
                </div>
                <div class="user-actions">
                    <span class="user-name">Administrador: <?php echo $_SESSION['nombres']; ?></span>
                    <a href="../../logout.php" class="logout-btn" onclick="return confirm('¿Cerrar sesión?')">Cerrar Sesión</a>
                </div>
            </header>

            <div class="dashboard-content" style="background:#fff; padding:30px; border-radius:8px; min-height:500px; margin-top:20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
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
                        
                    case 'crear_planes':
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
                    default:
                        echo "<h3>Bienvenido al Sistema Zulcom</h3>";
                        echo "<p>Seleccione1 una opción del menú lateral para gestionar el sistema.</p>";
                        break;
                }
                ?>
>>>>>>> master
            </div>
        </main>
    </div>
</body>
<<<<<<< HEAD

=======
>>>>>>> master
</html>