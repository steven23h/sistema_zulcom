<?php
// 1. Gestión de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Bloqueo de seguridad: Solo permite el acceso al rol 'User'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'User') {
    header("Location: ../auth/login.php");
    exit();
}

// 3. Variables de sesión para la vista
$nombreUsuario = $_SESSION['nombres'] . " " . $_SESSION['apellidos'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ZULCOM - Panel de Usuario</title>
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include '../partials/navuser.php'; ?>

        <main class="main-content">
            <header class="content-header">
                <h1>ÁREA DE CLIENTE</h1>
                <div class="user-actions">
                    <span class="user-name">Hola, <?php echo $_SESSION['nombres']; ?></span>
                    <a href="../../logout.php" class="logout-btn" onclick="return confirm('¿Desea salir del sistema?')">Cerrar Sesión</a>
                </div>
            </header>

            <div class="dashboard-content" style="background:#fff; padding:30px; border-radius:8px; min-height:500px; margin-top:20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <?php 
                $page = isset($_GET['page']) ? $_GET['page'] : 'inicio';

                switch ($page) {
                    case 'mis_planes':
                        echo "<h3>Mis Planes y Servicios</h3>";
                        echo "<p>Aquí puedes revisar el estado de tu conexión y velocidad contratada.</p>";
                        break;

                    case 'soporte_ticket':
                        echo "<h3>Centro de Ayuda</h3>";
                        echo "<p>Si tienes inconvenientes con tu servicio, abre un ticket técnico aquí.</p>";
                        break;

                    case 'pagos':
                        echo "<h3>Historial de Facturación</h3>";
                        echo "<p>Consulta tus facturas pendientes y pagos realizados.</p>";
                        break;

                    default:
                        echo "<h3>Bienvenido a Zulcom, " . $_SESSION['nombres'] . "</h3>";
                        echo "<p>Desde este panel puedes gestionar todos tus servicios de internet y soporte.</p>";
                        // Aquí podrías agregar tarjetas informativas rápidas
                        break;
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>