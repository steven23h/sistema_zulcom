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