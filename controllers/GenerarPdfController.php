<?php
use Dompdf\Dompdf;
use Dompdf\Options;

// Importante: El autoload de vendor debe estar accesible
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/Factura.php';

class GenerarPdfController {

    public function generar($id_factura) {
        $model = new Factura();
        // Obtenemos los datos de la factura, cliente y plan
        $f = $model->obtenerFacturaPorId($id_factura);

        if (!$f) {
            return null;
        }

        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Para cargar imágenes o estilos externos si fuera necesario
        $dompdf = new Dompdf($options);

        // Configurar idioma para la fecha (Mayo en lugar de May)
        setlocale(LC_TIME, 'es_ES.UTF-8', 'esp');
        
        // Usamos 'fecha_pago' que es el nombre real de tu columna en la DB
        $timestamp = strtotime($f['fecha_pago']);
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $mesNombre = $meses[date('n', $timestamp) - 1];
        
        $fechaFormateada = date("d", $timestamp) . " de " . $mesNombre . " del " . date("Y", $timestamp);

        // Estructura HTML idéntica a image_ca02d8.png
        $html = "
        <html>
        <head>
            <style>
                body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 0; }
                .header { border-bottom: 3px solid #4a90e2; padding-bottom: 10px; margin-bottom: 10px; }
                .logo-text { color: #2e3192; font-size: 32px; font-weight: bold; }
                .logo-sub { color: #4a90e2; font-size: 12px; font-style: italic; }
                .company-info { font-size: 10px; text-align: right; line-height: 1.4; }
                .title { text-align: center; color: #2e3192; font-size: 22px; font-weight: bold; margin: 15px 0; border-top: 1px solid #eee; padding-top: 10px; }
                .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                .blue-header { background-color: #2e3192; color: white; text-align: center; font-weight: bold; padding: 8px; font-size: 12px; }
                .total-box { background-color: #dbdbdb; padding: 30px; text-align: center; font-size: 22px; font-weight: bold; margin-top: 10px; border-radius: 4px; }
                .footer-box { background-color: #e9e9e9; padding: 15px; margin-top: 30px; font-size: 11px; font-style: italic; min-height: 40px; }
                .footer-line { border-top: 4px solid #4a90e2; margin-top: 15px; padding-top: 8px; font-size: 11px; color: #444; }
                .data-label { font-weight: bold; width: 110px; font-size: 13px; }
                .data-value { font-size: 13px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <table width='100%'>
                    <tr>
                        <td width='35%'>
                            <span class='logo-text'>zulcom</span><br>
                            <span class='logo-sub'>INTERNET ultra rápido</span>
                        </td>
                        <td class='company-info'>
                            <b>RUC/CI:</b> 1793214229001 &nbsp;&nbsp; <b>Sitio Web:</b> www.zulcom.ec<br>
                            <b>E-mail:</b> facturas@zulcom.ec &nbsp;&nbsp; <b>Teléfono:</b> 0968873817 / 0939842235<br>
                            <b>Dirección:</b> CALDERON (CARAPUNGO) / MANUEL AGUILAR LT4 Y EL CAJÓN LOS GUABOS
                        </td>
                    </tr>
                </table>
            </div>

            <div class='title'>RECIBO DE PAGO</div>

            <table class='main-table'>
                <tr>
                    <td width='55%' style='vertical-align: top; line-height: 2;'>
                        <table width='100%'>
                            <tr><td class='data-label'>Cédula:</td><td class='data-value'>{$f['cedula']}</td></tr>
                            <tr><td class='data-label'>Recibí de:</td><td class='data-value'>" . strtoupper($f['nombre'] . " " . $f['apellido']) . "</td></tr>
                            <tr><td class='data-label'>Cantidad:</td><td class='data-value'></td></tr>
                            <tr>
                                <td class='data-label' style='vertical-align:top;'>Concepto:</td>
                                <td class='data-value'>
                                    {$f['concepto']}<br>
                                    <span style='padding-left: 20px; font-weight:bold;'>". strtoupper($f['nombre_plan']) ."</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width='45%' style='vertical-align: top;'>
                        <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color: #fff; margin-bottom: 5px;'>
                            <tr>
                                <td class='blue-header' width='40%'>RECIBO #</td>
                                <td class='blue-header' width='60%'>FECHA</td>
                            </tr>
                            <tr>
                                <td align='center' style='padding: 10px; font-weight: bold;'>{$f['numero_recibo']}</td>
                                <td align='center' style='padding: 10px; font-weight: bold;'>$fechaFormateada</td>
                            </tr>
                        </table>
                        <div class='total-box'>Total: $ " . number_format($f['monto'], 2) . "</div>
                        <p align='right' style='font-size:14px; margin-top:15px;'><b>Forma de pago:</b> <i>{$f['forma_pago']}</i></p>
                    </td>
                </tr>
            </table>

            <div style='margin-top: 25px; font-size: 12px;'>
                <b>Costos Adicionales:</b> &nbsp;&nbsp;&nbsp; <i>Equipos: Sin dispositivos registrados</i>
            </div>

            <div class='footer-box'>
                El cliente presenta un abono de $0.00.
            </div>

            <div class='footer-line'>
                Gracias por preferirnos, cualquier inquietud o sugerencia estamos para servirle.
            </div>
        </body>
        </html>";

        // Cargar HTML y generar
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Guardar el archivo en la carpeta de facturas
        $nombreArchivo = 'Recibo_' . $f['numero_recibo'] . '.pdf';
        $rutaDestino = __DIR__ . '/../public/uploads/facturas/' . $nombreArchivo;
        
        file_put_contents($rutaDestino, $dompdf->output());

        return $rutaDestino;
    }
}