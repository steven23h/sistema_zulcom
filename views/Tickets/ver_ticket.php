<?php
// Usamos el controlador de tickets que ya tiene la lógica de lectura show($id)
require_once '../../controllers/TicketsController.php';

$controller = new TicketsController();
$ticket = $controller->show($_GET['id'] ?? 0);

if (!$ticket) {
    echo "<div style='padding:20px; background:#fee2e2; color:#ef4444; border-radius:8px;'>⚠️ Error: El ticket solicitado no existe o no tiene datos asociados en Zulcom.</div>";
    exit;
}

$estadoReal = strtolower($ticket['estado'] ?? 'pendiente');
?>

<div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); font-family: sans-serif; max-width: 1000px; margin: 0 auto;">
    
    <h2 style="color: #2d3748; margin-bottom: 20px; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">
        📄 Detalle del Ticket #<?= htmlspecialchars($ticket['numero_ticket'] ?? '—') ?>
    </h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 20px;">
        
        <div style="background: #f7fafc; padding: 15px; border-radius: 8px; border-left: 5px solid #4361ee;">
            <h3 style="color: #4361ee; margin-top: 0;">👤 Datos del Cliente</h3>
            <p style="margin: 8px 0;"><b>Nombre:</b> <?= htmlspecialchars(($ticket['nombre'] ?? 'No registrado') . ' ' . ($ticket['apellido'] ?? '')) ?></p>
            <p style="margin: 8px 0;"><b>Cédula:</b> <?= htmlspecialchars($ticket['cedula'] ?? '—') ?></p>
            <p style="margin: 8px 0;"><b>Teléfono:</b> <?= htmlspecialchars($ticket['telefono1'] ?? '—') ?></p>
            <p style="margin: 8px 0;"><b>Dirección:</b> <?= htmlspecialchars($ticket['direccion'] ?? '—') ?></p>
        </div>

        <div style="background: #f7fafc; padding: 15px; border-radius: 8px; border-left: 5px solid #2a9d8f;">
            <h3 style="color: #2a9d8f; margin-top: 0;">🎫 Info Técnica</h3>
            <p style="margin: 8px 0;"><b>Estado:</b> 
                <span style="font-weight: bold; color: <?= ($estadoReal === 'completado' || $estadoReal === 'cerrado') ? '#2a9d8f' : '#e63946' ?>;">
                    <?= htmlspecialchars($ticket['estado'] ?? 'Pendiente') ?>
                </span>
            </p>
            <p style="margin: 8px 0;"><b>Técnico Asignado:</b> <?= htmlspecialchars(($ticket['tecnico_nombre'] ?? 'Sin asignar') . ' ' . ($ticket['tecnico_apellido'] ?? '')) ?></p>
            <p style="margin: 8px 0;"><b>¿Tiene Costo?:</b> <?= !empty($ticket['tiene_costo']) ? '💰 Sí' : '✅ No' ?></p>
            <p style="margin: 8px 0;"><b>Hora Visita:</b> <?= htmlspecialchars($ticket['horaVisita'] ?? '—') ?></p>
        </div>

    </div>

    <div style="margin-bottom: 25px;">
        <label style="font-weight: bold; color: #4a5568; display: block; margin-bottom: 8px;">Descripción del Problema:</label>
        <div style="background: #fff; padding: 15px; border: 1px solid #cbd5e0; border-radius: 8px; color: #2d3748; min-height: 60px; line-height: 1.5;">
            <?= nl2br(htmlspecialchars($ticket['descripcion'] ?? 'Sin descripción.')) ?>
        </div>
    </div>

    <?php if ($estadoReal === 'completado' || $estadoReal === 'cerrado'): ?>
    <div id="seccion-solucion" style="margin-top: 30px; border-top: 2px dashed #cbd5e0; padding-top: 20px;">
        <div style="background: #f0fdf4; border-left: 5px solid #2a9d8f; padding: 20px; border-radius: 8px;">
            <h3 style="color: #2a9d8f; margin-top: 0;">📋 Informe y Resolución Técnica</h3>
            
            <div style="display: flex; gap: 30px; margin-bottom: 15px; color: #718096; font-size: 0.9em;">
                <p style="margin: 0;">📅 <b>Fecha Cierre:</b> <?= !empty($ticket['fecha_solucion']) ? date('d/m/Y', strtotime($ticket['fecha_solucion'])) : '—' ?></p>
                <p style="margin: 0;">⏰ <b>Hora Cierre:</b> <?= htmlspecialchars($ticket['hora_solucion'] ?? '—') ?></p>
            </div>

            <label style="font-weight: bold; color: #2d3748; display: block; margin-bottom: 5px;">Trabajo Realizado por ti:</label>
            <div style="background: #fff; padding: 15px; border: 1px solid #c6f6d5; border-radius: 8px; color: #2d3748; margin-bottom: 15px;">
                <?= nl2br(htmlspecialchars($ticket['solucion'] ?? 'No se detalló la solución.')) ?>
            </div>

            <label style="font-weight: bold; color: #2d3748; display: block; margin-bottom: 5px;">🛠️ Materiales e Insumos Utilizados:</label>
            <div style="background: #fff; padding: 15px; border: 1px solid #cbd5e0; border-radius: 8px; color: #4a5568; font-style: italic; margin-bottom: 20px;">
                <?= !empty($ticket['materiales']) ? nl2br(htmlspecialchars($ticket['materiales'])) : 'Ningún material extra reportado.' ?>
            </div>

            <?php if (!empty($ticket['foto_antes']) || !empty($ticket['foto_despues'])): ?>
                <label style="font-weight: bold; color: #2d3748; display: block; margin-bottom: 8px;">📸 Evidencia Visual del Soporte:</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px;">
                    
                    <?php if (!empty($ticket['foto_antes'])): ?>
                        <div style="text-align: center; background: #fff; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                            <span style="font-size: 0.85em; font-weight: bold; color: #e63946; display: block; margin-bottom: 5px;">ANTES (Problema)</span>
                            <img src="../../<?= htmlspecialchars($ticket['foto_antes']) ?>" alt="Evidencia Antes" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 4px;">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($ticket['foto_despues'])): ?>
                        <div style="text-align: center; background: #fff; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                            <span style="font-size: 0.85em; font-weight: bold; color: #2a9d8f; display: block; margin-bottom: 5px;">DESPUÉS (Solucionado)</span>
                            <img src="../../<?= htmlspecialchars($ticket['foto_despues']) ?>" alt="Evidencia Después" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 4px;">
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endif; ?>

    <div style="margin-top: 25px; border-top: 1px solid #edf2f7; padding-top: 15px;">
        <a href="tecnico.php?page=historial_tickets" style="background: #718096; text-decoration: none; padding: 10px 20px; display: inline-block; border-radius: 6px; color: white; font-weight: bold; font-size: 0.9em;">
            ⬅ Volver al Historial
        </a>
    </div>

</div>