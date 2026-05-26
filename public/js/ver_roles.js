function cargarMisRoles(){
     console.log("Cargando roles...");

    const mes = document.getElementById("filtro_mes")?.value || "";

    fetch(`/zulcom/views/rolespago/obtener_roles_tecnico.php?mes=${mes}`)

    .then(res => res.json())

    .then(data => {

        const tbody = document.getElementById("tablaMisRoles");

        if(!tbody) return;

        tbody.innerHTML = "";

        if(data.length === 0){

            tbody.innerHTML = `
                <tr>
                    <td colspan="6">
                        No tienes roles de pago generados.
                    </td>
                </tr>
            `;

            return;
        }

        data.forEach(r => {

            let fila = `
            <tr>

                <td>${r.id}</td>

                <td>${r.periodo}</td>

                <td>$${parseFloat(r.salario).toFixed(2)}</td>

                <td>$${parseFloat(r.total).toFixed(2)}</td>

                <td>${r.estado}</td>

                <td>

                    <a 
                       href="/zulcom/views/rolespago/generar_pdf.php?id_trabajador=${r.id_trabajador}"
                        target="_blank"
                        class="btn-primary"
                    >
                        Descargar PDF
                    </a>

                </td>

            </tr>
            `;

            tbody.innerHTML += fila;

        });

    })

    .catch(err => console.error(err));
}