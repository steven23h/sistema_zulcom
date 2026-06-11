<?php
// 1. Gestión de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔥 CONTROLADORES (IGUAL QUE ADMIN PERO SOLO LO NECESARIO)
require_once '../../controllers/TicketsController.php';

// 🔒 SEGURIDAD
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Tecnico') {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ZULCOM - Panel Técnico</title>
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
    <link rel="stylesheet" href="/zulcom2/css/styles.css">
</head>

<body>
<div class="dashboard-container">

    <?php include '../partials/navtecnico.php'; ?>

    <main class="main-content">

        <header class="content-header">
            <div class="header-left">
                <h1>PANEL TÉCNICO</h1>
            </div>

            <div class="user-actions">
                <span class="user-name">
                    Técnico: <?php echo $_SESSION['nombres']; ?>
                </span>

                <a href="../../logout.php" class="logout-btn" onclick="return confirm('¿Cerrar sesión?')">
                    Cerrar Sesión
                </a>
            </div>
        </header>

        <div class="card">
            
            <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'inicio';

            switch ($page) {

                // 🔥 LISTADO DE TICKETS DEL TECNICO
                case 'tecnico_tickets':
                    include '../tecnico/index.php';
                break;
                case 'historial_tickets':
        include '../tecnico/historial.php'; // Aquí cargaremos el nuevo diseño limpio
        break; 
        case 'ver_ticket':
                include '../Tickets/ver_ticket.php';
                break;

                // 🔥 RESOLVER TICKET
                case 'resolver_ticket':
                    include '../tecnico/resolver.php';
                break;
                case 'coordenadas_clientes':
        include '../tecnico/coordenadas_clientes.php';
        break;
                 // 🔥 MIS ROLES
            case 'mis_roles':
                include '../rolespago/ver_rol.php';
            break;


                // 🔥 DEFAULT
                default:
                    echo "<h3>Bienvenido Técnico</h3>";
                    echo "<p>Aquí podrás ver y gestionar tus tickets asignados.</p>";
                break;
            }
            ?>

        </div>

    </main>

</div>
</body>
</html>
