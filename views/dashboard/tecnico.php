<?php
session_start();

// Seguridad
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Tecnico') {
    header("Location: ../auth/login.php"); 
    exit();
}

// Control de páginas
$page = $_GET['page'] ?? 'inicio';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zulcom - Técnico</title>

    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
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

                <a href="../../logout.php" class="logout-btn">
                    Cerrar Sesión
                </a>
            </div>
        </header>

        <div class="dashboard-content">

        <?php
        switch($page){

            // 🔥 MIS ROLES
            case 'mis_roles':
                include '../rolespago/ver_roles_tecnico.php';
            break;

            // 🔹 DASHBOARD POR DEFECTO
            default:
        ?>

        <div class="card" style="background-color: var(--white); padding: 25px; border-radius: 12px; border-left: 5px solid var(--purple-500); box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            
            <h3 style="margin: 0; color: var(--purple-900); font-family: var(--font-title);">
                Gestión de Instalaciones y Reparaciones
            </h3>

            <p style="color: var(--dark-gray); margin-top: 10px;">
                Bienvenido. Aquí podrás revisar tus tickets asignados, reportar instalaciones finalizadas y gestionar el mantenimiento de la red.
            </p>

        </div>

        <?php
        break;
        }
        ?>

        </div>

    </main>

</div>

</body>
</html>