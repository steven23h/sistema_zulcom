<?php
class Cliente {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los clientes con el nombre de su plan
    public function getAll() {
        $sql = "SELECT c.*, p.nombre_plan 
                FROM clientes c 
                LEFT JOIN planes p ON c.id_plan = p.id_plan 
                ORDER BY c.id_cliente DESC";
                
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // MÉTODO UPDATE CORREGIDO (Mapea todos los campos del formulario)
    public function update($data) {
        $sql = "UPDATE clientes SET 
                estado = ?, ip = ?, cedula = ?, apellido = ?, nombre = ?, 
                telefono1 = ?, telefono2 = ?, correo = ?, id_plan = ?, discapacidad = ?, 
                coordenadas = ?, parroquia = ?, canton = ?, ciudad = ?, provincia = ?, 
                direccion = ?, referencias = ?
                WHERE id_cliente = ?";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['estado'], 
            $data['ip'], 
            $data['cedula'], 
            $data['apellido'], 
            $data['nombre'],
            $data['telefono1'], 
            $data['telefono2'] ?? null, 
            $data['correo'], 
            $data['id_plan'], 
            $data['discapacidad'], 
            $data['coordenadas'] ?? null, 
            $data['parroquia'], 
            $data['canton'], 
            $data['ciudad'], 
            $data['provincia'], 
            $data['direccion'], 
            $data['referencias'] ?? null,
            $data['id_cliente']
        ]);
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM clientes WHERE id_cliente = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false; 
        }
    }

    public function getById($id) {
        $sql = "SELECT c.*, p.nombre_plan 
                FROM clientes c 
                LEFT JOIN planes p ON c.id_plan = p.id_plan 
                WHERE c.id_cliente = ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerNoDeudores() {
        $mesActual = date('m');
        $anioActual = date('Y');
        
        $query = "SELECT c.*, p.nombre_plan, f.fecha_pago 
                  FROM clientes c
                  INNER JOIN planes p ON c.id_plan = p.id_plan
                  INNER JOIN facturas f ON c.id_cliente = f.id_cliente
                  WHERE MONTH(f.fecha_pago) = :mes 
                  AND YEAR(f.fecha_pago) = :anio 
                  AND c.estado = 'Activo'
                  GROUP BY c.id_cliente";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute(['mes' => $mesActual, 'anio' => $anioActual]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDeudores() {
        $mesActual = date('m');
        $anioActual = date('Y');
        
        $query = "SELECT c.*, p.nombre_plan 
                  FROM clientes c
                  INNER JOIN planes p ON c.id_plan = p.id_plan
                  WHERE c.id_cliente NOT IN (
                      SELECT id_cliente 
                      FROM facturas 
                      WHERE MONTH(fecha_pago) = :mes 
                      AND YEAR(fecha_pago) = :anio
                  ) AND c.estado = 'Activo'";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute(['mes' => $mesActual, 'anio' => $anioActual]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO clientes (
            ip, apellido, nombre, cedula, correo, telefono1, telefono2, 
            direccion, coordenadas, parroquia, canton, ciudad, provincia, 
            discapacidad, referencias, id_plan, estado
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['ip'], $data['apellido'], $data['nombre'], $data['cedula'], 
            $data['correo'], $data['telefono1'], $data['telefono2'] ?? null, 
            $data['direccion'], $data['coordenadas'] ?? null, $data['parroquia'], 
            $data['canton'], $data['ciudad'], $data['provincia'], 
            $data['discapacidad'], $data['referencias'] ?? null, $data['id_plan'], 
            $data['estado']
        ]);
    }
}