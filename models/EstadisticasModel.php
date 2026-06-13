<?php
require_once '../../config/database.php';

class EstadisticasModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getResumenKpi() {
        // 1. Clientes Totales (Contamos todos los registros de la tabla clientes)
        $st1 = $this->db->query("SELECT COUNT(*) as total FROM clientes");
        $clientesTotales = $st1->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // 2. Recaudación Mensual (Suma real de la tabla facturas)
        $st2 = $this->db->query("SELECT SUM(monto) as total FROM facturas");
        $recaudado = $st2->fetch(PDO::FETCH_ASSOC)['total'] ?? 0.00;

        // 3. Índice de Morosidad Real (Porcentaje de clientes 'Inactivos' del total)
        $st3 = $this->db->query("SELECT COUNT(*) as inactivos FROM clientes WHERE estado = 'Inactivo'");
        $clientesInactivos = $st3->fetch(PDO::FETCH_ASSOC)['inactivos'] ?? 0;
        
        $indiceMorosidad = 0.0;
        if ($clientesTotales > 0) {
            $indiceMorosidad = ($clientesInactivos / $clientesTotales) * 100;
        }

        // 4. Soportes Pendientes (Tickets cuyo estado NO sea 'completado' ni 'cerrado')
        $st4 = $this->db->query("SELECT COUNT(*) as total FROM tickets WHERE estado NOT IN ('completado', 'cerrado')");
        $tPendientes = $st4->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return [
            'clientes_totales'   => $clientesTotales,
            'total_recaudado'    => number_format($recaudado, 2, '.', ''),
            'indice_morosidad'   => number_format($indiceMorosidad, 1, '.', '') . '%',
            'tickets_pendientes' => $tPendientes
        ];
    }

    public function getClientesPorPlan() {
        // Agrupa y cuenta cuántos clientes reales pertenecen a cada plan configurado
        $sql = "SELECT p.nombre_plan, COUNT(c.id_cliente) as cantidad 
                FROM planes p 
                LEFT JOIN clientes c ON p.id_plan = c.id_plan 
                GROUP BY p.id_plan";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getEstadoConexiones() {
        // Muestra la proporción exacta de tus conexiones basadas en el ENUM 'Activo'/'Inactivo'
        $sql = "SELECT estado, COUNT(*) as cantidad FROM clientes GROUP BY estado";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}