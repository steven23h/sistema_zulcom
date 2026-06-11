<?php
require_once '../../controllers/ClientesController.php';
require_once '../../config/database.php';

$clienteCtrl = new ClientesController();
$clientes = $clienteCtrl->index();

$db = Database::connect();

$id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM tickets WHERE id = ?");
$stmt->execute([$id]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtCliente = $db->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmtCliente->execute([$ticket['id_cliente']]);
$clienteActual = $stmtCliente->fetch(PDO::FETCH_ASSOC);

$stmt = $db->query("SELECT id, nombres, apellidos FROM users WHERE role = 'Tecnico'");
$tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <p><strong>Cliente:</strong> <?= htmlspecialchars($clienteActual['nombre'].' '.$clienteActual['apellido']) ?></p>
            <p><strong>Cédula:</strong> <?= htmlspecialchars($clienteActual['cedula']) ?></p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>Tipo Problema</label>

                <select name="tipo_problema" required>
                    <option value="Hardware" <?= $ticket['tipo_problema']=='Hardware'?'selected':'' ?>>Hardware</option>
                    <option value="Software" <?= $ticket['tipo_problema']=='Software'?'selected':'' ?>>Software</option>
                    <option value="Red" <?= $ticket['tipo_problema']=='Red'?'selected':'' ?>>Red</option>
                    <option value="Facturación" <?= $ticket['tipo_problema']=='Facturación'?'selected':'' ?>>Facturación</option>
                </select>
            </div>

            <div class="form-group">
                <label>Técnico</label>

                <select name="id_tecnico" required>
                    <?php foreach($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $ticket['id_tecnico']==$t['id']?'selected':'' ?>>
                            <?= htmlspecialchars($t['nombres'].' '.$t['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Descripción</label>
                <textarea name="descripcion" rows="4" required><?= htmlspecialchars($ticket['descripcion']) ?></textarea>
            </div>

            <div class="form-group full-width">
                <label>Hora de visita</label>
                <input
                    type="datetime-local"
                    name="horaVisita"
                    value="<?= date('Y-m-d\TH:i', strtotime($ticket['horaVisita'])) ?>"
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