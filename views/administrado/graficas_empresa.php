<?php
// Evitar acceso directo si no está definido en el enrutador
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simulador de datos traídos del controlador
$totalClientes = 42; 
$clientesDeudores = 12;
$porcentajeMorosidad = ($totalClientes > 0) ? round(($clientesDeudores / $totalClientes) * 100, 1) : 0;
$recaudacionProyectada = 285.00;
$ticketsPendientes = 5;
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet" href="/zulcom2/public/css/dashboard_graficas.css">

<div class="dashboard-grid">

    <div class="kpi-container">
        <div class="kpi-card">
            <div class="kpi-title">Clientes Totales</div>
            <div class="kpi-value"><?php echo $totalClientes; ?></div>
        </div>
        <div class="kpi-card recaudacion">
            <div class="kpi-title">Recaudación Mensual</div>
            <div class="kpi-value">$<?php echo number_format($recaudacionProyectada, 2); ?></div>
        </div>
        <div class="kpi-card morosidad">
            <div class="kpi-title">Índice de Morosidad</div>
            <div class="kpi-value"><?php echo $porcentajeMorosidad; ?>%</div>
        </div>
        <div class="kpi-card tickets">
            <div class="kpi-title">Soportes Pendientes</div>
            <div class="kpi-value"><?php echo $ticketsPendientes; ?></div>
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
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>N° Ticket</th>
                        <th>Cliente</th>
                        <th>Descripción del Problema</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>#TICK-0005</strong></td>
                        <td>juan carlos lincango farinango</td>
                        <td>jejejejjejeje</td>
                    </tr>
                    <tr>
                        <td><strong>#TICK-0003</strong></td>
                        <td>juan carlos lincango farinango</td>
                        <td>saddadas</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="dashboard-block">
            <div class="block-title">Planes Configurados</div>
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Precio Mensual</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Plan Fibra 50 Mbps</td>
                        <td>$20.00</td>
                    </tr>
                    <tr>
                        <td>Plan Familiar 100 Mbps</td>
                        <td>$25.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script src="/zulcom2/public/js/dashboard_graficas.js"></script>