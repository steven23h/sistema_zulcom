<?php
require_once '../../config/database.php';

class EstadisticasModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // 📊 1. Datos para las tarjetas KPI superiores
    public function getResumenKpi() {
        // Clientes activos
        $st1 = $this->db->query("SELECT COUNT(*) as total FROM clientes WHERE estado = 'Activo'");
        $cActivos = $st1->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Total Recaudado en Facturas
        $st2 = $this->db->query("SELECT SUM(monto) as total FROM facturas");
        $recaudado = $st2->fetch(PDO::FETCH_ASSOC)['total'] ?? 0.00;

        // Tickets abiertos o pendientes
        $st3 = $this->db->query("SELECT COUNT(*) as total FROM tickets WHERE estado = 'abierto' OR estado = ''");
        $tPendientes = $st3->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return [
            'clientes_activos' => $cActivos,
            'total_recaudado'  => number_format($recaudado, 2, '.', ''),
            'tickets_activos'  => $tPendientes
        ];
    }

    // 🥧 2. Clientes por Plan (Gráfico de Pastel 3D)
    public function getClientesPorPlan() {
        $sql = "SELECT p.nombre_plan, COUNT(c.id_cliente) as cantidad 
                FROM planes p 
                LEFT JOIN clientes c ON p.id_plan = c.id_plan 
                GROUP BY p.id_plan";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // 📈 3. Montos por Forma de Pago (Gráfico de Columnas 3D)
    public function getIngresosPorMetodo() {
        $sql = "SELECT forma_pago, SUM(monto) as total FROM facturas GROUP BY forma_pago";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}