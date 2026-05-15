<?php

require_once __DIR__ . '/fpdf.php';
$logoPath = __DIR__ . '/../public/img/logo.png';

function toNumber($value){
    return is_numeric($value) ? floatval($value) : 0;
}

// 🔥 helper para no repetir utf8_decode
function t($texto){
    return utf8_decode($texto);
}

function generarPDFColaborador($colaborador,$roles,$id){

    if(!$roles || count($roles)==0){

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(0,20,t('No hay roles de pago disponibles.'),0,1);

        $pdf->Output('D', "rol_pago_$id.pdf");
        return;
    }

    $pdf = new FPDF();
    $pdf->AddPage();

    $morado = [68,63,204];

    // ==============================
    // LOGO
    // ==============================
    $logoPath = __DIR__ . '/../public/img/logo.png';
    if(file_exists($logoPath)){
        $pdf->Image($logoPath,10,10,25);
    }

    // ==============================
    // ENCABEZADO
    // ==============================
    $pdf->SetTextColor($morado[0],$morado[1],$morado[2]);


    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY(150,15);
    $pdf->Cell(0,10,t('COMPROBANTE DE PAGO'),0,0,'R');

    // Línea
    $pdf->SetDrawColor($morado[0],$morado[1],$morado[2]);
    $pdf->SetLineWidth(0.8);
    $pdf->Line(10,35,200,35);

    // ==============================
    // DATOS COLABORADOR
    // ==============================
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',11);

    $nombreCompleto = $colaborador['nombres']." ".$colaborador['apellidos'];
    $cedula = $colaborador['cedula'] ?? 'N/A';
    $cargo = $colaborador['cargo'] ?? 'N/A';

    $fechaIngreso = isset($colaborador['fecha_ingreso'])
        ? date('d/m/Y',strtotime($colaborador['fecha_ingreso']))
        : 'N/A';

    $pdf->SetXY(10,45);
    $pdf->Cell(100,8,t("Colaborador: $nombreCompleto"));

    $pdf->SetXY(10,53);
    $pdf->Cell(100,8,t("Cédula: $cedula"));

    $pdf->SetXY(110,45);
    $pdf->Cell(90,8,t("Cargo: $cargo"));

    $pdf->SetXY(110,53);
    $pdf->Cell(90,8,t("Fecha Ingreso: $fechaIngreso"));

    $pdf->SetXY(10,61);
    $pdf->Cell(100,8,t("Fecha emisión: ".date('d/m/Y H:i')));

    // ==============================
    // DATOS DEL ROL
    // ==============================
    $rol = $roles[0];

    $salario = toNumber($rol['salario']);
    $horas = toNumber($rol['horas_extra']);
    $valorHE = toNumber($rol['valor_horas_extras']);
    $bonos = toNumber($rol['bonos']);
    $descuentos = toNumber($rol['descuentos']);
    $iess = toNumber($rol['aporte_iess']);
    $empleador = toNumber($rol['aporte_empleador']);
    $total = toNumber($rol['total']);

    // ==============================
    // TITULOS
    // ==============================
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor($morado[0],$morado[1],$morado[2]);

    $pdf->SetXY(10,75);
    $pdf->Cell(90,8,'HABERES');

    $pdf->SetXY(110,75);
    $pdf->Cell(90,8,'DESCUENTOS');

    // ==============================
    // CONTENIDO
    // ==============================
    $pdf->SetFont('Arial','',11);
    $pdf->SetTextColor(0,0,0);

    $y = 85;

    // HABERES
    $pdf->SetXY(10,$y);
    $pdf->Cell(60,8,t('Salario:'));
    $pdf->Cell(30,8,'$'.number_format($salario,2),0,1);

    $pdf->SetX(10);
    $pdf->Cell(60,8,t('Horas extra:'));
    $pdf->Cell(30,8,$horas.' horas',0,1);

    $pdf->SetX(10);
    $pdf->Cell(60,8,t('Valor horas extra:'));
    $pdf->Cell(30,8,'$'.number_format($valorHE,2),0,1);

    $pdf->SetX(10);
    $pdf->Cell(60,8,t('Bonos:'));
    $pdf->Cell(30,8,'$'.number_format($bonos,2),0,1);

    // DESCUENTOS
    $pdf->SetXY(110,$y);
    $pdf->Cell(60,8,t('Descuentos:'));
    $pdf->Cell(30,8,'$'.number_format($descuentos,2),0,1);

    $pdf->SetX(110);
    $pdf->Cell(60,8,t('Aporte IESS:'));
    $pdf->Cell(30,8,'$'.number_format($iess,2),0,1);

    $pdf->SetX(110);
    $pdf->Cell(60,8,t('Aporte Empleador:'));
    $pdf->Cell(30,8,'$'.number_format($empleador,2),0,1);

    // ==============================
    // TOTAL
    // ==============================
    $pdf->SetFont('Arial','B',14);
    $pdf->SetTextColor($morado[0],$morado[1],$morado[2]);

    $pdf->SetXY(10,130);
    $pdf->Cell(0,10,t("TOTAL A PAGAR: $").number_format($total,2));

    // ==============================
    // CUADRO LEGAL
    // ==============================
    $pdf->Rect(10,145,190,20);

    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(12,150);
    $pdf->MultiCell(185,5,
        t('Declaro haber recibido conforme el pago correspondiente al periodo indicado, de acuerdo con la legislación laboral vigente.')
    );

    // ==============================
    // FIRMAS
    // ==============================
    $pdf->Line(20,180,80,180);
    $pdf->SetXY(20,182);
    $pdf->Cell(60,10,t('Firma Empleado'));

    $pdf->Line(120,180,180,180);
    $pdf->SetXY(120,182);
    $pdf->Cell(60,10,t('Firma Gerente'));

    $pdf->Output('D', "rol_pago_$id.pdf");
}