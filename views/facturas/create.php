<div class="card">
    <div class="card-header">Generar Nuevo Recibo de Pago</div>
    <div class="card-body">
        <form action="facturas/store" method="POST" id="formFactura">
            <div class="form-group">
                <label>Buscar Cliente (Cédula o Nombre):</label>
                <input type="text" id="buscador" class="form-control" autocomplete="off">
                <div id="resultados" class="list-group position-absolute w-100" style="z-index: 100;"></div>
            </div>

            <input type="hidden" name="id_cliente" id="id_cliente">
            <div class="row">
                <div class="col-md-4">
                    <label>Cédula:</label>
                    <input type="text" id="view_cedula" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label>Correo:</label>
                    <input type="text" id="view_correo" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label>WhatsApp:</label>
                    <input type="text" id="view_telefono" class="form-control" readonly>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Forma de Pago:</label>
                    <select name="forma_pago" class="form-control" required>
                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="DEPOSITO">DEPÓSITO</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Monto a Cobrar:</label>
                    <input type="number" step="0.01" name="monto" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Guardar y Enviar Comprobante</button>
        </form>
    </div>
</div>