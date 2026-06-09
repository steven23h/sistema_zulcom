<?php
require_once '../../controllers/TicketsController.php';

$ticketsCtrl = new TicketsController();
$ticket = $ticketsCtrl->show($_GET['id'] ?? 0);

if (!$ticket) {
    echo "<div style='padding:20px; background:#fee2e2; color:#ef4444; border-radius:8px;'>⚠️ Error: El ticket seleccionado no es válido.</div>";
    exit;
}
?>
<link rel="stylesheet" href="../../public/css/tickets.css">

<form action="../../controllers/TecnicoController.php" method="POST" enctype="multipart/form-data" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-family: sans-serif; max-width: 700px; margin: 20px auto;">
    
    <input type="hidden" name="id_ticket" value="<?= htmlspecialchars($ticket['id']) ?>">

    <h2 style="color: #4361ee; margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">
        🔧 Formulario de Resolución - Ticket #<?= htmlspecialchars($ticket['numero_ticket']) ?>
    </h2>

    <div style="background: #f7fafc; padding: 12px; border-radius: 6px; margin-bottom: 20px; color: #4a5568; font-size: 0.95em;">
        👤 <b>Cliente:</b> <?= htmlspecialchars(($ticket['nombre'] ?? '') . ' ' . ($ticket['apellido'] ?? '')) ?><br>
        📝 <b>Descripción inicial:</b> <?= htmlspecialchars($ticket['descripcion'] ?? 'Sin descripción.') ?>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #2d3748;">Cambiar Estado a:</label>
        <select name="estado" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e0; background: #fff;">
            <option value="completado">✅ Completado</option>
            <option value="cerrado">🔒 Cerrado / Finalizado</option>
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #2d3748;">Trabajo Realizado (Informe Técnico):</label>
        <textarea name="solucion" required rows="4" placeholder="Escribe el diagnóstico y la reparación ejecutada..." style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e0; font-family: sans-serif; resize: vertical;"></textarea>
    </div>

    <div style="margin-bottom: 20px;">
        <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #2d3748;">🛠 silence Materiales e Insumos Utilizados:</label>
        <textarea name="materiales" rows="3" placeholder="Ej: 15 metros de cable drops, 2 conectores Fast, 1 ONT Huawei..." style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e0; font-family: sans-serif; resize: vertical;"></textarea>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 25px; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px dashed #cbd5e0;">
        <div>
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #e63946;">📸 Foto Antes (Problema Inicial):</label>
            <input type="file" name="foto_antes" accept="image/*" style="font-size: 0.9em; width: 100%;">
        </div>
        <div>
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #2a9d8f;">📸 Foto Después (Trabajo Concluido):</label>
            <input type="file" name="foto_despues" accept="image/*" style="font-size: 0.9em; width: 100%;">
        </div>
    </div>

    <div style="display: flex; gap: 10px; border-top: 1px solid #edf2f7; padding-top: 15px;">
        <button type="submit" style="background: #2a9d8f; color: white; border: none; padding: 12px 25px; font-weight: bold; border-radius: 6px; cursor: pointer; font-size: 0.95em;">
            🚀 Guardar Solución y Evidencias
        </button>
        <a href="tecnico.php?page=mis_tickets" style="background: #718096; color: white; text-decoration: none; padding: 12px 20px; font-weight: bold; border-radius: 6px; text-align: center; font-size: 0.95em;">
            Regresar
        </a>
    </div>
</form>