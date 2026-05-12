<?php
require_once '../../controllers/TicketsController.php';

$controller = new TicketsController();
$ticket = $controller->show($_GET['id']);
?>
<link rel="stylesheet" href="../../public/css/tickets.css">

<div class="card-form">
    <h2>📄 Detalle del Ticket #<?= $ticket['numero_ticket'] ?></h2>

    <div class="grid">
        <div class="client-info" style="background: #f9f9f9; border-left-color: var(--morado-zulcom);">
            <h3 style="color: var(--morado-zulcom);">👤 Datos del Cliente</h3>
            <p><b>Nombre:</b> <?= $ticket['nombre'] . ' ' . $ticket['apellido'] ?></p>
            <p><b>Cédula:</b> <?= $ticket['cedula'] ?></p>
            <p><b>Teléfono:</b> <?= $ticket['telefono1'] ?></p>
            <p><b>Dirección:</b> <?= $ticket['direccion'] ?></p>
        </div>

        <div class="client-info" style="background: #f9f9f9; border-left-color: var(--verde-zulcom);">
            <h3 style="color: var(--verde-zulcom);">🎫 Info Técnica</h3>
            <p><b>Estado:</b> <?= $ticket['estado'] ?></p>
            <p><b>Técnico:</b> <?= $ticket['tecnico_nombre'] ?></p>
            <p><b>Tipo:</b> <?= $ticket['tipo_problema'] ?></p>
            <p><b>Hora Visita:</b> <?= $ticket['horaVisita'] ?></p>
        </div>
    </div>

    <div class="field full" style="margin-top:20px;">
        <label>Descripción:</label>
        <div style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 12px;">
            <?= nl2br($ticket['descripcion']) ?>
        </div>
    </div>

    <a href="administrador.php?page=ver_tickets" class="btn-back">⬅ Volver al Listado</a>
</div>