<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<div class="content-card">

    <div class="card-header">

        <h2 class="section-title">
            Mis Roles de Pago
        </h2>

    </div>

    <div class="table-responsive">

        <table class="data-table">

            <thead>

                <tr>
                    <th>#</th>
                    <th>Periodo</th>
                    <th>Salario</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>PDF</th>
                </tr>

            </thead>

            <tbody id="tablaMisRoles">

                <tr>
                    <td colspan="6">
                        Cargando roles...
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

<script src="/zulcom/public/js/ver_roles.js"></script>

<script>

document.addEventListener("DOMContentLoaded", () => {

    cargarMisRoles();

});

</script>