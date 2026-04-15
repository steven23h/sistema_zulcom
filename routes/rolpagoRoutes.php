<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/pdfGenerator.php';

class RolPagoController {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    /* ==============================
       OBTENER COLABORADORES
    ============================== */
    public function obtenerColaboradores(){

        try{

            $sql = "SELECT 
                        id AS id_trabajador,
                        nombres,
                        apellidos,
                        role AS cargo
                    FROM users
                    ORDER BY nombres ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($usuarios);

        }catch(Exception $e){

            http_response_code(500);
            echo json_encode(["mensaje"=>"Error al obtener colaboradores"]);

        }

    }


    /* ==============================
       LISTAR ROLES DE PAGO
    ============================== */
    public function listarRoles(){

        try{

            $mes = $_GET['mes'] ?? null;
            $colaborador = $_GET['colaborador'] ?? null;

            $query = "
                SELECT 
                    r.*,
                    u.nombres,
                    u.apellidos,
                    u.role AS cargo
                FROM roles_pago r
                JOIN users u ON r.id_trabajador = u.id
            ";

            $conditions = [];
            $params = [];

            if($mes){
                $conditions[] = "r.periodo = ?";
                $params[] = $mes;
            }

            if($colaborador){
                $conditions[] = "r.id_trabajador = ?";
                $params[] = $colaborador;
            }

            if(count($conditions) > 0){
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);

            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($roles);

        }catch(Exception $e){

            http_response_code(500);
            echo json_encode(["mensaje"=>"Error al listar roles"]);

        }

    }


    /* ==============================
       CREAR ROL DE PAGO
    ============================== */
    public function crearRol(){

        try{

            $id_trabajador = $_POST['id_trabajador'];
            $salario = floatval($_POST['salario']);
            $horas_extra = floatval($_POST['horas_extra'] ?? 0);
            $decimos = floatval($_POST['decimos'] ?? 0);
            $bonos = floatval($_POST['bonos'] ?? 0);
            $descuentos = floatval($_POST['descuentos'] ?? 0);
            $periodo = $_POST['periodo'];

            $horasMes = 240;
            $valorHora = $salario / $horasMes;

            $pagoHorasExtra = $horas_extra * $valorHora * 1.5;

            $aporte_iess = round($salario * 0.0945,2);
            $aporte_empleador = round($salario * 0.1115,2);

            $total = $salario +
                     $pagoHorasExtra +
                     $decimos +
                     $bonos -
                     $descuentos -
                     $aporte_iess;

            $sql = "INSERT INTO roles_pago
                    (id_trabajador, salario, horas_extra, valor_horas_extras, decimos,
                     bonos, descuentos, aporte_iess, aporte_empleador, total, periodo, estado)
                    VALUES
                    (?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                $id_trabajador,
                $salario,
                $horas_extra,
                $pagoHorasExtra,
                $decimos,
                $bonos,
                $descuentos,
                $aporte_iess,
                $aporte_empleador,
                $total,
                $periodo,
                'generado'
            ]);

            echo json_encode(["mensaje"=>"Rol creado correctamente"]);

        }catch(Exception $e){

            http_response_code(500);
            echo json_encode(["mensaje"=>"Error al crear rol"]);

        }

    }


    /* ==============================
       GENERAR PDF
    ============================== */
    public function generarPDF(){

        $id_trabajador = $_GET['id_trabajador'];

        $sqlUser = "SELECT id,nombres,apellidos,cedula,role AS cargo,fecha_ingreso
                    FROM users
                    WHERE id=?";

        $stmt = $this->db->prepare($sqlUser);
        $stmt->execute([$id_trabajador]);

        $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);

        $sqlRoles = "SELECT * FROM roles_pago
                     WHERE id_trabajador=?
                     ORDER BY id DESC";

        $stmt = $this->db->prepare($sqlRoles);
        $stmt->execute([$id_trabajador]);

        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        generarPDFColaborador($colaborador,$roles,$id_trabajador);

    }

}



/* ==================================
   ROUTER PHP (equivalente Express)
================================== */

$controller = new RolPagoController();

$action = $_GET['action'] ?? '';

switch($action){

    case "colaboradores":
        $controller->obtenerColaboradores();
    break;

    case "listar":
        $controller->listarRoles();
    break;

    case "crear":
        $controller->crearRol();
    break;

    case "pdf":
        $controller->generarPDF();
    break;

}