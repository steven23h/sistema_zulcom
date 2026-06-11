<?php
require_once '../../controllers/TecnicoController.php';

$id_tecnico = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 0;

$tecnicoCtrl = new TecnicoController();
$allTickets = $tecnicoCtrl->index($id_tecnico) ?: [];

$tickets = array_filter($allTickets, function($t) {
    $estado = strtolower($t['estado'] ?? 'pendiente');
    return $estado !== 'completado' && $estado !== 'cerrado';
});
?>

<div class="header-seccion">
    <div>
        <h2>Mis Órdenes de Trabajo Asignadas</h2>
        <p>
            A continuación verás la lista de soportes que tienes pendientes por atender en campo.
        </p>
    </div>
</div>

<div class="table-container">

    <table class="zulcom-table">

        <thead>
            <tr>
                <th>N° Ticket</th>
                <th>Cliente</th>
                <th>Descripción</th>
                <th>Fecha Registro</th>
                <th>Fecha / Hora Visita</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($tickets)): ?>

                <tr>
                    <td colspan="7" class="empty-row">
                        🎉 ¡Excelente! No tienes soportes ni tickets pendientes asignados.
                    </td>
                </tr>

            <?php else: ?>

                <?php foreach($tickets as $t): ?>

                    <?php 
                        $est = $t['estado'] ?: 'Pendiente';
                        $estadoClase = 'pendiente';

                        if ($est === 'En Proceso') {
                            $estadoClase = 'proceso';
                        }
                    ?>

                    <tr>
                        <td>
                            <strong>#<?= htmlspecialchars($t['numero_ticket']) ?></strong>
                        </td>

                        <td>
                            <strong>
                                <?= htmlspecialchars(($t['nombre'] ?? '') . ' ' . ($t['apellido'] ?? '')) ?>
                            </strong>
                            <br>
                            <small>
                                CI: <?= htmlspecialchars($t['cedula'] ?? '—') ?>
                            </small>
                        </td>

                        <td>
                            <?= htmlspecialchars($t['descripcion']) ?>
                        </td>

                        <td>
                            <?= !empty($t['fecha_creacion']) ? date('d/m/Y', strtotime($t['fecha_creacion'])) : '—' ?>
                        </td>

                        <td>
                            <?= !empty($t['horaVisita']) ? date('d/m/Y - H:i', strtotime($t['horaVisita'])) : '—' ?>
                        </td>

                        <td>
                            <span class="badge-status <?= $estadoClase ?>">
                                <?= htmlspecialchars($est) ?>
                            </span>
                        </td>

                        <td>
                            <a href="tecnico.php?page=resolver_ticket&id=<?= $t['id'] ?>"
                               class="btn-accion">
                                Resolver
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>
        </tbody>

    </table>

</div>