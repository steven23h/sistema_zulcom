<?php

require_once '../../controllers/RolPagoController.php';

$controller = new RolPagoController();

$roles = $controller->listarRolesPago();
$colaboradores = $controller->listarColaboradores();

?>

<link rel="stylesheet" href="/zulcom2/css/styles.css">
<link rel="stylesheet" href="../../public/css/navbar.css">

<div class="dashboard-content">

    <div class="header-seccion">
        <div>
            <h2>Listado de Roles de Pago</h2>
            <p>
                Consulta, filtra y administra los roles de pago generados.
            </p>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="container-form">

       <div class="filtros-grid">

            <div class="form-group">
                <label>Colaborador</label>
                <select id="filtro_colaborador" class="form-control">
                    <option value="">Todos</option>

                    <?php foreach ($colaboradores as $c): ?>
                        <option value="<?= $c['id_trabajador'] ?>">
                            <?= htmlspecialchars($c['nombres'] . ' ' . $c['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

        <div class="form-group">
                <label>Mes</label>
                <input
                    type="month"
                    id="filtro_mes"
                    class="form-control">
            </div>

       <div>
                <button
                    onclick="filtrarRoles()"
                    class="btn-filtrar">
                    Filtrar
                </button>
            </div>

        </div>

    </div>

    <!-- TABLA -->
    <div class="table-container">

        <table class="zulcom-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Periodo</th>
                    <th>Salario</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody id="tablaRoles"></tbody>

        </table>

    </div>

</div>

<script>
    window.roles = <?= json_encode($roles) ?>;
</script>

<script src="/zulcom2/public/js/rolespago.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        cargarListadoRoles();
    });
</script>