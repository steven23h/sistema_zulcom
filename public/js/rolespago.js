let roles = window.roles || [];

// ================================
// CARGAR TABLA
// ================================
function cargarListadoRoles() {

    const tbody = document.getElementById("tablaRoles");
    if (!tbody) return;

    tbody.innerHTML = "";

    roles.forEach(r => {

        tbody.innerHTML += `
        <tr>
            <td>${r.id}</td>
            <td>${r.nombres} ${r.apellidos}</td>
            <td>${r.cargo}</td>
            <td>${r.periodo}</td>
            <td>$${r.salario}</td>
            <td>$${r.total}</td>
            <td>${r.estado}</td>
           <td>

    <a href="../rolespago/acciones.php?action=pdf&id_trabajador=${r.id_trabajador}"
   class="btn-pdf"
   target="_blank">
   PDF
</a>

<a href="../rolespago/acciones.php?action=eliminar&id=${r.id}"
   class="btn-delete"
   onclick="return confirm('¿Eliminar este rol?')">
   Eliminar
</a>

</td>
        </tr>
        `;
    });
}

// ================================
// FILTROS
// ================================
function filtrarRoles() {

    const colaborador = document.getElementById("filtro_colaborador")?.value || "";
    const mes = document.getElementById("filtro_mes")?.value || "";

    const tbody = document.getElementById("tablaRoles");
    tbody.innerHTML = "";

    let filtrados = roles;

    if (colaborador) {
        filtrados = filtrados.filter(r => r.id_trabajador == colaborador);
    }

    if (mes) {
        filtrados = filtrados.filter(r => r.periodo == mes);
    }

    filtrados.forEach(r => {

        tbody.innerHTML += `
        <tr>
            <td>${r.id}</td>
            <td>${r.nombres} ${r.apellidos}</td>
            <td>${r.cargo}</td>
            <td>${r.periodo}</td>
            <td>$${r.salario}</td>
            <td>$${r.total}</td>
            <td>${r.estado}</td>
           <td>

<a href="../rolespago/acciones.php?action=pdf&id_trabajador=${r.id_trabajador}"
   class="btn-pdf"
   target="_blank">
   PDF
</a>

<a href="../rolespago/acciones.php?action=eliminar&id=${r.id}"
   class="btn-delete"
   onclick="return confirm('¿Eliminar este rol?')">
   Eliminar
</a>

</td>
        </tr>
        `;
    });
}

let rolesTecnico = window.rolesTecnico || [];

function cargarMisRoles() {

    const tbody = document.getElementById("tablaMisRoles");
    if (!tbody) return;

    const mes = document.getElementById("filtroMes")?.value || "";

    tbody.innerHTML = "";

    let filtrados = rolesTecnico;

    if (mes) {
        filtrados = filtrados.filter(r => r.periodo == mes);
    }

    filtrados.forEach(r => {

        tbody.innerHTML += `
        <tr>
            <td>${r.id}</td>
            <td>${r.periodo}</td>
            <td>$${r.salario}</td>
            <td>$${r.total}</td>
            <td>${r.estado}</td>
            <td>
                <a href="../rolespago/acciones.php?action=pdf&id_trabajador=${r.id_trabajador}"
                   class="btn btn-primary btn-sm"
                   target="_blank">
                   PDF
                </a>
            </td>
        </tr>
        `;
    });
}



// ==========================
// ACTIVAR FORMULARIO
// ==========================
function activarFormularioRol() {

    const form = document.getElementById("formRol");

    if (!form) return;

    form.addEventListener("submit", function () {

        const formData = new FormData(form);

        console.log("=== DATOS ENVIADOS ===");

        for (const [key, value] of formData.entries()) {
            console.log(key, value);
        }



    });

}


// ==========================
// ASIGNAR PERIODO
// ==========================
function asignarPeriodo() {

    const inputPeriodo = document.getElementById("periodo");

    if (!inputPeriodo) return;

    const hoy = new Date();

    const year = hoy.getFullYear();

    const month = String(
        hoy.getMonth() + 1
    ).padStart(2, "0");

    inputPeriodo.value = `${year}-${month}`;
}