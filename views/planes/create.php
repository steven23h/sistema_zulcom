<link rel="stylesheet" href="../../public/css/planes.css">

<div class="header-seccion">
    <h2>Registrar Nuevo Plan</h2>
</div>

<div class="form-planes">

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">
            <p>✅ ¡Plan registrado exitosamente!</p>
        </div>
    <?php endif; ?>

    <form action="../../controllers/PlanesController.php" method="POST">

        <div class="form-group">
            <label>Nombre del Plan</label>
            <input type="text" name="nombre_plan" placeholder="Ej: Plan Fibra 100MB" required>
        </div>

        <div class="form-grid-2col">
            <div class="form-group">
                <label>Costo Mensual ($)</label>
                <input type="number" step="0.01" name="costo" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label>Velocidad (Mbps)</label>
                <input type="number" name="megas" placeholder="100" required>
            </div>
        </div>

        <button type="submit" name="btn_guardar_plan" class="btn-save">
            💾 Guardar Plan
        </button>

        <a href="administrador.php?page=ver_planes" class="btn-link-cancel">
            Cancelar
        </a>
    </form>
</div>