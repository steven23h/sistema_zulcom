function cargarMisRoles(){

    const mes = document.getElementById("filtroMes").value;

    let url = "/zulcom/routes/rolpagoRoutes.php?action=listar";

    if(mes){
        url += "&mes=" + mes;
    }

    fetch(url)
    .then(res => res.json())
    .then(data => {

        const tabla = document.getElementById("tablaMisRoles");

        tabla.innerHTML = "";

        data.forEach(r => {

            tabla.innerHTML += `
                <tr>
                    <td>${r.id}</td>
                    <td>${r.periodo}</td>
                    <td>$${r.salario}</td>
                    <td>$${r.total}</td>
                    <td>${r.estado}</td>
                    <td>
                        <button class="btn btn-success btn-sm"
                        onclick="window.open('/zulcom/routes/rolpagoRoutes.php?action=pdf&id_trabajador=${r.id_trabajador}')">
                        PDF
                        </button>
                    </td>
                </tr>
            `;

        });

    })
    .catch(error => console.error("Error:", error));

}