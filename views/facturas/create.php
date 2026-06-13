<?php
require_once '../../controllers/ClientesController.php';
require_once '../../config/database.php';

$clienteCtrl = new ClientesController();
$clientes = $clienteCtrl->index();

// Captura la cédula automáticamente si viene desde el módulo de deudores
$cedulaUrl = isset($_GET['cedula']) ? htmlspecialchars($_GET['cedula']) : '';
?>

<div class="container-form factura-form-card">

    <h2>🧾 Generar Recibo de Pago</h2>

    <p class="form-subtitle">
        Busque al cliente por cédula para auto-completar los datos del plan.
    </p>

    <div class="search-box">
        <input
            type="text"
            id="busqueda_cedula"
            value="<?= $cedulaUrl ?>"
            placeholder="Ingrese Cédula...">

        <button type="button" onclick="buscarCliente()" class="btn-buscar">
            🔍 Buscar
        </button>
    </div>

    <form action="../../controllers/FacturasController.php" method="POST" id="formFactura">

        <input type="hidden" name="btn_guardar_factura" value="1">
        <input type="hidden" name="id_cliente" id="id_cliente">
        <input type="hidden" name="email_cliente" id="email_cliente">
        <input type="hidden" name="nombre_cliente" id="nombre_cliente">

        <div id="infoCliente" class="client-card" style="display: none; margin-bottom: 20px;">
            <p><strong>Cliente:</strong> <span id="display_nombre"></span></p>
            <p><strong>Plan Actual:</strong> <span id="display_plan" class="plan-tag"></span></p>
            <p><strong>Email:</strong> <span id="display_email"></span></p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>Monto a Pagar ($)</label>
                <input type="number" step="0.01" name="monto" id="input_monto" required>
            </div>

            <div class="form-group">
                <label>Forma de Pago</label>
                <select name="forma_pago" required>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="DEPOSITO">DEPÓSITO</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Concepto del Pago</label>
                <textarea name="concepto" id="input_concepto" rows="3" required></textarea>
            </div>

        </div>

        <div class="acciones-form">

            <button
                type="submit"
                class="btn-save"
                id="btnSubmit"
                style="opacity: 0.5;"
                disabled>
                ✅ Generar y Enviar Recibo
            </button>

            <a href="../dashboard/administrador.php?page=clientes_deudores"
               class="btn-cancel">
                Cancelar
            </a>

        </div>

    </form>

</div>

<script>
    window.listaClientes = <?= json_encode($clientes); ?>;
</script>
<script src="../../public/js/facturas.js"></script>