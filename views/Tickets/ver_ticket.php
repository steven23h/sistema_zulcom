<?php
require_once '../../controllers/TicketsController.php';

$controller = new TicketsController();
$ticket = $controller->show($_GET['id'] ?? 0);

if (!$ticket) {
    echo "<div class='alert error'>⚠️ Error: El ticket solicitado no existe o no tiene datos asociados en Zulcom.</div>";
    exit;
}

$estadoReal = strtolower($ticket['estado'] ?? 'pendiente');
?>

<div class="ticket-detalle-card">

    <h2 class="ticket-detalle-title">
        📄 Detalle del Ticket #<?= htmlspecialchars($ticket['numero_ticket'] ?? '—') ?>
    </h2>

    <div class="ticket-detalle-grid">

        <div class="ticket-info-card cliente">
            <h3>👤 Datos del Cliente</h3>

            <p><strong>Nombre:</strong> <?= htmlspecialchars(($ticket['nombre'] ?? 'No registrado') . ' ' . ($ticket['apellido'] ?? '')) ?></p>
            <p><strong>Cédula:</strong> <?= htmlspecialchars($ticket['cedula'] ?? '—') ?></p>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($ticket['telefono1'] ?? '—') ?></p>
            <p><strong>Dirección:</strong> <?= htmlspecialchars($ticket['direccion'] ?? '—') ?></p>
        </div>

        <div class="ticket-info-card tecnica">
            <h3>🎫 Info Técnica</h3>

            <p>
                <strong>Estado:</strong>
                <span class="<?= ($estadoReal === 'completado' || $estadoReal === 'cerrado') ? 'text-success' : 'text-danger' ?>">
                    <?= htmlspecialchars($ticket['estado'] ?? 'Pendiente') ?>
                </span>
            </p>

            <p><strong>Técnico Asignado:</strong> <?= htmlspecialchars(($ticket['tecnico_nombre'] ?? 'Sin asignar') . ' ' . ($ticket['tecnico_apellido'] ?? '')) ?></p>
            <p><strong>¿Tiene Costo?:</strong> <?= !empty($ticket['tiene_costo']) ? '💰 Sí' : '✅ No' ?></p>
            <p><strong>Hora Visita:</strong> <?= htmlspecialchars($ticket['horaVisita'] ?? '—') ?></p>
        </div>

    </div>

    <div class="ticket-section">
        <label>Descripción del Problema:</label>

        <div class="ticket-text-box">
            <?= nl2br(htmlspecialchars($ticket['descripcion'] ?? 'Sin descripción.')) ?>
        </div>
    </div>

    <?php if ($estadoReal === 'completado' || $estadoReal === 'cerrado'): ?>

        <div id="seccion-solucion" class="ticket-solucion">

            <h3>📋 Informe y Resolución Técnica</h3>

            <div class="ticket-fechas">
                <p>📅 <strong>Fecha Cierre:</strong> <?= !empty($ticket['fecha_solucion']) ? date('d/m/Y', strtotime($ticket['fecha_solucion'])) : '—' ?></p>
                <p>⏰ <strong>Hora Cierre:</strong> <?= htmlspecialchars($ticket['hora_solucion'] ?? '—') ?></p>
            </div>

            <label>Trabajo Realizado por ti:</label>
            <div class="ticket-text-box success">
                <?= nl2br(htmlspecialchars($ticket['solucion'] ?? 'No se detalló la solución.')) ?>
            </div>

            <label>🛠️ Materiales e Insumos Utilizados:</label>
            <div class="ticket-text-box italic">
                <?= !empty($ticket['materiales']) ? nl2br(htmlspecialchars($ticket['materiales'])) : 'Ningún material extra reportado.' ?>
            </div>

            <?php if (!empty($ticket['foto_antes']) || !empty($ticket['foto_despues'])): ?>

                <label>📸 Evidencia Visual del Soporte:</label>

                <div class="evidencia-grid">

                    <?php if (!empty($ticket['foto_antes'])): ?>
                        <div class="evidencia-card">
                            <span class="antes">ANTES (Problema)</span>
                            <img src="../../<?= htmlspecialchars($ticket['foto_antes']) ?>" alt="Evidencia Antes">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($ticket['foto_despues'])): ?>
                        <div class="evidencia-card">
                            <span class="despues">DESPUÉS (Solucionado)</span>
                            <img src="../../<?= htmlspecialchars($ticket['foto_despues']) ?>" alt="Evidencia Después">
                        </div>
                    <?php endif; ?>

                </div>

            <?php endif; ?>

        </div>

    <?php endif; ?>

    <div class="ticket-actions">
        <a href="tecnico.php?page=historial_tickets" class="btn-back">
            ⬅ Volver al Historial
        </a>
    </div>

</div>