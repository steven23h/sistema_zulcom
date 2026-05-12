<?php
// 1. Las declaraciones "use" SIEMPRE van al inicio
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'models/Factura.php';
require_once 'controllers/GenerarPdfController.php';

// 2. Esta es la ruta clave: salimos de 'controllers' para buscar 'vendor'
require_once __DIR__ . '/../vendor/autoload.php';

class FacturasController {

    public function store() {
        if ($_POST) {
            $facturaModel = new Factura();
            
            // Generar número correlativo (REC-0001...)
            $ultimo = $facturaModel->obtenerUltimoId();
            $nuevoNumero = "REC-" . str_pad($ultimo + 1, 4, "0", STR_PAD_LEFT);

            $data = [
                'id_cliente'    => $_POST['id_cliente'],
                'numero_recibo' => $nuevoNumero,
                'monto'         => $_POST['monto'],
                'forma_pago'    => $_POST['forma_pago'],
                'concepto'      => "Pago mensual de Internet Zulcom - " . date('F Y')
            ];

            // Guardar en la base de datos
            $id_factura = $facturaModel->guardar($data);

            if ($id_factura) {
                // Generar PDF (Asegúrate de tener la carpeta public/uploads/facturas)
                $pdfRepo = new GenerarPdfController();
                $rutaPdf = $pdfRepo->generar($id_factura);

                // Llamar al envío de correo
                $this->enviarPorEmail(
                    $_POST['email_cliente'], 
                    $_POST['nombre_cliente'], 
                    $rutaPdf, 
                    $nuevoNumero
                );

                // Redirección directa al listado
                echo "<script>
                    alert('Recibo generado y enviado correctamente.');
                    window.location.href = 'index.php?controller=Facturas&action=index';
                </script>";
            }
        }
    }

    private function enviarPorEmail($destinatario, $nombre, $rutaPdf, $numRecibo) {
        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP de tu Gmail personal
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'jorgelincango017@gmail.com'; 
            $mail->Password   = 'hedampvapjefszez'; // Tu clave de 16 letras
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('jorgelincango017@gmail.com', 'Zulcom Internet');
            $mail->addAddress($destinatario, $nombre);
            
            // Adjuntar PDF si existe
            if (file_exists($rutaPdf)) {
                $mail->addAttachment($rutaPdf, "Recibo_Zulcom_$numRecibo.pdf");
            }

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "Comprobante de Pago No. $numRecibo - Zulcom";
            $mail->Body    = "<h3>¡Hola, $nombre!</h3><p>Adjuntamos tu recibo de pago oficial. Gracias por preferir Zulcom.</p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Si el correo falla, no detenemos el sistema
            return false;
        }
    }
}
