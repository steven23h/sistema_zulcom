<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Invocar de forma limpia al modelo en lugar de duplicar consultas SQL manuales
require_once '../../models/EstadisticasModel.php';

try {
    // Instanciar el modelo (él ya se encarga internamente de conectarse a Database::connect())
    $modeloEstadisticas = new EstadisticasModel();

    // 2. Obtener todas las colecciones de datos procesadas desde el Modelo
    $kpis           = $modeloEstadisticas->getResumenKpi();
    $dataPlanes     = $modeloEstadisticas->getClientesPorPlan();
    $dataConexiones = $modeloEstadisticas->getEstadoConexiones();

    // 3. Mapear las variables para las tablas inferiores
    // Nota: Si deseas limpiar por completo la vista de SQL, podrías mover estas 
    // dos consultas también hacia métodos dentro de tu EstadisticasModel.php
    require_once '../../config/database.php';
    $db = Database::connect();
    
    $stmtTickets = $db->query("SELECT t.numero_ticket, t.descripcion, c.nombre, c.apellido 
                               FROM tickets t
                               LEFT JOIN clientes c ON t.id_cliente = c.id_cliente
                               ORDER BY t.id DESC LIMIT 5");
    $ultimosTickets = $stmtTickets->fetchAll(PDO::FETCH_ASSOC);

    $stmtPlanes = $db->query("SELECT nombre_plan, costo FROM planes ORDER BY costo ASC");
    $planesConfigurados = $stmtPlanes->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "<div style='color:red; padding:20px; background:#ffe6e6;'>Error en el Dashboard: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="/zulcom2/public/css/dashboard_graficas.css">

<div class="dashboard-grid">

    <div class="kpi-container">
        <div class="kpi-card">
            <div class="kpi-title">CLIENTES TOTALES</div>
            <div class="kpi-value"><?= htmlspecialchars($kpis['clientes_totales'] ?? 0) ?></div>
        </div>
        <div class="kpi-card recaudacion">
            <div class="kpi-title">RECAUDACIÓN MENSUAL</div>
            <div class="kpi-value">$<?= htmlspecialchars($kpis['total_recaudado'] ?? '0.00') ?></div>
        </div>
        <div class="kpi-card morosidad">
            <div class="kpi-title">ÍNDICE DE MOROSIDAD</div>
            <div class="kpi-value"><?= htmlspecialchars($kpis['indice_morosidad'] ?? '0.0%') ?></div>
        </div>
        <div class="kpi-card tickets">
            <div class="kpi-title">SOPORTES PENDIENTES</div>
            <div class="kpi-value"><?= htmlspecialchars($kpis['tickets_pendientes'] ?? 0) ?></div>
        </div>
    </div>

    <div class="charts-row">
        <div class="dashboard-block">
            <div class="block-title">Distribución de Clientes por Plan</div>
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
                                <td colspan="3">No hay órdenes de trabajo registradas.</td>
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
                                <td colspan="2">No hay planes en el sistema.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    
    // Configuración Gráfica de Barras (Planes)
    const datosPlanes = <?= json_encode($dataPlanes) ?>;
    const labelsPlanes = datosPlanes.map(p => p.nombre_plan || 'Sin Nombre');
    const valoresPlanes = datosPlanes.map(p => parseInt(p.cantidad) || 0);

    const ctxCrecimiento = document.getElementById('canvasCrecimiento');
    if (ctxCrecimiento) {
        new Chart(ctxCrecimiento.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelsPlanes,
                datasets: [{
                    label: 'Clientes en el Plan',
                    data: valoresPlanes,
                    backgroundColor: '#4e73df',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { 
                    y: { beginAtZero: true, ticks: { stepSize: 1 } } 
                }
            }
        });
    }

    // Configuración Gráfica Perimetral / Dona (Conexiones)
    const datosConexiones = <?= json_encode($dataConexiones) ?>;
    const labelsConexiones = datosConexiones.map(c => c.estado || 'Desconocido');
    const valoresConexiones = datosConexiones.map(c => parseInt(c.cantidad) || 0);

    const ctxDistribucion = document.getElementById('canvasDistribucion');
    if (ctxDistribucion) {
        new Chart(ctxDistribucion.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labelsConexiones,
                datasets: [{
                    data: valoresConexiones,
                    backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom' } 
                }
            }
        });
    }
});
</script>