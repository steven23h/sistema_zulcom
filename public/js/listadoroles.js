function cargarColaboradoresFiltro(){

    fetch("/zulcom/views/rolespago/obtener_colaboradores.php")

    .then(res => res.json())

    .then(data => {

        const select = document.getElementById("filtro_colaborador");

        if(!select) return;

        select.innerHTML = `
            <option value="">
                Todos
            </option>
        `;

        data.forEach(col => {

            let option = document.createElement("option");

            option.value = col.id_trabajador;

            option.textContent =
                col.nombres + " " + col.apellidos;

            select.appendChild(option);

        });

    })

    .catch(err => console.error(err));
}



function cargarListadoRoles(){

    const colaborador =
        document.getElementById("filtro_colaborador")?.value || "";

    const mes =
        document.getElementById("filtro_mes")?.value || "";

  fetch(`/zulcom/views/rolespago/obtener_roles.php?colaborador=${colaborador}&mes=${mes}`)

    .then(res => res.json())

    .then(data => {

        const tbody = document.getElementById("tablaRoles");

        if(!tbody) return;

        tbody.innerHTML = "";

        data.forEach(r => {

            let fila = `
            <tr>

                <td>${r.id}</td>

                <td>
                    ${r.nombres} ${r.apellidos}
                </td>

                <td>${r.cargo}</td>

                <td>${r.periodo}</td>

                <td>$${r.salario}</td>

                <td>$${r.total}</td>

                <td>${r.estado}</td>

                <td>

                    <a href="/zulcom/views/rolespago/generar_pdf.php?id_trabajador=${r.id_trabajador}" 
                    target="_blank"
                    class="btn-download">

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