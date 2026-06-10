<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/pdfGenerator.php';
require_once __DIR__ . '/../models/rolpago.php';


class RolPagoController
{

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // ==============================
    // CREAR ROL DE PAGO
    // ==============================
    public function crearRolPago($post)
    {

        try {

            $id_trabajador = intval($post['id_trabajador']);
            $salario = floatval($post['salario']);

            $horas_extra = floatval($post['horas_extra'] ?? 0);
            $decimos = floatval($post['decimos'] ?? 0);
            $bonos = floatval($post['bonos'] ?? 0);
            $descuentos = floatval($post['descuentos'] ?? 0);

            $periodo = trim($post['periodo']);

            $valorHoraNormal = $salario / 240;
            $pagoHorasExtra = $horas_extra * $valorHoraNormal * 1.5;

            $aporte_iess = round($salario * 0.0945, 2);
            $aporte_empleador = round($salario * 0.1115, 2);

            $total =
                $salario +
                $pagoHorasExtra +
                $decimos +
                $bonos -
                $descuentos -
                $aporte_iess;

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

            $stmt->execute([
                $id_trabajador,
                $periodo,
                $salario,
                $horas_extra,
                round($pagoHorasExtra, 2),
                $decimos,
                $aporte_iess,
                $aporte_empleador,
                $bonos,
                $descuentos,
                round($total, 2),
                'generado'
            ]);

            return [
                "mensaje" => "✅ Rol de pago generado correctamente"
            ];
        } catch (Exception $e) {

            return [
                "success" => false,
                "mensaje" => $e->getMessage()
            ];
        }
    }

    public function listarColaboradores()
    {
        $rolModel = new RolPago();

        return $rolModel->listarColaboradores();
    }


    public function listarRolesPago($mes = null, $colaborador = null)
    {
        $rolModel = new RolPago();

        return $rolModel->listarRolesPago($mes, $colaborador);
    }



    // ==============================
    // GENERAR PDF
    // ==============================
    public function generarPDF($id_trabajador)
    {

        $stmt = $this->db->prepare("

        SELECT id,nombres,apellidos,cedula,role AS cargo, fecha_ingreso
         FROM users
         WHERE id=?

        ");

        $stmt->execute([$id_trabajador]);

        $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$colaborador) {
            return ["mensaje" => "Colaborador no encontrado"];
        }

        $stmt = $this->db->prepare("

        SELECT *

        FROM roles_pago

        WHERE id_trabajador=?

        ORDER BY id DESC

        ");

        $stmt->execute([$id_trabajador]);

        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$roles) {
            return ["mensaje" => "No hay roles para este colaborador"];
        }

        generarPDFColaborador($colaborador, $roles, $id_trabajador);
    }

    // ==============================
    // ELIMINAR ROL
    // ==============================
    public function eliminarRol($id)
    {
        $rolModel = new RolPago();

        return $rolModel->eliminar($id);
    }
}
