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

            $datos = [
                'id_trabajador'      => $id_trabajador,
                'periodo'            => $periodo,
                'salario'            => $salario,
                'horas_extra'        => $horas_extra,
                'valor_horas_extras' => round($pagoHorasExtra, 2),
                'decimos'            => $decimos,
                'aporte_iess'        => $aporte_iess,
                'aporte_empleador'   => $aporte_empleador,
                'bonos'              => $bonos,
                'descuentos'         => $descuentos,
                'total'              => round($total, 2),
                'estado'             => 'generado'
            ];

            $rolModel = new RolPago();

            $rolModel->crear($datos);

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
        $rolModel = new RolPago();

        $colaborador = $rolModel->obtenerColaborador($id_trabajador);

        if (!$colaborador) {
            return ["mensaje" => "Colaborador no encontrado"];
        }

        $roles = $rolModel->obtenerRolesTrabajador($id_trabajador);

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
