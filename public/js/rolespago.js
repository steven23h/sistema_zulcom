// ==========================
// CARGAR COLABORADORES
// ==========================
function cargarColaboradores(){

    fetch("/zulcom/views/rolespago/obtener_colaboradores.php")

    .then(res => res.json())

    .then(data => {

        const select = document.getElementById("colaborador");

        if(!select) return;

        select.innerHTML = `
            <option value="">
                Seleccione colaborador
            </option>
        `;

        data.forEach(col => {

            let option = document.createElement("option");

            option.value = col.id_trabajador;

            option.textContent =
                col.nombres + " " +
                col.apellidos + " - " +
                col.cargo;

            select.appendChild(option);

        });

    })

    .catch(error => console.error("Error:", error));
}


// ==========================
// ENVIAR FORMULARIO
// ==========================
function activarFormularioRol(){

    const form = document.getElementById("formRol");

    if(!form) return;

    form.addEventListener("submit", function(e){

        e.preventDefault();

        const formData = new FormData(form);

        fetch("/zulcom/views/rolespago/crear_rol.php", {

            method: "POST",
            body: formData

        })

        .then(res => res.json())

        .then(data => {

            alert(data.mensaje);

        })

        .catch(error => {

            console.error("Error:", error);

            alert("Error al generar rol");

        });

    });
}


// ==========================
// ASIGNAR PERIODO
// ==========================
function asignarPeriodo(){

    const inputPeriodo = document.getElementById("periodo");

    if(!inputPeriodo) return;

    const hoy = new Date();

    const year = hoy.getFullYear();

    const month = String(
        hoy.getMonth() + 1
    ).padStart(2, '0');

    inputPeriodo.value = `${year}-${month}`;
}