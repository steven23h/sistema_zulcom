<aside class="sidebar">
    <div class="logo-container">
        <img src="../../public/img/logo.png" class="img-logo" alt="Logo Zulcom">
    </div>

    <div class="nav-section">
        <p class="nav-title">Menú Principal</p>
        <ul class="nav-list">

            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'gerente.php') ? 'active' : ''; ?>">
                <a href="../dashboard/gerente.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%; gap: 10px;">
                    Dashboard
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($_SERVER['PHP_SELF'], 'clientes') !== false) ? 'active' : ''; ?>">
                <a href="../clientes/index.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%; gap: 10px;">
                    Lista de Clientes
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%; gap: 10px;">
                    Reportes de Ventas
                </a>
                <ul class="submenu">
                    <li class="submenu-item">Reporte Diario</li>
                    <li class="submenu-item">Reporte Mensual</li>
                </ul>
            <li class="nav-item dropdown">

                <!-- CLICK PRINCIPAL -->
                <a href="gerente.php?page=roles_pago" style="display:flex; align-items:center; gap:10px;">
                    Roles de Pago
                </a>
                <!-- SUBMENÚ -->
                <ul class="submenu">

                    <li class="submenu-item">
                        <a href="../dashboard/gerente.php?page=listar_roles">
                            Listado de Roles
                        </a>
                    </li>

                </ul>
            </li>

    </div>


</aside>