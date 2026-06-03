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
<input type="text" class="form-control" name="periodo" id="periodo" readonly>
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
    asignarPeriodo();
});
</script>