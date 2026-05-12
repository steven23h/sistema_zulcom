<?php
require_once '../../controllers/ClientesController.php';
require_once '../../config/database.php';

$clienteCtrl = new ClientesController();
$clientes = $clienteCtrl->index();
$db = Database::connect();
$stmt = $db->query("SELECT id, nombres, apellidos FROM users WHERE role = 'Tecnico'");
$tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ticket - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/tickets.css">
</head>
<body>

<div class="card-form">
    <h2>🎫 Crear Nuevo Ticket</h2>

    <form action="../../controllers/TicketsController.php" method="POST">
        <input type="hidden" name="btn_guardar_ticket" value="1">
        <input type="hidden" name="id_cliente" id="id_cliente">

        <div class="field">
            <label>Cédula del Cliente *</label>
            <div class="search-box">
                <input type="text" id="cedula" placeholder="Ingrese cédula" required>
                <button type="button" onclick="buscarCliente()">🔍 Buscar</button>
            </div>
        </div>

        <div id="clientInfo" class="client-info hidden" style="background: #f0f7ff; padding: 20px; border-radius: 15px; border-left: 6px solid #4361ee; margin-bottom: 25px;">
            <p style="margin: 5px 0;"><strong>👤 Cliente:</strong> <span id="nombre_info"></span></p>
            <p style="margin: 5px 0;"><strong>📞 Teléfono:</strong> <span id="telefono_info"></span></p>
            <p style="margin: 5px 0;"><strong>📍 Dirección:</strong> <span id="direccion_info"></span></p>
            <p style="margin: 5px 0;"><strong>📧 Correo:</strong> <span id="correo_info"></span></p>
        </div>


        <div class="grid">
            <div class="field">
                <label>Tipo Problema</label>
                <select name="tipo_problema" required>
                    <option>Hardware</option>
                    <option>Software</option>
                    <option>Red</option>
                    <option>Facturación</option>
                    <option>Otro</option>
                </select>
            </div>

            <div class="field">
                <label>Técnico</label>
                <select name="id_tecnico" required>
                    <option value="">Seleccione técnico</option>
                    <?php foreach($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= $t['nombres'].' '.$t['apellidos'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field full">
                <label>Descripción</label>
                <textarea name="descripcion" rows="4" required></textarea>
            </div>

            <div class="field full">
                <label>Hora de visita</label>
                <input type="datetime-local" name="horaVisita" required>
            </div>
        </div>

        <button type="submit" class="btn-save">💾 Guardar Ticket</button>
        <a href="administrador.php?page=ver_tickets" class="btn-cancel">✖ Cancelar</a>
    </form>
</div>

<script>window.clientes = <?= json_encode($clientes); ?>;</script>
<script src="../../public/js/tickets.js"></script>
</body>
</html>