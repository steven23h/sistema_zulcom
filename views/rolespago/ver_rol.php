<?php
require_once '../../controllers/RolPagoController.php';

$controller = new RolPagoController();
$roles = $controller->listarRolesPago();


?>

<div class="dashboard-content">
    <link rel="stylesheet" href="../../css/styles.css">
   <link rel="stylesheet" href="../../public/css/navbar.css">
    <div class="roles-header">
        <h2>Mis Roles de Pago</h2>
        <p>
            Consulta y descarga tus roles de pago generados.
        </p>
    </div>

    <div class="roles-filter">

        <div class="filter-group">
            <label>Filtrar por Mes</label>
            <input type="month" id="filtroMes">
        </div>

        <div class="filter-button">
            <button onclick="cargarMisRoles()" class="btn-filtrar">
                Buscar
            </button>
        </div>

    </div>

    <div class="roles-table-container">

        <div class="table-responsive">

            <table class="roles-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Periodo</th>
                        <th>Salario</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody id="tablaMisRoles"></tbody>

            </table>

        </div>

    </div>

</div>

<script>
window.rolesTecnico = <?= json_encode($roles) ?>;
</script>

<script src="/zulcom2/public/js/ver_roles_tecnico.js"></script>

