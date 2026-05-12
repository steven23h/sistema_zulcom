<<<<<<< HEAD
<div style="max-width: 600px;">
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #c3e6cb; text-align: center;">
            <p style="margin-bottom: 15px; font-weight: bold;">✅ ¡Plan registrado exitosamente!</p>
            
        </div>
    <?php endif; ?>

    <h2 style="margin-bottom: 20px;">Registrar Nuevo Plan</h2>
    
    <form action="../../controllers/PlanesController.php" method="POST">
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Nombre del Plan:</label>
            <input type="text" name="nombre_plan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;" placeholder="Ej: Plan Fibra 100MB">
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Costo Mensual ($):</label>
            <input type="number" step="0.01" name="costo" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;" placeholder="0.00">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:5px;">Velocidad (Mbps):</label>
            <input type="number" name="megas" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;" placeholder="100">
        </div>

        <button type="submit" name="btn_guardar_plan" style="background:#6f42c1; color:white; border:none; padding:10px 25px; border-radius:5px; cursor:pointer;">
            Guardar Plan
        </button>
        
        <a href="administrador.php?page=ver_planes" style="margin-left:15px; color:#666; text-decoration:none;">
            Cancelar y Volver
        </a>
=======
<link rel="stylesheet" href="../../public/css/planes.css">

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

        <button type="submit" name="btn_guardar_plan" class="btn-save">💾 Guardar Plan</button>
        <a href="administrador.php?page=ver_planes" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none; font-size:1.1rem;">Cancelar</a>
>>>>>>> master
    </form>
</div>