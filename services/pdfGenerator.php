<?php

require_once __DIR__ . '/fpdf/fpdf.php';

function toNumber($value){
    return is_numeric($value) ? floatval($value) : 0;
}

function generarPDFColaborador($colaborador,$roles,$id){

    if(!$roles || count($roles)==0){

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(0,20,'No hay roles de pago disponibles para este colaborador.',0,1);

        

        $pdf->Output('D', "rol_pago_$id.pdf");
        return;
    }

    $pdf = new FPDF();
    $pdf->AddPage();

    // Datos colaborador
    $nombreCompleto = $colaborador['nombres']." ".$colaborador['apellidos'];

    $fechaCreacion = date('d/m/Y H:i');

    $cedula = $colaborador['cedula'] ?? 'N/A';
    $cargo = $colaborador['cargo'] ?? 'N/A';

    $fechaIngreso = isset($colaborador['fecha_ingreso'])
        ? date('d/m/Y',strtotime($colaborador['fecha_ingreso']))
        : 'N/A';

    $morado = [68,63,204];

    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=rol_pago_$id.pdf");

    // Logo
    $logoPath = __DIR__ . '/../img/logo.png';

    if(file_exists($logoPath)){
        $pdf->Image($logoPath,50,45,20);
    }

    // Encabezado
    $pdf->SetTextColor($morado[0],$morado[1],$morado[2]);
    $pdf->SetFont('Arial','B',22);
    $pdf->SetXY(120,55);
    $pdf->Cell(0,10,'Zulcom Solutions S.A.');

    $pdf->SetFont('Arial','',10);
    $pdf->SetXY(120,70);
    $pdf->Cell(0,10,'RUC: 0999999999001');

    $pdf->SetFont('Arial','B',16);
    $pdf->SetXY(120,90);
    $pdf->Cell(0,10,'COMPROBANTE DE PAGO',0,0,'R');

    // Línea
    $pdf->SetDrawColor($morado[0],$morado[1],$morado[2]);
    $pdf->SetLineWidth(1);
    $pdf->Line(50,110,190,110);

    // Datos colaborador
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',11);

    $pdf->SetXY(50,120);
    $pdf->Cell(0,10,"Colaborador: $nombreCompleto");

    $pdf->SetXY(50,130);
    $pdf->Cell(0,10,"Cedula: $cedula");

    $pdf->SetXY(120,120);
    $pdf->Cell(0,10,"Cargo: $cargo");

    $pdf->SetXY(120,130);
    $pdf->Cell(0,10,"Fecha de Ingreso: $fechaIngreso");

    $pdf->SetXY(50,140);
    $pdf->Cell(0,10,"Fecha de Creacion: $fechaCreacion");

    // Datos del rol
    $rol = $roles[0];

    $salario = toNumber($rol['salario']);
    $cantidadHorasExtra = toNumber($rol['horas_extra']);
    $valorHorasExtra = toNumber($rol['valor_horas_extras']);
    $bonos = toNumber($rol['bonos']);
    $descuentos = toNumber($rol['descuentos']);
    $aporteIess = toNumber($rol['aporte_iess']);
    $aporteEmpleador = toNumber($rol['aporte_empleador']);
    $total = toNumber($rol['total']);

    $startY = 170;

    // Encabezados
    $pdf->SetFont('Arial','B',13);
    $pdf->SetTextColor($morado[0],$morado[1],$morado[2]);

    $pdf->SetXY(50,$startY);
    $pdf->Cell(80,10,'HABERES');

    $pdf->SetXY(120,$startY);
    $pdf->Cell(80,10,'DESCUENTOS');

    $startY += 10;

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',11);

    // Haberes
    $pdf->SetXY(50,$startY);
    $pdf->Cell(80,10,"Salario Basico:");
    $pdf->Cell(40,10,"$".number_format($salario,2),0,1,'R');

    $pdf->SetX(50);
    $pdf->Cell(80,10,"Horas extras trabajadas:");
    $pdf->Cell(40,10,"$cantidadHorasExtra horas",0,1,'R');

    $pdf->SetX(50);
    $pdf->Cell(80,10,"Pago horas extras:");
    $pdf->Cell(40,10,"$".number_format($valorHorasExtra,2),0,1,'R');

    // Descuentos
    $descY = $startY;

    $pdf->SetXY(120,$descY);
    $pdf->Cell(80,10,"Descuentos:");
    $pdf->Cell(30,10,"$".number_format($descuentos,2),0,1,'R');

    $pdf->SetXY(120,$descY+10);
    $pdf->Cell(80,10,"Aporte IESS:");
    $pdf->Cell(30,10,"$".number_format($aporteIess,2),0,1,'R');

    $pdf->SetXY(120,$descY+20);
    $pdf->Cell(80,10,"Aporte Empleador:");
    $pdf->Cell(30,10,"$".number_format($aporteEmpleador,2),0,1,'R');

    // Total
    $pdf->SetFont('Arial','B',14);
    $pdf->SetTextColor($morado[0],$morado[1],$morado[2]);
    $pdf->SetXY(50,$startY+60);
    $pdf->Cell(0,10,"TOTAL A PAGAR: $".number_format($total,2));

    // Cuadro legal
    $pdf->Rect(50,$startY+80,140,20);

    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(52,$startY+85);

    $pdf->MultiCell(135,5,
        'Declaro haber recibido conforme el pago correspondiente al periodo indicado, de acuerdo con la legislacion laboral vigente.'
    );

    // Firmas
    $firmaY = $startY + 120;

    $pdf->Line(50,$firmaY,110,$firmaY);
    $pdf->SetXY(50,$firmaY+2);
    $pdf->Cell(60,10,'Firma Empleado');

    $pdf->Line(130,$firmaY,190,$firmaY);
    $pdf->SetXY(130,$firmaY+2);
    $pdf->Cell(60,10,'Firma Gerente');

    $pdf->Output();
}