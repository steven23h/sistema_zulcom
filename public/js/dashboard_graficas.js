document.addEventListener("DOMContentLoaded", function () {
    let chartCrecimiento = null;
    let chartDistribucion = null;

    const urlControlador = '../../controllers/EstadisticasController.php';

    function actualizarDashboard() {
        fetch(urlControlador)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // 1. Población de KPIs Reales
                    document.getElementById('kpi-clientes-totales').innerText = data.kpis.clientes_totales;
                    document.getElementById('kpi-total-recaudado').innerText = '$' + parseFloat(data.kpis.total_recaudado).toFixed(2);
                    document.getElementById('kpi-indice-morosidad').innerText = data.kpis.indice_morosidad;
                    document.getElementById('kpi-tickets-pendientes').innerText = data.kpis.tickets_pendientes;

                    // 2. Procesamiento Gráfico 1: Clientes por Plan (Barras)
                    const ctxCrecimiento = document.getElementById('canvasCrecimiento');
                    if (ctxCrecimiento) {
                        const labelsPlanes = data.planes.map(p => p.nombre_plan);
                        const valoresPlanes = data.planes.map(p => p.cantidad);

                        if (chartCrecimiento) chartCrecimiento.destroy();
                        chartCrecimiento = new Chart(ctxCrecimiento.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: labelsPlanes,
                                datasets: [{
                                    label: 'Clientes Registrados',
                                    data: valoresPlanes,
                                    backgroundColor: '#4e73df',
                                    borderRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                            }
                        });
                    }

                    // 3. Procesamiento Gráfico 2: Estado de Conexiones (Dona)
                    const ctxDistribucion = document.getElementById('canvasDistribucion');
                    if (ctxDistribucion) {
                        const labelsConexiones = data.conexiones.map(c => c.estado);
                        const valoresConexiones = data.conexiones.map(c => c.cantidad);

                        if (chartDistribucion) chartDistribucion.destroy();
                        chartDistribucion = new Chart(ctxDistribucion.getContext('2d'), {
                            type: 'doughnut',
                            data: {
                                labels: labelsConexiones,
                                datasets: [{
                                    data: valoresConexiones,
                                    backgroundColor: ['#1cc88a', '#e74a3b'] // Verde para Activos, Rojo para Inactivos
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { position: 'bottom' } }
                            }
                        });
                    }
                }
            })
            .catch(error => console.error("Error al procesar la métrica en tiempo real:", error));
    }

    // Primera carga inmediata al abrir el panel
    actualizarDashboard();
    
    // Consulta la base de datos automáticamente cada 8 segundos para detectar cambios
    setInterval(actualizarDashboard, 8000);
});