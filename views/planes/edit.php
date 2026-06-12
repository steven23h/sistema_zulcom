<?php
require_once '../../controllers/PlanesController.php';

$planCtrl = new PlanesController();
$plan = $planCtrl->obtenerPorId($_GET['id']);

if (!$plan) {
    echo "Plan no encontrado.";
    exit;
}
?>

<div class="container-form plan-form-card">

    <h2>✏️ Editar Plan</h2>

    <form action="../../controllers/PlanesController.php" method="POST">

        <input type="hidden" name="id_plan" value="<?= $plan['id_plan'] ?>">
        <input type="hidden" name="btn_actualizar_plan" value="1">

        <div class="form-grid">

            <div class="form-group full-width">
                <label>Nombre del Plan</label>

                <input
                    type="text"
                    name="nombre_plan"
                    value="<?= htmlspecialchars($plan['nombre_plan']) ?>"
                    required>
            </div>

            <div class="form-group">
                <label>Velocidad (Mbps)</label>

                <input
                    type="number"
                    name="megas"
                    value="<?= $plan['megas'] ?>"
                    required>
            </div>

            <div class="form-group">
                <label>Costo Mensual ($)</label>

                <input
                    type="number"
                    step="0.01"
                    name="costo"
                    value="<?= $plan['costo'] ?>"
                    required>
            </div>

        </div>

        <div class="acciones-form">

            <button type="submit" class="btn-save">
                💾 Guardar Cambios
            </button>

            <a href="administrador.php?page=ver_planes" class="btn-cancel">
                ✖ Cancelar
            </a>

        </div>

    </form>

</div>