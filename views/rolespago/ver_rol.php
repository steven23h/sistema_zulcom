<?php
require_once '../../controllers/RolPagoController.php';

$controller = new RolPagoController();
$roles = $controller->listarRolesPago();


?>

<div class="dashboard-content">
    <link rel="stylesheet" href="../../css/styles.css">
   <link rel="stylesheet" href="../../public/css/navbar.css">
    <div class="header-seccion">
        <h2>Mis Roles de Pago</h2>
        
    </div>

   <div class="container-form">
<div class="container-form">

    <div class="filtros-grid">

        <div class="form-group">
            <label>Filtrar por Mes</label>
            <input type="month" id="filtroMes">
        </div>

        <div>
            <button onclick="cargarMisRoles()" class="btn-filtrar">
                Buscar
            </button>
        </div>

    </div>

</div>
        

<div class="table-container">

        <div class="table-responsive">

           <table class="zulcom-table">

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

<script src="/zulcom2/public/js/rolespago.js"></script>

