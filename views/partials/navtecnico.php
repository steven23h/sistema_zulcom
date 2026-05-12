<aside class="sidebar">
    <div class="logo-container">
<<<<<<< HEAD
        <img src="../../public/img/logo.png" class="img-logo" alt="Logo Zulcom">
    </div>

    <div class="nav-section">
        <p class="nav-title">Operaciones</p>
        <ul class="nav-list">
            
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'tecnico.php') ? 'active' : ''; ?>">
                <a href="../dashboard/tecnico.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%; gap: 10px;">
                    Mis Trabajos
                </a>
            </li>

            <li class="nav-item <?php echo (strpos($_SERVER['PHP_SELF'], 'tickets') !== false) ? 'active' : ''; ?>">
                <a href="../tickets/index.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%; gap: 10px;">
                    Tickets Pendientes
                </a>
            </li>

        </ul>
    </div>

    <div class="nav-section">
        <p class="nav-title">Utilidades</p>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="#" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%; gap: 10px;">
                    Manuales Técnicos
                </a>
            </li>
        </ul>
    </div>

    
=======
        <img class="img-logo" src="../../public/img/logo.png" alt="Logo Zulcom">
    </div>

    <div class="nav-section">
        <ul class="nav-list">
           <li class="nav-item"><a href="tecnico.php">Dashboard</a></li>
           <li class="nav-item"><a href="tecnico.php?page=tecnico_tickets">Mis Tickets</a></li>
        </ul>
    </div>
>>>>>>> master
</aside>