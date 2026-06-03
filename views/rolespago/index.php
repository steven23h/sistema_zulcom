<div class="dashboard-content">

<h2 class="mb-4">Listado de Roles de Pago</h2>

<!-- =========================
     FILTROS
========================= -->
<div class="row mb-3">

<div class="col-md-4">
<label>Colaborador</label>
<select id="filtro_colaborador" class="form-control"></select>
</div>

<div class="col-md-4">
<label>Mes</label>
<input type="month" id="filtro_mes" class="form-control">
</div>

<div class="col-md-4 d-flex align-items-end">
<button onclick="cargarListadoRoles()" class="btn btn-primary w-100">
    Filtrar
</button>
</div>

</div>

<!-- =========================
     TABLA
========================= -->
<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead class="table-dark">
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
document.addEventListener("DOMContentLoaded", function() {
    cargarColaboradoresFiltro();
    cargarListadoRoles();
});
</script>