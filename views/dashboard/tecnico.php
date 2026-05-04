<?php
// 1. Gestión de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Seguridad
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Tecnico') {
    header("Location: ../auth/login.php"); 
    exit();
}

// 3. Control de páginas
$page = $_GET['page'] ?? 'inicio';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ZULCOM - Panel Técnico</title>

    <!-- ✅ SOLO CSS GLOBAL (igual que administrador) -->
    <link rel="stylesheet" href="/zulcom/css/styles.css">
</head>

<body>

<div class="dashboard-container">

    <?php include '../partials/navtecnico.php'; ?>

    <main class="main-content">

        <header class="content-header">
            <h1>PANEL TÉCNICO</h1>

            <div class="user-actions">
                <span class="user-name">
                    Técnico: <?php echo htmlspecialchars($_SESSION['nombres']); ?>
                </span>

                <a href="../../logout.php" class="btn-logout"
                   onclick="return confirm('¿Cerrar sesión?')">
                   Cerrar Sesión
                </a>
            </div>
        </header>

        <div class="card">

        <?php
        switch($page){

            // 🔥 MIS ROLES
            case 'mis_roles':
                include '../rolespago/ver_roles_tecnico.php';
            break;

            // 🔹 DASHBOARD POR DEFECTO
            default:
                echo "<h3>Panel Técnico</h3>";
                echo "<p>Bienvenido. Aquí podrás revisar tus tickets asignados y gestionar tus actividades.</p>";
            break;
        }
        ?>

        </div>

    </main>

</div>

</body>
</html>