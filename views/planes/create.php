<link rel="stylesheet" href="../../public/css/planes.css">

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #c3e6cb; text-align: center;">
        <p style="margin-bottom: 15px; font-weight: bold;">✅ ¡Plan registrado exitosamente!</p>
    </div>
<?php endif; ?>

<div class="header-seccion">
    <h2>Registrar Nuevo Plan</h2>
</div>

<div class="form-planes">
    <form action="../../controllers/PlanesController.php" method="POST">

        <div class="form-group">
            <label>Nombre del Plan</label>
            <input type="text" name="nombre_plan" placeholder="Ej: Plan Fibra 100MB" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

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

        <a href="administrador.php?page=ver_planes"
           style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none; font-size:1.1rem;">
            Cancelar
        </a>

    </form>
</div>