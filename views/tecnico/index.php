<?php
require_once '../../controllers/TecnicoController.php';

// 🔥 Obtener ID del técnico logueado
$id_tecnico = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 0;

// 🔥 Usar controlador de técnico (NO TicketsController)
$tecnicoCtrl = new TecnicoController();
$tickets = $tecnicoCtrl->index($id_tecnico);
?>

<h2>Mis Tickets</h2>

<table border="1" width="100%">
<thead>
<tr>
    <th>N°</th>
    <th>Cliente</th>
    <th>Cédula</th>
    <th>Tipo</th>
    <th>Descripción</th>
    <th>Estado</th>
    <th>Hora Visita</th>
    <th>Acción</th>
</tr>
</thead>

<tbody>
<?php foreach($tickets as $t): ?>
<tr>
    <td><?= $t['numero_ticket'] ?></td>
    <td><?= $t['nombre'].' '.$t['apellido'] ?></td>
    <td><?= $t['cedula'] ?></td>
    <td><?= $t['tipo_problema'] ?></td>
    <td><?= $t['descripcion'] ?></td>
    <td><?= $t['estado'] ?></td>
    <td><?= $t['horaVisita'] ?? '—' ?></td>

    <td>
    <?php 
    $estado = strtolower($t['estado']);
    if($estado != 'completado' && $estado != 'cerrado'): 
    ?>
        <a href="tecnico.php?page=resolver_ticket&id=<?= $t['id'] ?>">
            🔧 Resolver
        </a>
    <?php else: ?>
        <span style="color:green;">✔ Resuelto</span>
    <?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>