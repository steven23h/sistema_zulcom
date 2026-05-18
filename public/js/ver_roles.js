function cargarMisRoles(){

    const mes = document.getElementById("filtro_mes")?.value || "";

    fetch(`/zulcom/views/rolespago/obtener_colaboradores.php?mes=${mes}`)

    .then(res => res.json())

    .then(data => {

        const tbody = document.getElementById("tablaMisRoles");

        if(!tbody) return;

        tbody.innerHTML = "";

        data.forEach(r => {

            let fila = `
            <tr>
                <td>${r.id}</td>
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