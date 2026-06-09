<?php
require_once '../../controllers/TecnicoController.php';

// 🔥 Obtener ID del técnico logueado desde la sesión de forma segura
$id_tecnico = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 0;

$tecnicoCtrl = new TecnicoController();
$tickets = $tecnicoCtrl->index($id_tecnico) ?: [];
?>

<div style="margin-bottom: 25px;">
    <h2>🛠️ Mis Órdenes de Trabajo Asignadas</h2>
    <p style="color: #666;">A continuación verás la lista de soportes que debes atender.</p>
</div>

<div class="container-table" style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; padding: 10px;">
    <table class="table" style="width: 100%; border-collapse: collapse; text-align: left; font-family: sans-serif;">
        <thead>
            <tr style="background: #4361ee; color: white;">
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
            <?php if (empty($tickets)): ?>
                <tr>
                    <td colspan="7" style="padding: 20px; text-align: center; color: #a0aec0; font-style: italic;">No tienes tickets asignados pendientes.</td>
                </tr>
            <?php else: ?>
                <?php foreach($tickets as $t): ?>
                <tr style="border-bottom: 1px solid #edf2f7;">
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
                        <?php 
                        $est = $t['estado'] ?: 'Pendiente';
                        // Asignación de colores inteligente según el estado real
                        $bgColor = '#e63946'; // Pendiente (Rojo)
                        if ($est === 'En Proceso') $bgColor = '#f4a261'; // En Proceso (Naranja)
                        if ($est === 'Completado' || $est === 'Cerrado') $bgColor = '#2a9d8f'; // Completado/Cerrado (Verde)
                        ?>
                        <span style="background-color: <?= $bgColor ?>; color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.85em; font-weight: bold; display: inline-block;">
                            <?= htmlspecialchars($est) ?>
                        </span>
                    </td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <?php if(strtolower($est) != 'completado' && strtolower($est) != 'cerrado'): ?>
                            <a href="tecnico.php?page=resolver_ticket&id=<?= $t['id'] ?>" style="background: #4361ee; color: white; padding: 8px 14px; text-decoration: none; border-radius: 6px; font-size: 0.9em; font-weight: bold; box-shadow: 0 2px 5px rgba(67, 97, 238, 0.3); display: inline-block;">
                                🔧 Resolver
                            </a>
                        <?php else: ?>
                            <span style="color: #2a9d8f; font-weight: bold; font-size: 0.95em;">✅ Resuelto</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>