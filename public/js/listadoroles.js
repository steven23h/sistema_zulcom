function cargarColaboradoresFiltro(){

    fetch("/zulcom/routes/rolpagoRoutes.php?action=colaboradores")
    .then(res => res.json())
    .then(data => {

        const select = document.getElementById("filtro_colaborador");

        if(!select) return;

        select.innerHTML = '<option value="">Todos</option>';

        data.forEach(col => {

            let option = document.createElement("option");
            option.value = col.id_trabajador;
            option.textContent = col.nombres + " " + col.apellidos;

            select.appendChild(option);

        });

    })
    .catch(err => console.error(err));
}



function cargarListadoRoles(){

    const colaborador = document.getElementById("filtro_colaborador")?.value || "";
    const mes = document.getElementById("filtro_mes")?.value || "";

    fetch(`/zulcom/routes/rolpagoRoutes.php?action=listar&colaborador=${colaborador}&mes=${mes}`)
    .then(res => res.json())
    .then(data => {

        const tbody = document.getElementById("tablaRoles");

        if(!tbody) return;

        tbody.innerHTML = "";

        data.forEach(r => {

            let fila = `
            <tr>
                <td>${r.id}</td>
                <td>${r.nombres} ${r.apellidos}</td>
                <td>${r.cargo}</td>
                <td>${r.periodo}</td>
                <td>$${r.salario}</td>
                <td>$${r.total}</td>
                <td>${r.estado}</td>
                <td>
                    <a href="/zulcom/routes/rolpagoRoutes.php?action=pdf&id_trabajador=${r.id_trabajador}" 
                    target="_blank" 
                    class="btn btn-success btn-sm">
                        PDF
                    </a>
                </td>
            </tr>
            `;

            tbody.innerHTML += fila;

        });

    })
    .catch(err => console.error(err));
}