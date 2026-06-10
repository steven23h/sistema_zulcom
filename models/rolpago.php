<?php

require_once __DIR__ . '/../config/database.php';

class RolPago
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // ==========================
    // CREAR ROL
    // ==========================
    public function crear($datos)
    {
        $stmt = $this->db->prepare("

            INSERT INTO roles_pago
            (
                id_trabajador,
                periodo,
                salario,
                horas_extra,
                valor_horas_extras,
                decimos,
                aporte_iess,
                aporte_empleador,
                bonos,
                descuentos,
                total,
                estado
            )

            VALUES
            (
                ?,?,?,?,?,?,?,?,?,?,?,?
            )

        ");

        return $stmt->execute([

            $datos['id_trabajador'],
            $datos['periodo'],
            $datos['salario'],
            $datos['horas_extra'],
            $datos['valor_horas_extras'],
            $datos['decimos'],
            $datos['aporte_iess'],
            $datos['aporte_empleador'],
            $datos['bonos'],
            $datos['descuentos'],
            $datos['total'],
            $datos['estado']

        ]);
    }

    // ==========================
    // LISTAR ROLES
    // ==========================
    public function listar()
    {
        $stmt = $this->db->query("

            SELECT *
            FROM roles_pago
            ORDER BY id DESC

        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // OBTENER POR ID TRABAJADOR
    // ==========================
    public function obtenerPorTrabajador($id_trabajador)
    {
        $stmt = $this->db->prepare("

            SELECT *
            FROM roles_pago
            WHERE id_trabajador = ?
            ORDER BY id DESC

        ");

        $stmt->execute([$id_trabajador]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminar($id)
    {
        $stmt = $this->db->prepare("
        DELETE FROM roles_pago
        WHERE id = ?
    ");

        return $stmt->execute([$id]);
    }
}
