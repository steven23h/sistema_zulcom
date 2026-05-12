<?php
require_once '../../controllers/TicketsController.php';
require_once '../../config/database.php';

$ticketCtrl = new TicketsController();
$tickets = $ticketCtrl->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
  
    
    <link rel="stylesheet" href="../../public/css/tickets.css">
</head>
<body>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>🎫 Gestión de Tickets</h2>
    <a href="administrador.php?page=crear_ticket" class="btn-new">➕ Nuevo Ticket</a>
</div>

<div class="filters">
    <input type="text" id="filtroCedula" placeholder="🔍 Buscar cédula...">
    <select id="filtroEstado">
        <option value="">Todos los Estados</option>
        <option value="Pendiente">Pendiente</option>
        <option value="Completado">Completado</option>
    </select>
    <input type="date" id="fechaInicio">
</div>

<div class="container-table">
    <table class="table" id="tablaTickets">
        <thead>
            <tr>
                <th>N° Ticket</th>
                <th>Cliente</th>
                <th>Técnico</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tickets as $t): ?>
            <tr data-cedula="<?= $t['cedula'] ?>" 
                data-estado="<?= $t['estado'] ?>" 
                data-fecha="<?= $t['fecha_creacion'] ?>">
                
                <td><b>#<?= $t['numero_ticket'] ?></b></td>
                <td><?= $t['nombre'].' '.$t['apellido'] ?><br><small><?= $t['cedula'] ?></small></td>
                <td><?= $t['tecnico_nombre'] ?></td>
                <td><?= $t['tipo_problema'] ?></td>
                <td><span class="badge"><?= $t['estado'] ?></span></td>
                <td style="font-size: 1.6rem;">
                    <a href="administrador.php?page=ver_ticket&id=<?= $t['id'] ?>" style="text-decoration: none;">👁️</a>
                    <a href="administrador.php?page=editar_ticket&id=<?= $t['id'] ?>" style="text-decoration: none;">✏️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="../../public/js/tickets.js"></script>
</body>
</html>