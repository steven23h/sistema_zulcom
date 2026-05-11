let clientes = window.clientes || [];

// ================================
// BUSCAR CLIENTE
// ================================
function buscarCliente() {
    let cedulaInput = document.getElementById('cedula').value.trim();
    let info = document.getElementById('clientInfo');

    if (!cedulaInput) {
        alert('Por favor, ingrese una cédula');
        return;
    }

    // Buscamos en el array global inyectado por PHP
    let cliente = window.clientes.find(c => String(c.cedula).trim() === String(cedulaInput));

    if (!cliente) {
        alert('Cliente no encontrado en el sistema');
        info.classList.add('hidden');
        return;
    }

    // Mostramos el cuadro de información
    info.classList.remove('hidden');

    // Llenamos los datos (ajusta 'nombres' o 'apellido' según tu DB)
    document.getElementById('nombre_info').textContent = (cliente.nombres || cliente.nombre || '') + ' ' + (cliente.apellidos || cliente.apellido || '');
    document.getElementById('telefono_info').textContent = cliente.telefono1 || 'N/A';
    document.getElementById('direccion_info').textContent = cliente.direccion || 'N/A';
    document.getElementById('correo_info').textContent = cliente.correo || 'N/A';

    // Asignamos el ID al input oculto para el formulario
    document.getElementById('id_cliente').value = cliente.id_cliente || cliente.id;
}
// ================================
// FILTROS
// ================================
document.addEventListener("DOMContentLoaded", function () {

    const cedula = document.getElementById("filtroCedula");
    const estado = document.getElementById("filtroEstado");
    const tecnico = document.getElementById("filtroTecnico");
    const tipo = document.getElementById("filtroTipo");
    const fechaInicio = document.getElementById("fechaInicio");
    const fechaFin = document.getElementById("fechaFin");

    const tabla = document.getElementById("tablaTickets");

    if (!tabla) return;

    const filas = tabla.querySelectorAll("tbody tr");

    function filtrar() {

        const valCedula = (cedula?.value || "").toLowerCase();
        const valEstado = estado?.value || "";
        const valTecnico = tecnico?.value || "";
        const valTipo = tipo?.value || "";
        const valFechaInicio = fechaInicio?.value || "";
        const valFechaFin = fechaFin?.value || "";

        filas.forEach(fila => {

            let mostrar = true;

            const fCedula = (fila.dataset.cedula || "").toLowerCase();
            const fEstado = fila.dataset.estado || "";
            const fTecnico = fila.dataset.tecnico || "";
            const fTipo = fila.dataset.tipo || "";
            const fFecha = (fila.dataset.fecha || "").split(" ")[0];

            if (valCedula && !fCedula.includes(valCedula)) mostrar = false;
            if (valEstado && valEstado !== fEstado) mostrar = false;
            if (valTecnico && valTecnico !== fTecnico) mostrar = false;
            if (valTipo && valTipo !== fTipo) mostrar = false;

            if (valFechaInicio && fFecha < valFechaInicio) mostrar = false;
            if (valFechaFin && fFecha > valFechaFin) mostrar = false;

            fila.style.display = mostrar ? "" : "none";
        });
    }

    [cedula, estado, tecnico, tipo, fechaInicio, fechaFin].forEach(el => {
        el?.addEventListener("input", filtrar);
        el?.addEventListener("change", filtrar);
    });

});