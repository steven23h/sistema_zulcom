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
       class="btn btn-primary btn-sm"
       target="_blank">
       PDF
    </a>

    <a href="../rolespago/acciones.php?action=eliminar&id=${r.id}"
       class="btn btn-danger btn-sm"
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
                <a href="administrador.php?page=ver_rol&id=${r.id}"
                   class="btn btn-success btn-sm">Ver</a>

                <a href="administrador.php?page=pdf_rol&id_trabajador=${r.id_trabajador}"
                   class="btn btn-primary btn-sm">PDF</a>
            </td>
        </tr>
        `;
    });
}