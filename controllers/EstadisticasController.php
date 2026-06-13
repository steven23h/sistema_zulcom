<?php
require_once '../../models/EstadisticasModel.php';

class EstadisticasController {
    private $model;

    public function __construct() {
        $this->model = new EstadisticasModel();
    }

    public function obtenerMetricasAjax() {
        header('Content-Type: application/json');
        
        $kpis = $this->model->getResumenKpi();
        $planes = $this->model->getClientesPorPlan();
        $conexiones = $this->model->getEstadoConexiones();

        echo json_encode([
            'status'     => 'success',
            'kpis'       => $kpis,
            'planes'     => $planes,
            'conexiones' => $conexiones
        ]);
        exit;
    }
}

// Inicialización automática para peticiones AJAX
$controller = new EstadisticasController();
$controller->obtenerMetricasAjax();