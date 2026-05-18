<div class="dashboard-content">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="page-header">

        <div>
            <h2 class="page-title">
                📄 Mis Roles de Pago
            </h2>

            <p class="page-subtitle">
                Consulta y descarga tus roles de pago generados.
            </p>
        </div>

    </div>

    <!-- ===================================================== -->
    <!-- CARD TABLA -->
    <!-- ===================================================== -->

    <div class="roles-table-card">

        <!-- ===================================================== -->
        <!-- FILTROS -->
        <!-- ===================================================== -->

        <div class="roles-filters">

            <!-- COLABORADOR -->

            <div class="roles-filter-group">

                <label for="filtro_colaborador">
                    Colaborador
                </label>

                <select id="filtro_colaborador">

                    <option value="">
                        Todos
                    </option>

                </select>

            </div>

            <!-- MES -->

            <div class="roles-filter-group">

                <label for="filtro_mes">
                    Filtrar por mes
                </label>

                <input 
                    type="month"
                    id="filtro_mes"
                >

            </div>

            <!-- BOTÓN -->

            <div class="roles-filter-btn">

                <button 
                    onclick="cargarListadoRoles()"
                    class="btn-filter"
                >

                    🔍 Filtrar

                </button>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- TABLA -->
        <!-- ===================================================== -->

        <div class="roles-table-wrapper">

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

                <tbody id="tablaRoles">

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="/zulcom/public/js/listadoroles.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    cargarColaboradoresFiltro();

    cargarListadoRoles();

});

</script>