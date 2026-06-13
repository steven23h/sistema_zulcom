<?php
require_once '../../config/database.php';

class EstadisticasModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getResumenKpi() {
        $st1 = $this->db->query("SELECT COUNT(*) as total FROM clientes");
        $clientesTotales = (int)($st1->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

        $st2 = $this->db->query("SELECT SUM(monto) as total FROM facturas");
        $recaudadoResult = $st2->fetch(PDO::FETCH_ASSOC)['total'];
        $recaudado = $recaudadoResult !== null ? (float)$recaudadoResult : 0.00;

        $st3 = $this->db->query("SELECT COUNT(*) as inactivos FROM clientes WHERE estado = 'Inactivo'");
        $clientesInactivos = (int)($st3->fetch(PDO::FETCH_ASSOC)['inactivos'] ?? 0);
        
        $indiceMorosidad = 0.0;
        if ($clientesTotales > 0) {
            $indiceMorosidad = ($clientesInactivos / $clientesTotales) * 100;
        }

        $st4 = $this->db->query("SELECT COUNT(*) as total FROM tickets WHERE estado NOT IN ('completado', 'cerrado')");
        $tPendientes = (int)($st4->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

        return [
            'clientes_totales'   => $clientesTotales,
            'total_recaudado'    => number_format($recaudado, 2, '.', ''),
            'indice_morosidad'   => number_format($indiceMorosidad, 1, '.', '') . '%',
            'tickets_pendientes' => $tPendientes
        ];
    }

    public function getClientesPorPlan() {
        $sql = "SELECT p.nombre_plan, COUNT(c.id_cliente) as cantidad 
                FROM planes p 
                LEFT JOIN clientes c ON p.id_plan = c.id_plan 
                GROUP BY p.id_plan";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getEstadoConexiones() {
        $sql = "SELECT estado, COUNT(*) as cantidad FROM clientes GROUP BY estado";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}