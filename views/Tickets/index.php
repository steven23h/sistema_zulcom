<?php
require_once '../../controllers/TicketsController.php';
require_once '../../config/database.php';

$ticketCtrl = new TicketsController();
$tickets = $ticketCtrl->index() ?: [];

$db = Database::connect();
$stmtT = $db->query("SELECT id, nombres, apellidos FROM users WHERE role = 'Tecnico'");
$tecnicosLista = $stmtT->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="header-seccion">
    <div>
        <h2>🎫 Gestión de Tickets</h2>
        <p>Consulta, filtra y administra los tickets registrados.</p>
    </div>

    <a href="administrador.php?page=crear_ticket" class="btn-new">
        ➕ Nuevo Ticket
    </a>
</div>

<div class="container-form">

    <div class="filtros-grid filtros-grid-tickets">

        <div class="form-group">
            <label>Cédula</label>
            <input type="text" id="filtroCedula" placeholder="🔍 Buscar cédula...">
        </div>

        <div class="form-group">
            <label>Estado</label>
            <select id="filtroEstado">
                <option value="">Todos los Estados</option>
                <option value="Pendiente">Pendiente</option>
                <option value="En Proceso">En Proceso</option>
                <option value="Completado">Completado</option>
            </select>
        </div>

        <div class="form-group">
            <label>Técnico</label>
            <select id="filtroTecnico">
                <option value="">Todos los Técnicos</option>
                <?php foreach($tecnicosLista as $tec): ?>
                    <option value="<?= $tec['id'] ?>">
                        <?= htmlspecialchars($tec['nombres'].' '.$tec['apellidos']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Fecha Inicio</label>
            <input type="date" id="fechaInicio">
        </div>

        <div class="form-group">
            <label>Fecha Fin</label>
            <input type="date" id="fechaFin">
        </div>

    </div>

</div>

<div class="table-container">

    <table class="zulcom-table" id="tablaTickets">

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
                    $estadoReal = strtolower($t['estado'] ?? 'pendiente');

                    $estadoClase = 'pendiente';

                    if ($estadoReal === 'en proceso') {
                        $estadoClase = 'proceso';
                    }

                    if ($estadoReal === 'completado' || $estadoReal === 'cerrado') {
                        $estadoClase = 'completado';
                    }
                ?>

                <tr data-cedula="<?= htmlspecialchars($t['cedula'] ?? '') ?>"
                    data-estado="<?= htmlspecialchars($t['estado'] ?? 'Pendiente') ?>"
                    data-tecnico="<?= htmlspecialchars($t['id_tecnico'] ?? '') ?>"
                    data-fecha="<?= htmlspecialchars($t['fecha_creacion'] ?? '') ?>">

                    <td>
                        <strong>#<?= htmlspecialchars($t['numero_ticket']) ?></strong>
                    </td>

                    <td>
                        <?= htmlspecialchars(($t['nombre'] ?? '').' '.($t['apellido'] ?? '')) ?>
                        <br>
                        <small><?= htmlspecialchars($t['cedula'] ?? '') ?></small>
                    </td>

                    <td>
                        <?php if (!empty($t['tecnico_nombre'])): ?>

                            <?= htmlspecialchars($t['tecnico_nombre'] . ' ' . ($t['tecnico_apellido'] ?? '')) ?>

                        <?php else: ?>

                            <span class="text-muted">Sin asignar</span>

                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if (!empty($t['tiene_costo'])): ?>
                            <span class="costo-si">💰 Sí</span>
                        <?php else: ?>
                            <span class="costo-no">✅ No</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="badge-status <?= $estadoClase ?>">
                            <?= htmlspecialchars($t['estado'] ?: 'Pendiente') ?>
                        </span>
                    </td>

                    <td>
                        <div class="acciones-iconos">

                            <a href="administrador.php?page=ver_ticket&id=<?= $t['id'] ?>"
                               title="Ver Ticket">
                                👁️
                            </a>

                            <?php if ($estadoReal === 'completado' || $estadoReal === 'cerrado'): ?>

                                <a href="administrador.php?page=ver_ticket&id=<?= $t['id'] ?>#seccion-solucion"
                                   title="Ver Resultado Técnico">
                                    📋
                                </a>

                            <?php else: ?>

                                <span title="Sin respuesta técnica">
                                    📋
                                </span>

                            <?php endif; ?>

                            <a href="administrador.php?page=editar_ticket&id=<?= $t['id'] ?>"
                               title="Editar Ticket">
                                ✏️
                            </a>

                        </div>
                    </td>

                </tr>

            <?php endforeach; ?>
        </tbody>

    </table>

</div>

<script src="../../public/js/tickets.js"></script>