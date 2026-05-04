<div class="dashboard-content">

<h2 class="mb-4">Mis Roles de Pago</h2>

<!-- FILTRO -->
<div class="row mb-3">

<div class="col-md-6">
<label>Filtrar por mes</label>
<input type="month" id="filtro_mes" class="form-control">
</div>

<div class="col-md-6 d-flex align-items-end">
<button onclick="cargarMisRoles()" class="btn btn-primary w-100">
Filtrar
</button>
</div>

</div>

<!-- TABLA -->
<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead class="table-dark">
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

<script src="/zulcom/public/js/ver_roles.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    cargarMisRoles();
});
</script>