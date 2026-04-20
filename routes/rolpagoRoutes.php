<?php

require_once __DIR__ . '/../controllers/RolPagoController.php';

$controller = new RolPagoController();

$action = $_GET['action'] ?? '';

switch($action){

    // ==============================
    // COLABORADORES
    // ==============================
    case "colaboradores":

        $data = $controller->listarColaboradores();
        echo json_encode($data);

    break;


    // ==============================
    // CREAR ROL
    // ==============================
    case "crear":

        $respuesta = $controller->crearRolPago($_POST);
        echo json_encode($respuesta);

    break;


    // ==============================
    // LISTAR ROLES
    // ==============================
    case "listar":

        $mes = $_GET['mes'] ?? null;
        $colaborador = $_GET['colaborador'] ?? null;

        $data = $controller->listarRolesPago($mes, $colaborador);
        echo json_encode($data);

    break;


    // ==============================
    // GENERAR PDF
    // ==============================
    case "pdf":

        $id = $_GET['id_trabajador'] ?? null;

        if($id){
            $controller->generarPDF($id);
        }else{
            echo "ID no enviado";
        }

    break;


    // ==============================
    // ERROR
    // ==============================
    default:
        http_response_code(404);
        echo json_encode(["mensaje"=>"Ruta no encontrada"]);
    break;

}