<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/pdfGenerator.php';

class RolPagoController {

    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // ==============================
    // CREAR ROL DE PAGO
    // ==============================
    public function crearRolPago($post){

        try{

            $id_trabajador = $post['id_trabajador'];
            $salario = $post['salario'];
            $horas_extra = $post['horas_extra'] ?? 0;
            $decimos = $post['decimos'] ?? 0;
            $bonos = $post['bonos'] ?? 0;
            $descuentos = $post['descuentos'] ?? 0;
            $periodo = $post['periodo'];

            if(!$salario || !is_numeric($salario)){
                return ["mensaje"=>"Salario inválido"];
            }

            $salarioNum = floatval($salario);
            $horasExtrasNum = floatval($horas_extra);

            $horasTrabajadasAlMes = 240;
            $valorHoraNormal = $salarioNum / $horasTrabajadasAlMes;

            // pago horas extras 150%
            $pagoHorasExtra = $horasExtrasNum * $valorHoraNormal * 1.5;

            // aportes
            $aporte_iess = round($salarioNum * 0.0945,2);
            $aporte_empleador = round($salarioNum * 0.1115,2);

            // total
            $total =
                $salarioNum +
                $pagoHorasExtra +
                floatval($decimos) +
                floatval($bonos) -
                floatval($descuentos) -
                $aporte_iess;

            $stmt = $this->db->prepare("

                INSERT INTO roles_pago
                (id_trabajador,periodo,salario,horas_extra,valor_horas_extras,
                decimos,aporte_iess,aporte_empleador,bonos,descuentos,total,estado)

                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)

            ");

            $stmt->execute([
                $id_trabajador,
                $periodo,
                $salarioNum,
                $horasExtrasNum,
                round($pagoHorasExtra,2),
                floatval($decimos),
                $aporte_iess,
                $aporte_empleador,
                floatval($bonos),
                floatval($descuentos),
                round($total,2),
                "generado"
            ]);

            return ["mensaje"=>"Rol generado correctamente"];

        }catch(Exception $e){

            return ["mensaje"=>"Error al generar rol"];

        }

    }



    // ==============================
    // LISTAR COLABORADORES
    // ==============================
    public function listarColaboradores(){

        $stmt = $this->db->prepare("

            SELECT 
            id AS id_trabajador,
            nombres,
            apellidos,
            role AS cargo

            FROM users

            WHERE role IN ('Tecnico','Administracion')

            ORDER BY nombres ASC

        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // ==============================
    // LISTAR ROLES DE PAGO
    // ==============================
    public function listarRolesPago($mes=null,$colaborador=null){

        session_start();

        $query = "

        SELECT r.*, u.nombres, u.apellidos, u.role AS cargo

        FROM roles_pago r

        JOIN users u ON r.id_trabajador = u.id

        ";

        $where = [];
        $params = [];

        if(isset($_SESSION['usuario'])){

            $rol = $_SESSION['usuario']['role'];

            if($rol=='Tecnico' || $rol=='Administracion'){

                $where[] = "r.id_trabajador = ?";
                $params[] = $_SESSION['usuario']['id'];

            }

        }else{

            if($colaborador){

                $where[] = "r.id_trabajador = ?";
                $params[] = $colaborador;

            }

        }

        if($mes){

            $where[] = "r.periodo = ?";
            $params[] = $mes;

        }

        if(count($where)>0){

            $query .= " WHERE ".implode(" AND ",$where);

        }

        $query .= " ORDER BY r.periodo DESC, r.id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }



    // ==============================
    // GENERAR PDF
    // ==============================
    public function generarPDF($id_trabajador){

        $stmt = $this->db->prepare("

        SELECT id,nombres,apellidos,cedula,role AS cargo, fecha_ingreso
         FROM users
         WHERE id=?

        ");

        $stmt->execute([$id_trabajador]);

        $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$colaborador){
            return ["mensaje"=>"Colaborador no encontrado"];
        }

        $stmt = $this->db->prepare("

        SELECT *

        FROM roles_pago

        WHERE id_trabajador=?

        ORDER BY id DESC

        ");

        $stmt->execute([$id_trabajador]);

        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$roles){
            return ["mensaje"=>"No hay roles para este colaborador"];
        }

        generarPDFColaborador($colaborador,$roles,$id_trabajador);

    }

}