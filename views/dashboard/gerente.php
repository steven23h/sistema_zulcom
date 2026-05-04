<?php
session_start();

// Seguridad
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Gerente') {
    header("Location: ../auth/login.php"); 
    exit();
}

$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="es">
<head>
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

</body>
</html>