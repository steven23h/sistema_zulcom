<?php
// 1. Inclusión de configuraciones y controladores necesarios
require_once '../../controllers/ClientesController.php';
require_once '../../config/database.php';

$db = Database::connect();

// 2. Obtener el ID enviado por la URL de manera segura
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 3. Consultar los datos actuales del Ticket
$stmt = $db->prepare("SELECT * FROM tickets WHERE id = ?");
$stmt->execute([$id]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

// Si el ticket no existe, evitamos que rompa la pantalla
if (!$ticket) {
    echo "<div class='alert error'>El ticket solicitado no existe.</div>";
    exit();
}

// 4. Consultar los datos del cliente dueño de este ticket específico
$stmtCliente = $db->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmtCliente->execute([$ticket['id_cliente']]);
$clienteActual = $stmtCliente->fetch(PDO::FETCH_ASSOC);

// 5. Cargar la lista completa de técnicos disponibles para el selector
$stmtTec = $db->query("SELECT id, nombres, apellidos FROM users WHERE role = 'Tecnico'");
$tecnicos = $stmtTec->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-form editar-ticket-card">

    <h2 class="crear-ticket-title">
        ✏️ Editar Ticket #<?= htmlspecialchars($ticket['numero_ticket']) ?>
    </h2>

    <form action="../../controllers/TicketsController.php" method="POST">

        <input type="hidden" name="id" value="<?= htmlspecialchars($ticket['id']) ?>">
        <input type="hidden" name="btn_actualizar_ticket" value="1">
        <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($ticket['id_cliente']) ?>">

        <div class="client-info-edit">
            <p><strong>👤 Cliente:</strong> <?= htmlspecialchars(($clienteActual['nombre'] ?? '') . ' ' . ($clienteActual['apellido'] ?? '')) ?></p>
            <p><strong>🪪 Cédula:</strong> <?= htmlspecialchars($clienteActual['cedula'] ?? 'N/A') ?></p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>¿Tiene Costo Adicional?</label>
                <select name="tiene_costo" required>
                    <option value="0" <?= (isset($ticket['tiene_costo']) && $ticket['tiene_costo'] == 0) ? 'selected' : '' ?>>
                        No (Soporte Base / Incluido)
                    </option>
                    <option value="1" <?= (isset($ticket['tiene_costo']) && $ticket['tiene_costo'] == 1) ? 'selected' : '' ?>>
                        Sí (Aplica recargo técnico)
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Técnico Asignado</label>
                <select name="id_tecnico" required>
                    <option value="">Seleccione técnico</option>
                    <?php foreach($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= ($ticket['id_tecnico'] == $t['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['nombres'] . ' ' . $t['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Descripción del Problema</label>
                <textarea name="descripcion" rows="4" required><?= htmlspecialchars($ticket['descripcion'] ?? '') ?></textarea>
            </div>

            <div class="form-group full-width">
                <label>Hora de visita</label>
                <input
                    type="datetime-local"
                    name="horaVisita"
                    value="<?= !empty($ticket['horaVisita']) ? date('Y-m-d\TH:i', strtotime($ticket['horaVisita'])) : '' ?>"
                    required>
            </div>

        </div>

        <div class="acciones-form">
            <button type="submit" class="btn-save">
                🔄 Actualizar Ticket
            </button>

            <a href="administrador.php?page=ver_tickets" class="btn-cancel">
                ✖ Cancelar
            </a>
        </div>

    </form>

</div>