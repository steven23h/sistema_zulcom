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

// 4. Lógica registro usuario (Patrón PRG)
$mensaje = "";

// Cargar el mensaje de éxito si existe en la sesión tras la redirección
if (isset($_SESSION['registro_exito_msg'])) {
    $mensaje = $_SESSION['registro_exito_msg'];
    unset($_SESSION['registro_exito_msg']); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_registrar'])) {
    $auth = new AuthController();
    $res = $auth->register($_POST, $_FILES);

    if ($res === "success_admin" || $res === "success") {
        // Almacenamos el mensaje verde estructurado dentro de la sesión
        $_SESSION['registro_exito_msg'] = "<div class='alert success' style='background-color: #d4edda; color: #155724; padding: 15px; margin: 15px auto; border-radius: 5px; font-weight: bold; text-align: center; max-width: 600px; border: 1px solid #c3e6cb;'>
                                            ¡Usuario registrado con éxito! El colaborador ha sido creado correctamente.
                                           </div>";
        
        // Redirección inmediata para destruir el $_POST y evitar la duplicación errónea
        header("Location: administrador.php?page=registrar");
        exit();
    } elseif ($res === "success_login") {
        $path = ($_SESSION['role'] === 'Administracion') ? 'administrador.php' : strtolower($_SESSION['role']) . '.php';
        header("Location: " . $path);
        exit();
    } else {
        // En caso de duplicados reales, pintamos la alerta roja sin redireccionar
        $mensaje = "<div class='alert error' style='background-color: #f8d7da; color: #721c24; padding: 15px; margin: 15px auto; border-radius: 5px; font-weight: bold; text-align: center; max-width: 600px; border: 1px solid #f5c6cb;'>
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
                        Administrador: <?php echo htmlspecialchars($_SESSION['nombres'], ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                    <a href="../../logout.php" class="logout-btn" onclick="return confirm('¿Cerrar sesión?')">
                        Cerrar Sesión
                    </a>
                </div>
            </header>

            <div class="card">
                
                <?php if (!empty($mensaje)) echo $mensaje; ?>

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
                        echo "<p>Seleccione una opción del menú lateral para gestionar el sistema.</p>";
                        break;
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>