<?php
require_once '../../models/EstadisticasModel.php';

class EstadisticasController {
    private $model;

    public function __construct() {
        $this->model = new EstadisticasModel();
    }

    // 🔥 Retorna los datos limpios en JSON para Highcharts
    public function obtenerMetricasAjax() {
        header('Content-Type: application/json');
        
        $kpis = $this->model->getResumenKpi();
        $planes = $this->model->getClientesPorPlan();
        $pagos = $this->model->getIngresosPorMetodo();

        echo json_encode([
            'status' => 'success',
            'kpis' => $kpis,
            'planes' => $planes,
            'pagos' => $pagos
        ]);
        exit;
    }
}

// Escuchador para peticiones en tiempo real (AJAX)
if (isset($_GET['action']) && $_GET['action'] === 'getLiveMetrics') {
    $controller = new EstadisticasController();
    $controller->obtenerMetricasAjax();
}