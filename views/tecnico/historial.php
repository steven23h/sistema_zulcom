<?php
require_once '../../controllers/TecnicoController.php';

$id_tecnico = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 0;

$tecnicoCtrl = new TecnicoController();
$allTickets = $tecnicoCtrl->index($id_tecnico) ?: [];

$ticketsHistorial = array_filter($allTickets, function($t) {
    $estado = strtolower($t['estado'] ?? 'pendiente');
    return $estado === 'completado' || $estado === 'cerrado';
});
?>

<div class="header-seccion">
    <div>
        <h2>Historial de Tickets Finalizados</h2>

        <p>
            Aquí se almacena la bitácora de los soportes técnicos que ya solucionaste y cerraste.
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

        <?php if (empty($ticketsHistorial)): ?>

            <tr>
                <td colspan="7" class="empty-row">
                    No registras ningún ticket resuelto en tu historial todavía.
                </td>
            </tr>

        <?php else: ?>

            <?php foreach($ticketsHistorial as $t): ?>

                <tr>

                    <td>
                        <strong>#<?= htmlspecialchars($t['numero_ticket']) ?></strong>
                    </td>

                    <td>
                        <strong>
                            <?= htmlspecialchars(($t['nombre'] ?? '').' '.($t['apellido'] ?? '')) ?>
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
                        <?= !empty($t['fecha_creacion'])
                            ? date('d/m/Y', strtotime($t['fecha_creacion']))
                            : '—' ?>
                    </td>

                    <td>
                        <?= !empty($t['horaVisita'])
                            ? date('d/m/Y - H:i', strtotime($t['horaVisita']))
                            : '—' ?>
                    </td>

                    <td>
                        <span class="badge-status completado">
                            <?= htmlspecialchars($t['estado']) ?>
                        </span>
                    </td>

                    <td>
                        <a href="tecnico.php?page=ver_ticket&id=<?= $t['id'] ?>"
                           class="btn-ver">
                            Ver Realizado
                        </a>
                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

    </table>

</div>