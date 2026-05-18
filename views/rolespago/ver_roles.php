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

        <!-- FILTROS -->

        <div class="roles-filters">

            <div class="roles-filter-group">

                <label for="filtro_mes">
                    Filtrar por mes
                </label>

                <input 
                    type="month"
                    id="filtro_mes"
                >

            </div>

            <div class="roles-filter-btn">

                <button 
                    onclick="cargarMisRoles()"
                    class="btn-filter"
                >

                    🔍 Filtrar

                </button>

            </div>

        </div>

        <!-- TABLA -->

        <div class="roles-table-wrapper">

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

                <tbody id="tablaMisRoles">

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="/zulcom/public/js/ver_roles.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    cargarMisRoles();

});

</script>