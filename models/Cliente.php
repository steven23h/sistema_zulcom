<?php
class Cliente {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los clientes con el nombre de su plan (CORREGIDO)
    public function getAll() {
        // Usamos un LEFT JOIN para traer el nombre del plan desde la otra tabla
        $sql = "SELECT c.*, p.nombre_plan 
                FROM clientes c 
                LEFT JOIN planes p ON c.id_plan = p.id_plan 
                ORDER BY c.id_cliente DESC";
                
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update($data) {
    $sql = "UPDATE clientes SET 
            estado = ?, ip = ?, cedula = ?, apellido = ?, nombre = ?, 
            telefono1 = ?, correo = ?, id_plan = ?, discapacidad = ?, direccion = ?
            WHERE id_cliente = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        $data['estado'], $data['ip'], $data['cedula'], $data['apellido'], $data['nombre'],
        $data['telefono1'], $data['correo'], $data['id_plan'], $data['discapacidad'], $data['direccion'],
        $data['id_cliente']
    ]);
}
public function delete($id) {
    try {
        $sql = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Esto es útil si el cliente tiene facturas o registros asociados
        return false; 
    }
}

    // Obtener por ID con el nombre del plan (útil para el contrato)
    public function getById($id) {
        $sql = "SELECT c.*, p.nombre_plan 
                FROM clientes c 
                LEFT JOIN planes p ON c.id_plan = p.id_plan 
                WHERE c.id_cliente = ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // El método create se queda igual porque está bien
    public function create($data) {
        $sql = "INSERT INTO clientes (
            ip, apellido, nombre, cedula, correo, telefono1, telefono2, 
            direccion, coordenadas, parroquia, canton, ciudad, provincia, 
            discapacidad, referencias, id_plan, estado
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['ip'], $data['apellido'], $data['nombre'], $data['cedula'], 
            $data['correo'], $data['telefono1'], $data['telefono2'], 
            $data['direccion'], $data['coordenadas'], $data['parroquia'], 
            $data['canton'], $data['ciudad'], $data['provincia'], 
            $data['discapacidad'], $data['referencias'], $data['id_plan'], 
            $data['estado']
        ]);
    }
}