<?php
class Factura {
    private $db;

    public function __construct() {
        $this->db = Database::connect(); 
    }

    public function guardar($data) {
        $sql = "INSERT INTO facturas (id_cliente, numero_recibo, monto, forma_pago, concepto, fecha) 
                VALUES (?, ?, ?, ?, ?, NOW())"; // Agregamos fecha automática
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['id_cliente'], 
            $data['numero_recibo'], 
            $data['monto'], 
            $data['forma_pago'], 
            $data['concepto']
        ]);
        return $this->db->lastInsertId(); // IMPORTANTE: Retorna el ID generado
    }

    // Cambiamos el nombre para que coincida con el controlador
    public function obtenerUltimoId() {
        $sql = "SELECT id_factura FROM facturas ORDER BY id_factura DESC LIMIT 1";
        $res = $this->db->query($sql);
        $fila = $res->fetch(PDO::FETCH_ASSOC);
        return $fila ? $fila['id_factura'] : 0; // Si no hay facturas, empieza en 0
    }
}