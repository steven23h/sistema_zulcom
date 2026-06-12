document.addEventListener("DOMContentLoaded", function() {
    // 1. Obtener elementos de los Canvas
    const elCrecimiento = document.getElementById('canvasCrecimiento');
    const elDistribucion = document.getElementById('canvasDistribucion');

    // 2. Extraer los datos numéricos desde los atributos data-* del HTML
    const recaudacion = parseFloat(elCrecimiento.getAttribute('data-recaudacion')) || 0;
    const totalClientes = parseInt(elCrecimiento.getAttribute('data-clientes')) || 0;
    const clientesDeudores = parseInt(elDistribucion.getAttribute('data-deudores')) || 0;

    // Gráfico 1: Líneas (Crecimiento)
    const ctxCrecimiento = elCrecimiento.getContext('2d');
    new Chart(ctxCrecimiento, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Ingresos ($)',
                data: [150, 180, 210, 240, 260, recaudacion],
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.05)',
                tension: 0.3,
                fill: true
            }, {
                label: 'Clientes Activos',
                data: [20, 25, 31, 36, 39, totalClientes],
                borderColor: '#4e73df',
                backgroundColor: 'transparent',
                tension: 0.3,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, position: 'left' },
                y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
            }
        }
    });

    // Gráfico 2: Dona (Distribución de estados)
    const ctxDistribucion = elDistribucion.getContext('2d');
    new Chart(ctxDistribucion, {
        type: 'doughnut',
        data: {
            labels: ['Al Día', 'Deudores / Suspendidos'],
            datasets: [{
                data: [(totalClientes - clientesDeudores), clientesDeudores],
                backgroundColor: ['#1cc88a', '#e74a3b'],
                hoverOffset: 4
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
});