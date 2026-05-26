<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../models/Factura.php';
require_once __DIR__ . '/GenerarPdfController.php';
require_once __DIR__ . '/../vendor/autoload.php';

class FacturasController {
    
    public function store() {
        if ($_POST) {
            $facturaModel = new Factura();
            $ultimo = $facturaModel->obtenerUltimoId();
            $nuevoNumero = "REC-" . str_pad($ultimo + 1, 4, "0", STR_PAD_LEFT);

            $data = [
                'id_cliente'    => $_POST['id_cliente'],
                'numero_recibo' => $nuevoNumero,
                'monto'         => $_POST['monto'],
                'forma_pago'    => $_POST['forma_pago'],
                'concepto'      => $_POST['concepto']
            ];

            $id = $facturaModel->guardar($data);
            
            if ($id) {
                $pdfRepo = new GenerarPdfController();
                $rutaPdf = $pdfRepo->generar($id);

                // Enviamos el correo usando los datos del POST
                $this->enviarPorEmail($_POST['email_cliente'], $_POST['nombre_cliente'], $rutaPdf, $nuevoNumero);

              // Cambia la redirección para incluir ?page=crear_factura
echo "<script>
    alert('Recibo enviado correctamente.'); 
    window.location.href='../views/dashboard/administrador.php?page=crear_factura';
</script>";
            }
        }
    }

    private function enviarPorEmail($destinatario, $nombre, $rutaPdf, $numRecibo) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jorgelincango017@gmail.com';
            $mail->Password = 'hedampvapjefszez'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('jorgelincango017@gmail.com', 'Zulcom Internet');
            $mail->addAddress($destinatario, $nombre);
            $mail->addAttachment($rutaPdf, "Recibo_Zulcom_$numRecibo.pdf");

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "Recibo de Pago No. $numRecibo - Zulcom Internet";
            $mail->Body = "<h3>¡Hola, $nombre!</h3><p>Adjuntamos tu recibo de pago por el servicio de internet. Gracias por preferir Zulcom.</p>";

            $mail->send();
        } catch (Exception $e) { /* Manejo de errores */ }
    }
}

// Escuchador de botón
$fController = new FacturasController();
if (isset($_POST['btn_guardar_factura'])) {
    $fController->store();
}