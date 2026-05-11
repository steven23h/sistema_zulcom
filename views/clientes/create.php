<?php
require_once '../../controllers/PlanesController.php';

$planCtrl = new PlanesController();
$planes = $planCtrl->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/cliente.css">
</head>
<body>


    <h2>➕ Registrar Nuevo Cliente</h2>

    <form action="../../controllers/ClientesController.php" method="POST" id="formCliente">
        <input type="hidden" name="btn_guardar_cliente" value="1">

        <div class="form-grid">

            <div class="form-group">
                <label>Cédula / RUC</label>
                <input type="text" name="cedula" maxlength="13" placeholder="Ej: 17xxxxxxx" required>
            </div>

            <div class="form-group">
                <label>Estado Inicial</label>
                <select name="estado" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <label>Dirección IP</label>
                <input type="text" name="ip" placeholder="192.168.x.x" required>
            </div>

            <div class="form-group">
                <label>Teléfono1 / WhatsApp</label>
                <input type="text" name="telefono1" placeholder="09xxxxxxxx" required>
            </div> 

             <div class="form-group">
                <label>Teléfono 2 / WhatsApp</label>
                <input type="text" name="telefono2" placeholder="09xxxxxxxx" required>
            </div>

            <div class="form-group full-width">
                <label>Nombres Completos</label>
                <input type="text" name="nombre" placeholder="Nombres del cliente" required>
            </div>

            <div class="form-group full-width">
                <label>Apellidos Completos</label>
                <input type="text" name="apellido" placeholder="Apellidos del cliente" required>
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" placeholder="cliente@ejemplo.com" required>
            </div>

            <div class="form-group">
                <label>Plan de Internet</label>
                <select name="id_plan" required>
                    <option value="">Seleccione un plan</option>
                    <?php foreach ($planes as $plan): ?>
                        <option value="<?= $plan['id_plan'] ?>">
                            <?= $plan['nombre_plan'] ?> - <?= $plan['megas'] ?> Mbps
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>¿Posee Discapacidad?</label>
                <select name="discapacidad" required>
                    <option value="no">No</option>
                    <option value="si">Sí</option>
                </select>
            </div>

            <div class="form-group">
                <label>Coordenadas GPS</label>
                <input type="text" name="coordenadas" placeholder="Opcional: -0.123, -78.456">
            </div>

            <div class="form-group">
                <label>Parroquia</label>
                <input type="text" name="parroquia" value="Calderon" required>
            </div>

            <div class="form-group">
                <label>Cantón</label>
                <input type="text" name="canton" value="Quito" required>
            </div>

            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" name="ciudad" value="Quito" required>
            </div>

            <div class="form-group">
                <label>Provincia</label>
                <input type="text" name="provincia" value="Pichincha" required>
            </div>

            <div class="form-group full-width">
                <label>Dirección Domiciliaria</label>
                <textarea name="direccion" placeholder="Calle principal y secundaria" required></textarea>
            </div>

            <div class="form-group full-width">
                <label>Referencias de llegada</label>
                <textarea name="referencias" placeholder="Ej: Frente a la tienda de la esquina"></textarea>
            </div>

        </div>

        <button type="submit" class="btn-save">
            💾 Guardar Nuevo Cliente
        </button>

        <a href="administrador.php?page=ver_clientes" class="btn-cancel">
            Cancelar registro
        </a>

    </form>
</div>

<script src="../../public/js/cliente.js"></script>

</body>
</html>