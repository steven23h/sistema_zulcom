<?php
require_once '../../controllers/ClientesController.php';
require_once '../../config/database.php';

$clienteCtrl = new ClientesController();
$clientesRaw = $clienteCtrl->index() ?: [];

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


<div class="container-form crear-ticket-card">

    <h2 class="crear-ticket-title">🎫 Crear Nuevo Ticket</h2>

    <form action="../../controllers/TicketsController.php" method="POST">

        <input type="hidden" name="btn_guardar_ticket" value="1">
        <input type="hidden" name="id_cliente" id="id_cliente">

        <div class="form-group">
            <label>Cédula del Cliente *</label>

            <div class="search-box">
                <input type="text" id="cedula" placeholder="Ingrese cédula" required>

                <button type="button" onclick="buscarCliente()" class="btn-buscar">
                    🔍 Buscar
                </button>
            </div>
        </div>

        <div id="clientInfo" class="client-info hidden">
            <p><strong>👤 Cliente:</strong> <span id="nombre_info"></span></p>
            <p><strong>📞 Teléfono:</strong> <span id="telefono_info"></span></p>
            <p><strong>📍 Dirección:</strong> <span id="direccion_info"></span></p>
            <p><strong>📧 Correo:</strong> <span id="correo_info"></span></p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>¿Tiene Costo Adicional?</label>
                <select name="tiene_costo" required>
                    <option value="0">No (Soporte Base / Incluido)</option>
                    <option value="1">Sí (Aplica recargo técnico)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Técnico Asignado</label>
                <select name="id_tecnico" required>
                    <option value="">Seleccione técnico</option>
                    <?php foreach($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>">
                            <?= htmlspecialchars($t['nombres'].' '.$t['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Descripción del Problema</label>
                <textarea name="descripcion" rows="4" required placeholder="Describa la falla técnica..."></textarea>
            </div>

            <div class="form-group full-width">
                <label>Hora de visita</label>
                <input type="datetime-local" name="horaVisita" required>
            </div>

        </div>

        <div class="acciones-form">
            <button type="submit" class="btn-save">💾 Guardar Ticket</button>

            <a href="administrador.php?page=ver_tickets" class="btn-cancel">
                ✖ Cancelar
            </a>
        </div>

    </form>

</div>


    </form>

</div>

<script>
    window.clientes = <?= json_encode($clientes); ?>;
</script>

<script src="../../public/js/tickets.js"></script>