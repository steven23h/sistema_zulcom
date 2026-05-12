<?php
require_once '../../controllers/ClientesController.php';
require_once '../../controllers/PlanesController.php';

$clienteCtrl = new ClientesController();
$planCtrl = new PlanesController();

if (!isset($_GET['id'])) {
    echo "ID no válido";
    exit;
}

$cliente = $clienteCtrl->obtenerPorId($_GET['id']);
$planes = $planCtrl->index();

if (!$cliente) {
    echo "Cliente no encontrado";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/cliente.css">
</head>
<body>

<div class="container-form">
    <h2>✏️ Editar Cliente</h2>

    <form action="../../controllers/ClientesController.php" method="POST">
        <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
        <input type="hidden" name="btn_actualizar_cliente" value="1">

        <div class="form-grid">
            
            <div class="form-group">
                <label>Cédula / RUC</label>
                <input type="text" name="cedula" value="<?= $cliente['cedula'] ?>" required>
            </div>

            <div class="form-group">
                <label>Estado</label>
                <select name="estado">
                    <option value="Activo" <?= $cliente['estado']=='Activo'?'selected':'' ?>>Activo</option>
                    <option value="Inactivo" <?= $cliente['estado']=='Inactivo'?'selected':'' ?>>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <label>IP del Cliente</label>
                <input type="text" name="ip" value="<?= $cliente['ip'] ?>" required>
            </div>

            <div class="form-group">
                <label>Teléfono 1</label>
                <input type="text" name="telefono1" value="<?= $cliente['telefono1'] ?>" required>
            </div>

            <div class="form-group">
                <label>Teléfono 2</label>
                <input type="text" name="telefono2" value="<?= $cliente['telefono2'] ?>" required>
            </div>


            <div class="form-group full-width">
                <label>Nombres</label>
                <input type="text" name="nombre" value="<?= $cliente['nombre'] ?>" required>
            </div>

            <div class="form-group full-width">
                <label>Apellidos</label>
                <input type="text" name="apellido" value="<?= $cliente['apellido'] ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="correo" value="<?= $cliente['correo'] ?>" required>
            </div>

            <div class="form-group">
                <label>Plan Contratado</label>
                <select name="id_plan">
                    <?php foreach ($planes as $p): ?>
                        <option value="<?= $p['id_plan'] ?>" 
                            <?= $p['id_plan'] == $cliente['id_plan'] ? 'selected' : '' ?>>
                            <?= $p['nombre_plan'] ?> - <?= $p['megas'] ?> Mbps
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Discapacidad</label>
                <select name="discapacidad">
                    <option value="no" <?= $cliente['discapacidad']=='no'?'selected':'' ?>>No</option>
                    <option value="si" <?= $cliente['discapacidad']=='si'?'selected':'' ?>>Sí</option>
                </select>
            </div>

            <div class="form-group">
                <label>Coordenadas (GPS)</label>
                <input type="text" name="coordenadas" value="<?= $cliente['coordenadas'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Parroquia</label>
                <input type="text" name="parroquia" value="<?= $cliente['parroquia'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Cantón</label>
                <input type="text" name="canton" value="<?= $cliente['canton'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" name="ciudad" value="<?= $cliente['ciudad'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Provincia</label>
                <input type="text" name="provincia" value="<?= $cliente['provincia'] ?? '' ?>">
            </div>

            <div class="form-group full-width">
                <label>Dirección Exacta</label>
                <textarea name="direccion"><?= $cliente['direccion'] ?></textarea>
            </div>

            <div class="form-group full-width">
                <label>Referencias del Domicilio</label>
                <textarea name="referencias"><?= $cliente['referencias'] ?? '' ?></textarea>
            </div>

        </div>

        <button type="submit" class="btn-save">
            🔄 Guardar Cambios
        </button>

        <a href="administrador.php?page=ver_clientes" class="btn-cancel">
            Cancelar y Volver
        </a>

    </form>
</div>

</body>
</html>