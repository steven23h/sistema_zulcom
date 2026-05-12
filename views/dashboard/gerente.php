<?php
session_start();
<<<<<<< HEAD

// Seguridad
=======
// Seguridad: Si no es Gerente, redirigir al login
>>>>>>> master
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Gerente') {
    header("Location: ../auth/login.php"); 
    exit();
}
<<<<<<< HEAD

$page = $_GET['page'] ?? 'dashboard';
=======
>>>>>>> master
?>
<!DOCTYPE html>
<html lang="es">
<head>
<<<<<<< HEAD
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Zulcom - Gerente</title>

<!-- ✅ SOLO CSS GLOBAL -->
<link rel="stylesheet" href="/zulcom/css/styles.css">

</head>

<body>

<div class="dashboard-container">

<?php include '../partials/navgerente.php'; ?>

<main class="main-content">

<header class="content-header">

<h1>PANEL DE SUPERVISIÓN</h1>

<div class="user-actions">
<span class="user-name">
Gerente: <?php echo htmlspecialchars($_SESSION['nombres']); ?>
</span>

<a href="../../logout.php" class="btn-logout">
Cerrar Sesión
</a>

</div>
</header>

<div class="dashboard-content">

<?php

switch($page){

    case 'roles_pago':
        include '../rolespago/roles_pago.php';
    break;

    case 'listar_roles':
        include '../rolespago/listar_roles.php';
    break;

    

    default:
?>

    <!-- ✅ SIN estilos inline -->
    <div class="card">
        <h3 class="title-card">
            Reportes de Crecimiento y Clientes
        </h3>

        <p class="text-card">
            Bienvenido al panel de gerencia. Aquí podrá supervisar las métricas de rendimiento y la lista de clientes activos.
        </p>
    </div>

<?php
}
?>

</div>

</main>
</div>

=======
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zulcom - Gerente</title>
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include '../partials/navgerente.php'; ?>

        <main class="main-content">
            
            <header class="content-header">
                <h1>PANEL DE SUPERVISIÓN</h1>
                
                <div class="user-actions">
                    <span class="user-name">
                        Gerente: <?php echo htmlspecialchars($_SESSION['nombres']); ?>
                    </span>
                    
                    <a href="../../logout.php" class="logout-btn">Cerrar Sesión</a>
                </div>
            </header>

            <div class="dashboard-content">
                <div class="card" style="background-color: var(--white); padding: 25px; border-radius: 12px; border-left: 5px solid var(--purple-500); box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <h3 style="margin: 0; color: var(--purple-900); font-family: var(--font-title);">
                        Reportes de Crecimiento y Clientes
                    </h3>
                    <p style="color: var(--dark-gray); margin-top: 10px;">
                        Bienvenido al panel de gerencia. Aquí podrá supervisar las métricas de rendimiento y la lista de clientes activos.
                    </p>
                </div>
            </div>

        </main>
    </div>
>>>>>>> master
</body>
</html>