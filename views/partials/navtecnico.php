<aside class="sidebar">

    <div class="logo-container">
        <img src="../../public/img/logo.png" class="img-logo" alt="Logo Zulcom">
    </div>

    <div class="nav-section">

        <p class="nav-title">Operaciones</p>

        <ul class="nav-list">

            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'tecnico.php') ? 'active' : ''; ?>">
                <a href="../dashboard/tecnico.php">
                    Mis Trabajos
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($_SERVER['PHP_SELF'], 'tickets') !== false) ? 'active' : ''; ?>">
                <a href="../tickets/index.php">
                    Tickets Pendientes
                </a>
            </li>

            <!-- VER ROLES -->
            <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'ver_roles_pago') !== false) ? 'active' : ''; ?>">
                <a href="../dashboard/tecnico.php?page=ver_roles_pago">
                    Ver Roles de Pago
                </a>
            </li>

        </ul>

    </div>

    <div class="nav-section">

        <p class="nav-title">Utilidades</p>

        <ul class="nav-list">

            <li class="nav-item">
                <a href="#">
                    Manuales Técnicos
                </a>
            </li>

        </ul>

    </div>

</aside>