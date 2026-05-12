<?php
class Ticket {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // 🔥 LISTAR TODOS
    public function getAll() {
        $sql = "SELECT t.*, 
                       c.nombre, c.apellido, c.cedula,
                       u.nombres AS tecnico_nombre, 
                       u.apellidos AS tecnico_apellido
                FROM tickets t
                LEFT JOIN clientes c ON t.id_cliente = c.id_cliente
                LEFT JOIN users u ON t.id_tecnico = u.id
                ORDER BY t.id DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔥 CREAR (solo agrego horaVisita)
    public function create($data) {

        $sqlNum = "SELECT COUNT(*) as total FROM tickets";
        $stmtNum = $this->db->query($sqlNum);
        $total = $stmtNum->fetch(PDO::FETCH_ASSOC)['total'] + 1;

        $numero_ticket = "TICK-" . str_pad($total, 4, "0", STR_PAD_LEFT);

        $sql = "INSERT INTO tickets 
                (numero_ticket, id_cliente, id_tecnico, tipo_problema, descripcion, horaVisita, estado, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $numero_ticket,
            $data['id_cliente'],
            $data['id_tecnico'],
            $data['tipo_problema'],
            $data['descripcion'],
            $data['horaVisita'],
            'Pendiente'
        ]);
    }

    // 🔥 ELIMINAR
    public function delete($id) {
        $sql = "DELETE FROM tickets WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // =====================================
    // 🔥 LO NUEVO (AQUÍ ESTÁ LO QUE TE FALTABA)
    // =====================================

    // 🔥 OBTENER POR ID (para editar y ver)
    public function getById($id) {
        $sql = "SELECT t.*, 
                       c.nombre, c.apellido, c.cedula, c.telefono1, c.direccion, c.correo
                FROM tickets t
                LEFT JOIN clientes c ON t.id_cliente = c.id_cliente
                WHERE t.id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔥 ACTUALIZAR (EDITAR)
    public function update($data) {
        $sql = "UPDATE tickets SET
                    id_cliente = ?,
                    id_tecnico = ?,
                    tipo_problema = ?,
                    descripcion = ?,
                    horaVisita = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['id_cliente'],
            $data['id_tecnico'],
            $data['tipo_problema'],
            $data['descripcion'],
            $data['horaVisita'],
            $data['id']
        ]);
    }

    // 🔥 TICKETS POR TECNICO
    public function getByTecnico($id_tecnico) {
        $sql = "SELECT t.*, 
                       c.nombre, c.apellido, c.cedula, c.telefono1, c.direccion, c.referencias
                FROM tickets t
                LEFT JOIN clientes c ON t.id_cliente = c.id_cliente
                WHERE t.id_tecnico = ?
                ORDER BY t.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_tecnico]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔥 RESOLVER TICKET (TECNICO)
    public function resolver($id, $data) {
        $sql = "UPDATE tickets SET 
                    solucion = ?, 
                    estado = ?, 
                    fecha_solucion = ?, 
                    hora_solucion = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['solution'],
            $data['status'],
            $data['solutionDate'],
            $data['solutionTime'],
            $id
        ]);
    }
}