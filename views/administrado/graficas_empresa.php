<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../config/database.php';
$db = Database::connect();

// Consulta sincrónica de las últimas 5 Órdenes de Trabajo (Soportes)
$stmtTickets = $db->query("SELECT t.numero_ticket, t.descripcion, t.estado, c.nombre, c.apellido 
                           FROM tickets t
                           LEFT JOIN clientes c ON t.id_cliente = c.id_cliente
                           ORDER BY t.id DESC LIMIT 5");
$ultimosTickets = $stmtTickets->fetchAll(PDO::FETCH_ASSOC);

// Consulta sincrónica de los Planes Habilitados en la plataforma
$stmtPlanes = $db->query("SELECT nombre_plan, costo FROM planes ORDER BY costo ASC");
$planesConfigurados = $stmtPlanes->fetchAll(PDO::FETCH_ASSOC);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="/zulcom2/public/css/dashboard_graficas.css">

<div class="dashboard-grid">

    <div class="kpi-container">
        <div class="kpi-card">
            <div class="kpi-title">CLIENTES TOTALES</div>
            <div class="kpi-value" id="kpi-clientes-totales">...</div>
        </div>
        <div class="kpi-card recaudacion">
            <div class="kpi-title">RECAUDACIÓN MENSUAL</div>
            <div class="kpi-value" id="kpi-total-recaudado">$...</div>
        </div>
        <div class="kpi-card morosidad">
            <div class="kpi-title">ÍNDICE DE MOROSIDAD</div>
            <div class="kpi-value" id="kpi-indice-morosidad">...</div>
        </div>
        <div class="kpi-card tickets">
            <div class="kpi-title">SOPORTES PENDIENTES</div>
            <div class="kpi-value" id="kpi-tickets-pendientes">...</div>
        </div>
    </div>

    <div class="charts-row">
        <div class="dashboard-block">
            <div class="block-title">Crecimiento de Clientes vs Recaudación</div>
            <div class="chart-container">
                <canvas id="canvasCrecimiento"></canvas>
            </div>
        </div>
        
        <div class="dashboard-block">
            <div class="block-title">Estado de Conexiones</div>
            <div class="chart-container">
                <canvas id="canvasDistribucion"></canvas>
            </div>
        </div>
    </div>

    <div class="charts-row">
        <div class="dashboard-block">
            <div class="block-title">
                <span>⚠️ Últimas Órdenes de Trabajo Asignadas</span>
                <a href="administrador.php?page=ver_tickets" class="view-all-link">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>N° Ticket</th>
                            <th>Cliente</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ultimosTickets)): ?>
                            <?php foreach ($ultimosTickets as $tk): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($tk['numero_ticket']) ?></strong></td>
                                    <td><?= htmlspecialchars($tk['nombre'] . ' ' . $tk['apellido']) ?></td>
                                    <td><?= htmlspecialchars($tk['descripcion']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center-muted">No hay órdenes de trabajo registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dashboard-block">
            <div class="block-title">Planes Habilitados</div>
            <div class="table-responsive">
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Costo Mensual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($planesConfigurados)): ?>
                            <?php foreach ($planesConfigurados as $plan): ?>
                                <tr>
                                    <td><?= htmlspecialchars($plan['nombre_plan']) ?></td>
                                    <td>$<?= number_format($plan['costo'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center-muted">No hay planes en el sistema.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="/zulcom2/public/js/dashboard_graficas.js"></script>