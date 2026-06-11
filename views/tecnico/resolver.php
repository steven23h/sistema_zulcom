<?php
require_once '../../controllers/TicketsController.php';

$ticketsCtrl = new TicketsController();
$ticket = $ticketsCtrl->show($_GET['id'] ?? 0);

if (!$ticket) {
    echo "<div class='alert error'>⚠️ Error: El ticket seleccionado no es válido.</div>";
    exit;
}
?>

<form action="../../controllers/TecnicoController.php"
      method="POST"
      enctype="multipart/form-data"
      class="container-form form-resolver">

    <input type="hidden" name="id_ticket" value="<?= htmlspecialchars($ticket['id']) ?>">

    <div class="header-seccion">
        <div>
            <h2>🔧 Formulario de Resolución - Ticket #<?= htmlspecialchars($ticket['numero_ticket']) ?></h2>
            <p>
                Completa el informe técnico, materiales utilizados y evidencias del trabajo realizado.
            </p>
        </div>
    </div>

    <div class="ticket-info-box">
        👤 <strong>Cliente:</strong>
        <?= htmlspecialchars(($ticket['nombre'] ?? '') . ' ' . ($ticket['apellido'] ?? '')) ?>
        <br>
        📝 <strong>Descripción inicial:</strong>
        <?= htmlspecialchars($ticket['descripcion'] ?? 'Sin descripción.') ?>
    </div>

    <div class="form-grid">

        <div class="form-group">
            <label>Cambiar Estado a:</label>
            <select name="estado" required>
                <option value="completado">✅ Completado</option>
                <option value="cerrado">🔒 Cerrado / Finalizado</option>
            </select>
        </div>

        <div class="form-group full-width">
            <label>Trabajo Realizado (Informe Técnico):</label>
            <textarea
                name="solucion"
                required
                rows="4"
                placeholder="Escribe el diagnóstico y la reparación ejecutada..."></textarea>
        </div>

        <div class="form-group full-width">
            <label>🛠 Materiales e Insumos Utilizados:</label>
            <textarea
                name="materiales"
                rows="3"
                placeholder="Ej: 15 metros de cable drops, 2 conectores Fast, 1 ONT Huawei..."></textarea>
        </div>

    </div>

    <div class="evidencias-grid">

        <div class="form-group">
            <label class="label-danger">📸 Foto Antes (Problema Inicial):</label>
            <input type="file" name="foto_antes" accept="image/*">
        </div>

        <div class="form-group">
            <label class="label-success">📸 Foto Después (Trabajo Concluido):</label>
            <input type="file" name="foto_despues" accept="image/*">
        </div>

    </div>

    <div class="acciones-form">

        <button type="submit" class="btn-save">
            🚀 Guardar Solución y Evidencias
        </button>

        <a href="tecnico.php?page=tecnico_tickets" class="btn-cancel">
            Regresar
        </a>

    </div>

</form>