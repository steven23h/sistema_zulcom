// ============================================================
// LOGICA DE AUTOCOMPLETADO PARA RECIBOS - ZULCOM
// ============================================================

function buscarCliente() {
    const cedula = document.getElementById('busqueda_cedula').value.trim();
    const infoDiv = document.getElementById('infoCliente');
    const btn = document.getElementById('btnSubmit');

    if (!cedula) {
        alert("⚠️ Por favor ingrese un número de cédula.");
        return;
    }

    // Buscar en la lista global inyectada desde la vista
    const c = window.listaClientes.find(item => String(item.cedula).trim() === String(cedula));

    if (c) {
        // Rellenar visualización en la tarjeta informativa
        document.getElementById('display_nombre').innerText = `${c.nombre} ${c.apellido}`.toUpperCase();
        document.getElementById('display_plan').innerText = c.nombre_plan ? c.nombre_plan.toUpperCase() : 'SIN PLAN';
        document.getElementById('display_email').innerText = c.correo || 'N/A';

        // Rellenar campos ocultos para mandar al controlador POST
        document.getElementById('id_cliente').value = c.id_cliente;
        document.getElementById('email_cliente').value = c.correo;
        document.getElementById('nombre_cliente').value = `${c.nombre} ${c.apellido}`;
        
        // CORRECCIÓN: Tu columna en la base de datos se llama 'precio'
        if (c.precio) {
            document.getElementById('input_monto').value = parseFloat(c.precio).toFixed(2);
        } else {
            document.getElementById('input_monto').value = "0.00";
        }

        // Generar concepto de pago automático con el mes en curso limpia de puntuaciones
        const opciones = { month: 'long' };
        let mesActual = new Intl.DateTimeFormat('es-ES', opciones).format(new Date());
        mesActual = mesActual.replace('.', ''); // Elimina puntos si el navegador abrevia
        
        document.getElementById('input_concepto').value = `Pago del servicio de internet correspondiente al mes de ${mesActual}:`;

        // Hacer visible la tarjeta removiendo bloqueos y habilitando el submit
        infoDiv.style.display = 'block';
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.classList.remove('btn-disabled'); // Quitamos la clase de deshabilitado si existiera
    } else {
        alert("❌ Cliente no encontrado. Verifique la cédula.");
        infoDiv.style.display = 'none';
        btn.disabled = true;
        btn.style.opacity = '0.5';
        document.getElementById('formFactura').reset(); // Resetea campos si falla
    }
}

// Disparador automático: Si la cédula ya viene en el input desde la URL, busca solo
document.addEventListener("DOMContentLoaded", function() {
    const inputCedula = document.getElementById("busqueda_cedula");
    if (inputCedula && inputCedula.value.trim() !== "") {
        buscarCliente();
    }
});