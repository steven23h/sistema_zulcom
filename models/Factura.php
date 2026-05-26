<?php
require_once __DIR__ . '/../config/database.php';

class Factura {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function obtenerUltimoId() {
        $sql = "SELECT id_factura FROM facturas ORDER BY id_factura DESC LIMIT 1";
        $res = $this->db->query($sql);
        $data = $res->fetch(PDO::FETCH_ASSOC);
        return $data ? $data['id_factura'] : 0;
    }

   public function guardar($data) {
    // Usamos 'fecha_pago' que es el nombre real en tu tabla
    $sql = "INSERT INTO facturas (id_cliente, numero_recibo, monto, forma_pago, concepto, fecha_pago) 
            VALUES (:id_cliente, :numero_recibo, :monto, :forma_pago, :concepto, NOW())";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($data);
    return $this->db->lastInsertId();
}

    public function obtenerFacturaPorId($id) {
        // Esta consulta es CLAVE: Une factura -> cliente -> planes
        $sql = "SELECT f.*, c.nombre, c.apellido, c.cedula, c.correo, p.nombre_plan 
                FROM facturas f 
                JOIN clientes c ON f.id_cliente = c.id_cliente 
                LEFT JOIN planes p ON c.id_plan = p.id_plan 
                WHERE f.id_factura = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}