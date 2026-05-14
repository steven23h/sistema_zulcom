<?php
// controllers/DocxController.php

require_once __DIR__ . '/../vendor/autoload.php'; 
require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Plan.php';

use PhpOffice\PhpWord\TemplateProcessor;



class DocxController {
    public function generateContract($id) {
        $database = new Database();
        $db = $database->connect();
        
        $clienteM = new Cliente($db);
        $planM = new Plan($db);

        // Obtener datos del cliente
        $cliente = $clienteM->getById($id);
        if (!$cliente) die("Error: Cliente no encontrado.");

        // Obtener datos del plan
        $plan = $planM->getById($cliente['id_plan']);

        // --- Configuración de Tiempos y Fechas ---
        // Seteamos la zona horaria de Ecuador
        date_default_timezone_set('America/Guayaquil');
        
        $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
        $fechaLarga = date('j') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $horaActual = date('H:i');

        // Ruta de tu plantilla (Asegúrate que el nombre sea exacto)
        $templatePath = __DIR__ . '/../templates/plantilla_contrato.docx';
        
        if (!file_exists($templatePath)) {
            die("Error: No se encuentra la plantilla en: templates/plantilla_contrato.docx");
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // --- REEMPLAZO DE TODAS LAS VARIABLES DEL DOCUMENTO ---
        $templateProcessor->setValues([
            // Fechas y Horas
            'fecha_contrato' => $fechaLarga,
            'hora'           => $horaActual,
            'ciudad'         => $cliente['ciudad'],
            
            // Datos Personales
            'apellido'       => $cliente['apellido'],
            'nombre'         => $cliente['nombre'],
            'cedula'         => $cliente['cedula'],
            'correo'         => $cliente['correo'],
            'telefono1'      => $cliente['telefono1'],
            'telefono2'      => $cliente['telefono2'] ?? '',
            
            // Ubicación
            'direccion'      => $cliente['direccion'],
            'parroquia'      => $cliente['parroquia'],
            'canton'         => $cliente['canton'],
            'provincia'      => $cliente['provincia'],
            'coordenadas'    => $cliente['coordenadas'] ?? '',
            'referencias'    => $cliente['referencias'] ?? '',
            
            // Datos del Plan (Anexo 1F y Anexo 2)
            'nombre_plan'    => $plan['nombre_plan'] ?? 'Plan Estándar',
            'megas'          => $plan['megas'] ?? '0',
            'costo'          => number_format(($plan['costo'] ?? 0), 2),
            'plan'           => ($plan['nombre_plan'] ?? 'Internet') . " " . ($plan['megas'] ?? '0') . " Mbps",
            
            // Lógica de Discapacidad (SI/NO con X)
            'si__'           => ($cliente['discapacidad'] == 'si') ? 'X' : '',
            'si_x'           => ($cliente['discapacidad'] == 'si') ? '' : '___',
            'no__'           => ($cliente['discapacidad'] == 'no') ? 'X' : '',
            'no_x'           => ($cliente['discapacidad'] == 'no') ? '' : '___'
        ]);

        // --- Descarga del Archivo ---
        $fileName = "Contrato_Zulcom_" . $cliente['cedula'] . ".docx";
        
        // Limpiar cualquier residuo de salida previo
        if (ob_get_length()) ob_end_clean();

        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Cache-Control: max-age=0");
        
        $templateProcessor->saveAs('php://output');
        exit;
    }
}