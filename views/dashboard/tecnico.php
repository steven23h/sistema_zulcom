<?php
session_start();

// 🔒 SEGURIDAD: Solo técnicos
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Tecnico') {
    header("Location: ../auth/login.php");
    exit();
}

// 🔥 CONTROLADORES
require_once '../../controllers/TicketsController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>ZULCOM - Panel Técnico</title>
</head>

<body>

<div class="dashboard-container">

    <?php include '../partials/navtecnico.php'; ?>

    <main class="main-content">

        <!-- HEADER -->
        <header class="content-header">

            <div class="header-left">
                <h1>PANEL TÉCNICO</h1>
            </div>

            <div class="user-actions">

                <span class="user-name">
                    Técnico: <?php echo htmlspecialchars($_SESSION['nombres']); ?>
                </span>

                <a href="../../logout.php" 
                   onclick="return confirm('¿Cerrar sesión?')">
                    Cerrar Sesión
                </a>

            </div>

        </header>

        <!-- CONTENIDO -->
        <div class="dashboard-content">

            <?php

            $page = isset($_GET['page']) ? $_GET['page'] : 'inicio';

            switch ($page) {

                // 🔥 LISTADO DE TICKETS
                case 'tecnico_tickets':
                    include '../tecnico/index.php';
                break;

                // 🔥 RESOLVER TICKET
                case 'resolver_ticket':
                    include '../tecnico/resolver.php';
                break;

                // 🔥 PANTALLA PRINCIPAL
                default:
            ?>

                <div>

                    <h3>
                        Gestión de Instalaciones y Reparaciones
                    </h3>

                    <p>
                        Bienvenido. Aquí podrás revisar tus tickets asignados,
                        reportar instalaciones finalizadas y gestionar
                        el mantenimiento de la red.
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