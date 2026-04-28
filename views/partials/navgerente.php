<aside class="sidebar">

    <div class="logo-container">
        <img src="../../public/img/logo.png" class="img-logo" alt="Logo Zulcom">
    </div>

    <div class="nav-section">
        <p class="nav-title">Menú Principal</p>

        <ul class="nav-list">

            <!-- DASHBOARD -->
            <li class="nav-item <?php echo (!isset($_GET['page'])) ? 'active' : ''; ?>">
                <a href="gerente.php">
                    Dashboard
                </a>
            </li>

            <!-- CLIENTES -->
            <li class="nav-item <?php echo ($_GET['page'] ?? '') == 'clientes' ? 'active' : ''; ?>">
                <a href="gerente.php?page=clientes">
                    Lista de Clientes
                </a>
            </li>

            <!-- REPORTES -->
            <li class="nav-item dropdown">
                <a href="#">
                    Reportes de Ventas
                </a>

                <ul class="submenu">
                    <li class="submenu-item">Reporte Diario</li>
                    <li class="submenu-item">Reporte Mensual</li>
                </ul>
            </li>

            <li class="nav-item dropdown">

                <a href="gerente.php?page=roles_pago">
                    Roles de Pago
                </a>

                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="gerente.php?page=listar_roles">
                            Listado de Roles
                        </a>
                    </li>
                </ul>

            </li>

        </ul>
    </div>

</aside>