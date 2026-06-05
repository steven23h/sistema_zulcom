<link rel="stylesheet" href="../../css/styles.css">
<div class="dashboard-content">

    <div class="roles-header">
        <h2>Listado de Roles de Pago</h2>
        <p>
            Consulta, filtra y administra los roles de pago generados.
        </p>
    </div>

    <!-- FILTROS -->
    <div class="roles-filter">

        <div class="row">

            <div class="col-md-4">
                <label>Colaborador</label>
                <select id="filtro_colaborador" class="form-control"></select>
            </div>

            <div class="col-md-4">
                <label>Mes</label>
                <input type="month"
                       id="filtro_mes"
                       class="form-control">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button onclick="cargarListadoRoles()"
                        class="btn-filtrar w-100">
                    Filtrar
                </button>
            </div>

        </div>

    </div>

    <!-- TABLA -->
    <div class="roles-table-container">

        <table class="roles-table">

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

<script src="/zulcom/public/js/listadoroles.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    cargarColaboradoresFiltro();
    cargarListadoRoles();
});
</script>