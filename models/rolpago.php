<?php

class RolPago {

    private $db;
    private $table = "roles_pago";

    public function __construct($db){
        $this->db = $db;
    }

    // ==============================
    // CREAR ROL DE PAGO
    // ==============================
    public function create($data){

        $sql = "INSERT INTO {$this->table}
        (id_trabajador, horas_extra, decimos, bonos, descuentos, salario,
        aporte_iess, aporte_empleador, total, periodo, estado, created_at)
        VALUES (:id_trabajador, :horas_extra, :decimos, :bonos, :descuentos, :salario,
        :aporte_iess, :aporte_empleador, :total, :periodo, :estado, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_trabajador' => $data['id_trabajador'],
            ':horas_extra' => $data['horas_extra'],
            ':decimos' => $data['decimos'],
            ':bonos' => $data['bonos'],
            ':descuentos' => $data['descuentos'],
            ':salario' => $data['salario'],
            ':aporte_iess' => $data['aporte_iess'],
            ':aporte_empleador' => $data['aporte_empleador'],
            ':total' => $data['total'],
            ':periodo' => $data['periodo'],
            ':estado' => $data['estado']
        ]);
    }

    // ==============================
    // OBTENER TODOS LOS ROLES
    // ==============================
    public function getAll(){

        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==============================
    // OBTENER POR TRABAJADOR
    // ==============================
    public function getByTrabajador($id_trabajador){

        $sql = "SELECT * FROM {$this->table}
                WHERE id_trabajador = ?
                ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_trabajador]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==============================
    // FILTROS (MES / COLABORADOR)
    // ==============================
    public function getWithFilters($mes = null, $colaborador = null){

        $query = "
        SELECT r.*, u.nombres, u.apellidos, u.role AS cargo
        FROM roles_pago r
        JOIN users u ON r.id_trabajador = u.id
        ";

        $where = [];
        $params = [];

        if($colaborador){
            $where[] = "r.id_trabajador = ?";
            $params[] = $colaborador;
        }

        if($mes){
            $where[] = "r.periodo = ?";
            $params[] = $mes;
        }

        if(count($where) > 0){
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $query .= " ORDER BY r.periodo DESC, r.id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}