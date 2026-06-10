<?php
require_once '../../controllers/TecnicoController.php';

// Obtener ID del técnico de forma segura
$id_tecnico = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 0;

$tecnicoCtrl = new TecnicoController();
$allTickets = $tecnicoCtrl->index($id_tecnico) ?: [];

// Filtrar en tiempo de ejecución: dejamos exclusivamente los que estén Completados o Cerrados
$ticketsHistorial = array_filter($allTickets, function($t) {
    $estado = strtolower($t['estado'] ?? 'pendiente');
    return $estado === 'completado' || $estado === 'cerrado';
});
?>

<div style="margin-bottom: 25px; font-family: sans-serif;">
    <h2>📚 Historial de Tickets Finalizados</h2>
    <p style="color: #666;">Aquí se almacena la bitácora de los soportes técnicos que ya solucionaste y cerraste.</p>
</div>

<div class="container-table" style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; padding: 10px;">
    <table class="table" style="width: 100%; border-collapse: collapse; text-align: left; font-family: sans-serif;">
        <thead>
            <tr style="background: #2a9d8f; color: white;">
                <th style="padding: 12px 15px;">N° Ticket</th>
                <th style="padding: 12px 15px;">Cliente</th>
                <th style="padding: 12px 15px;">Descripción del Problema</th>
                <th style="padding: 12px 15px;">Fecha Registro</th>
                <th style="padding: 12px 15px;">Fecha / Hora Visita</th>
                <th style="padding: 12px 15px;">Estado</th>
                <th style="padding: 12px 15px; text-align: center;">Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ticketsHistorial)): ?>
                <tr>
                    <td colspan="7" style="padding: 30px; text-align: center; color: #a0aec0; font-style: italic;">No registras ningún ticket resuelto en tu historial todavía.</td>
                </tr>
            <?php else: ?>
                <?php foreach($ticketsHistorial as $t): ?>
                <tr style="border-bottom: 1px solid #edf2f7; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 12px 15px;"><b>#<?= htmlspecialchars($t['numero_ticket']) ?></b></td>
                    <td style="padding: 12px 15px;">
                        <strong><?= htmlspecialchars(($t['nombre'] ?? '').' '.($t['apellido'] ?? '')) ?></strong>
                        <br><small style="color: #718096;">💳 CI: <?= htmlspecialchars($t['cedula'] ?? '—') ?></small>
                    </td>
                    <td style="padding: 12px 15px; max-width: 250px; word-wrap: break-word;">
                        <?= htmlspecialchars($t['descripcion']) ?>
                    </td>
                    <td style="padding: 12px 15px; color: #4a5568;">
                        📝 <?= !empty($t['fecha_creacion']) ? date('d/m/Y', strtotime($t['fecha_creacion'])) : '—' ?>
                    </td>
                    <td style="padding: 12px 15px; color: #4a5568;">
                        📅 <?= !empty($t['horaVisita']) ? date('d/m/Y - H:i', strtotime($t['horaVisita'])) : '—' ?>
                    </td>
                    <td style="padding: 12px 15px;">
                        <span style="background-color: #2a9d8f; color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.85em; font-weight: bold; display: inline-block; text-transform: uppercase;">
                            <?= htmlspecialchars($t['estado']) ?>
                        </span>
                    </td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <a href="tecnico.php?page=ver_ticket&id=<?= $t['id'] ?>" style="background: #2a9d8f; color: white; padding: 8px 14px; text-decoration: none; border-radius: 6px; font-size: 0.9em; font-weight: bold; box-shadow: 0 2px 5px rgba(42, 157, 143, 0.3); display: inline-block; transition: background 0.2s;" onmouseover="this.style.background='#1f766c'" onmouseout="this.style.background='#2a9d8f'">
                            👁️ Ver Realizado
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>