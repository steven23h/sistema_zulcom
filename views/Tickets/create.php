<?php
require_once '../../controllers/ClientesController.php';
require_once '../../config/database.php';

$clienteCtrl = new ClientesController();
$clientesRaw = $clienteCtrl->index() ?: [];

// Mapeo seguro para garantizar que JS reciba id_cliente, cedula, nombre, apellido, etc.
$clientes = [];
foreach ($clientesRaw as $c) {
    $clientes[] = [
        'id_cliente' => $c['id_cliente'] ?? $c['id'] ?? '',
        'cedula'     => trim($c['cedula'] ?? ''),
        'nombre'     => $c['nombre'] ?? $c['nombres'] ?? '',
        'apellido'   => $c['apellido'] ?? $c['apellidos'] ?? '',
        'telefono1'  => $c['telefono1'] ?? $c['telefono'] ?? 'N/A',
        'direccion'  => $c['direccion'] ?? 'N/A',
        'correo'     => $c['correo'] ?? $c['email'] ?? 'N/A'
    ];
}

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
            <div class="search-box" style="display: flex; gap: 10px;">
                <input type="text" id="cedula" placeholder="Ingrese cédula" required style="flex-grow: 1;">
                <button type="button" onclick="buscarCliente()" style="cursor: pointer; padding: 10px 20px;">🔍 Buscar</button>
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
                <label>¿Tiene Costo Adicional?</label>
                <select name="tiene_costo" required>
                    <option value="0">No (Soporte Base / Incluido)</option>
                    <option value="1">Sí (Aplica recargo técnico)</option>
                </select>
            </div>

            <div class="field">
                <label>Técnico Asignado</label>
                <select name="id_tecnico" required>
                    <option value="">Seleccione técnico</option>
                    <?php foreach($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nombres'].' '.$t['apellidos']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field full">
                <label>Descripción del Problema</label>
                <textarea name="descripcion" rows="4" required placeholder="Describa la falla técnica..."></textarea>
            </div>

            <div class="field full">
                <label>Hora de visita</label>
                <input type="datetime-local" name="horaVisita" required>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn-save">💾 Guardar Ticket</button>
            <a href="administrador.php?page=ver_tickets" class="btn-cancel">✖ Cancelar</a>
        </div>
    </form>
</div>

<script>
    window.clientes = <?= json_encode($clientes); ?>;
</script>
<script src="../../public/js/tickets.js"></script>
</body>
</html>