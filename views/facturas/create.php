<?php
require_once '../../controllers/ClientesController.php';
require_once '../../config/database.php';

$clienteCtrl = new ClientesController();
$clientes = $clienteCtrl->index(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Recibo - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/tickets.css">
</head>
<body>

<div class="container">
    <div class="card-form">
        <h2>🧾 Generar Recibo de Pago</h2>
        <p style="color: #666; margin-bottom: 25px; font-size: 1.1rem;">Busque al cliente por cédula para auto-completar los datos del plan.</p>

        <div class="search-box">
            <input type="text" id="busqueda_cedula" placeholder="Ingrese Cédula..." class="form-control">
            <button type="button" onclick="buscarCliente()">🔍 Buscar</button>
        </div>

        <form action="../../controllers/FacturasController.php" method="POST" id="formFactura">
            <input type="hidden" name="btn_guardar_factura" value="1">
            <input type="hidden" name="id_cliente" id="id_cliente">
            <input type="hidden" name="email_cliente" id="email_cliente">
            <input type="hidden" name="nombre_cliente" id="nombre_cliente">

            <div id="infoCliente" class="client-card">
                <p><strong>Cliente:</strong> <span id="display_nombre"></span></p>
                <p><strong>Plan Actual:</strong> <span id="display_plan" class="plan-tag"></span></p>
                <p><strong>Email:</strong> <span id="display_email"></span></p>
            </div>

            <div class="grid">
                <div class="field">
                    <label>Monto a Pagar ($)</label>
                    <input type="number" step="0.01" name="monto" id="input_monto" required>
                </div>

                <div class="field">
                    <label>Forma de Pago</label>
                    <select name="forma_pago" required>
                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="DEPOSITO">DEPÓSITO</option>
                    </select>
                </div>

                <div class="field full">
                    <label>Concepto del Pago</label>
                    <textarea name="concepto" id="input_concepto" rows="3" required></textarea>
                </div>
            </div>

            <div class="actions" style="margin-top: 20px; display: flex; gap: 20px;">
                <button type="submit" class="btn-save" id="btnSubmit" disabled style="opacity: 0.5; flex: 1;">✅ Generar y Enviar Recibo</button>
                <a href="../dashboard/administrador.php?page=crear_factura" class="btn-cancel" style="flex: 1;">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    window.listaClientes = <?= json_encode($clientes); ?>;
</script>
<script src="../../public/js/facturas.js"></script>

</body>
</html>