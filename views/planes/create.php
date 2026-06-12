<div class="container-form plan-form-card">

    <h2>➕ Registrar Nuevo Plan</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>

        <div class="alert success">
            ✅ ¡Plan registrado exitosamente!
        </div>

    <?php endif; ?>

    <form action="../../controllers/PlanesController.php" method="POST">

        <div class="form-grid">

            <div class="form-group full-width">
                <label>Nombre del Plan</label>

                <input
                    type="text"
                    name="nombre_plan"
                    placeholder="Ej: Plan Fibra 100MB"
                    required>
            </div>

            <div class="form-group">
                <label>Costo Mensual ($)</label>

                <input
                    type="number"
                    step="0.01"
                    name="costo"
                    placeholder="0.00"
                    required>
            </div>

            <div class="form-group">
                <label>Velocidad (Mbps)</label>

                <input
                    type="number"
                    name="megas"
                    placeholder="100"
                    required>
            </div>

        </div>

        <div class="acciones-form">

            <button
                type="submit"
                name="btn_guardar_plan"
                class="btn-save">
                💾 Guardar Plan
            </button>

            <a href="administrador.php?page=ver_planes"
               class="btn-cancel">
                Cancelar
            </a>

        </div>

    </form>

</div>