<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="dashboard-content">

<h2 class="mb-4">Gestión de Roles de Pago</h2>

<ul class="nav nav-tabs" id="rolTabs">


</ul>

<div class="tab-content mt-4">


<div class="tab-pane fade show active" id="generar">

<div class="card">
<div class="card-body">

<form id="formRol">
<div class="mb-3">
<label class="form-label">Colaborador</label>

<select id="colaborador" name="id_trabajador">
<option value="">Seleccione colaborador</option>
</select>

</div>

<div class="mb-3">
<label>Salario</label>
<input type="number" class="form-control" name="salario" required>
</div>

<div class="mb-3">
<label>Periodo</label>
<input type="text" class="form-control" name="periodo" placeholder="2025-04" required>
</div>

<div class="row">

<div class="col-md-6 mb-3">
<label>Horas Extra</label>
<input type="number" name="horas_extra" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Décimos</label>
<input type="number" name="decimos" class="form-control" value="0">
</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">
<label>Bonos</label>
<input type="number" name="bonos" class="form-control" value="0">
</div>

<div class="col-md-6 mb-3">
<label>Descuentos</label>
<input type="number" name="descuentos" class="form-control" value="0">
</div>

</div>

<button type="submit" name="crearRol" class="btn btn-primary">
Generar Rol
</button>

</form>

</div>
</div>

</div>

<!-- LISTADO -->

<div class="tab-pane fade" id="listado">

<div class="card">
<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered">

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

<tbody>

<?php
/*
foreach ($roles as $r){

echo "<tr>

<td>{$r['id']}</td>
<td>{$r['nombres']} {$r['apellidos']}</td>
<td>{$r['cargo']}</td>
<td>{$r['periodo']}</td>
<td>{$r['salario']}</td>
<td>{$r['total']}</td>
<td>{$r['estado']}</td>

<td>
<a href='../../controllers/RolPagoController.php?pdf={$r['id_trabajador']}'
class='btn btn-success btn-sm'>PDF</a>
</td>

</tr>";

}
*/
?>

</tbody>

</table>

</div>

</div>
</div>

</div>

</div>

</div>
<script src="/zulcom/public/js/rolespago.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    cargarColaboradores();
    activarFormularioRol();
});
</script>