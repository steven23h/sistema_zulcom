<?php
require_once '../../controllers/TicketsController.php';
require_once '../../config/database.php';

$ticketCtrl = new TicketsController();
$tickets = $ticketCtrl->index() ?: [];

$db = Database::connect();
$stmtT = $db->query("SELECT id, nombres, apellidos FROM users WHERE role = 'Tecnico'");
$tecnicosLista = $stmtT->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Tickets - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/tickets.css">
</head>
<body>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>🎫 Gestión de Tickets</h2>
    <a href="administrador.php?page=crear_ticket" class="btn-new">➕ Nuevo Ticket</a>
</div>

<div class="filters" style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
    <input type="text" id="filtroCedula" placeholder="🔍 Buscar cédula...">
    
    <select id="filtroEstado">
        <option value="">Todos los Estados</option>
        <option value="Pendiente">Pendiente</option>
        <option value="En Proceso">En Proceso</option>
        <option value="Completado">Completado</option>
    </select>

    <select id="filtroTecnico">
        <option value="">Todos los Técnicos</option>
        <?php foreach($tecnicosLista as $tec): ?>
            <option value="<?= $tec['id'] ?>"><?= htmlspecialchars($tec['nombres'].' '.$tec['apellidos']) ?></option>
        <?php endforeach; ?>
    </select>

    <input type="date" id="fechaInicio" title="Fecha Inicio">
    <input type="date" id="fechaFin" title="Fecha Fin">
</div>

<div class="container-table">
    <table class="table" id="tablaTickets">
        <thead>
            <tr>
                <th>N° Ticket</th>
                <th>Cliente</th>
                <th>Técnico</th>
                <th>¿Tiene Costo?</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tickets as $t): ?>
            <?php 
                // Normalizamos el estado a minúsculas para evaluar de forma segura en todo el bloque
                $estadoReal = strtolower($t['estado'] ?? 'pendiente'); 
            ?>
            <tr data-cedula="<?= htmlspecialchars($t['cedula'] ?? '') ?>" 
                data-estado="<?= htmlspecialchars($t['estado'] ?? 'Pendiente') ?>" 
                data-tecnico="<?= htmlspecialchars($t['id_tecnico'] ?? '') ?>"
                data-fecha="<?= htmlspecialchars($t['fecha_creacion'] ?? '') ?>">
                
                <td><b>#<?= htmlspecialchars($t['numero_ticket']) ?></b></td>
                <td>
                    <?= htmlspecialchars(($t['nombre'] ?? '').' '.($t['apellido'] ?? '')) ?>
                    <br><small><?= htmlspecialchars($t['cedula'] ?? '') ?></small>
                </td>
                <td>
                    <?php 
                    if (!empty($t['tecnico_nombre'])) {
                        echo htmlspecialchars($t['tecnico_nombre'] . ' ' . ($t['tecnico_apellido'] ?? ''));
                    } else {
                        echo '<i style="color: #a0aec0;">Sin asignar</i>';
                    }
                    ?>
                </td>
                <td>
                    <span style="color: <?= !empty($t['tiene_costo']) ? '#e63946' : '#2a9d8f' ?>; font-weight: bold;">
                        <?= !empty($t['tiene_costo']) ? '💰 Sí' : '✅ No' ?>
                    </span>
                </td>
                <td>
                    <?php $est = $t['estado'] ?: 'Pendiente'; ?>
                    <span class="badge" style="background-color: <?= $estadoReal === 'completado' || $estadoReal === 'cerrado' ? '#2a9d8f' : ($estadoReal === 'en proceso' ? '#f4a261' : '#e63946') ?>; color: white; padding: 5px 10px; border-radius: 5px;">
                        <?= htmlspecialchars($est) ?>
                    </span>
                </td>
                <td style="font-size: 1.6rem;">
                    <a href="administrador.php?page=ver_ticket&id=<?= $t['id'] ?>" title="Ver Ticket" style="text-decoration: none;">👁️</a>
                    
                    <?php if ($estadoReal === 'completado' || $estadoReal === 'cerrado'): ?>
                        <a href="administrador.php?page=ver_ticket&id=<?= $t['id'] ?>#seccion-solucion" title="Ver Resultado Técnico" style="text-decoration: none; margin-left: 8px;">📋</a>
                    <?php else: ?>
                        <span style="font-size: 1.6rem; filter: grayscale(1); opacity: 0.3; cursor: not-allowed; margin-left: 8px;" title="Sin respuesta técnica">📋</span>
                    <?php endif; ?>

                    <a href="administrador.php?page=editar_ticket&id=<?= $t['id'] ?>" title="Editar Ticket" style="text-decoration: none; margin-left: 8px;">✏️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="../../public/js/tickets.js"></script>
</body>
</html>