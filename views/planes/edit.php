<?php
require_once '../../controllers/PlanesController.php';
$planCtrl = new PlanesController();
$plan = $planCtrl->obtenerPorId($_GET['id']);
if (!$plan) { echo "Plan no encontrado."; exit; }
?>
<link rel="stylesheet" href="../../public/css/planes.css">

<div class="header-seccion">
    <h2>Editar Plan</h2>
</div>

<div class="form-planes">
    <form action="../../controllers/PlanesController.php" method="POST">
        <input type="hidden" name="id_plan" value="<?= $plan['id_plan'] ?>">
        <input type="hidden" name="btn_actualizar_plan" value="1">

        <div class="form-group">
            <label>Nombre del Plan</label>
            <input type="text" name="nombre_plan" value="<?= htmlspecialchars($plan['nombre_plan']) ?>" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Velocidad (Mbps)</label>
                <input type="number" name="megas" value="<?= $plan['megas'] ?>" required>
            </div>
            <div class="form-group">
                <label>Costo Mensual ($)</label>
                <input type="number" step="0.01" name="costo" value="<?= $plan['costo'] ?>" required>
            </div>
        </div>

        <button type="submit" class="btn-save">💾 Guardar Cambios</button>
        <a href="administrador.php?page=ver_planes" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none; font-size:1.1rem;">✖ Cancelar</a>
    </form>
</div>