// ==========================
// CARGAR COLABORADORES
// ==========================
function cargarColaboradores(){

    fetch("/zulcom/routes/rolpagoRoutes.php?action=colaboradores")
    .then(res => res.json())
    .then(data => {

        console.log(data);

        const select = document.getElementById("colaborador");

        if(!select) return;

        select.innerHTML = '<option value="">Seleccione colaborador</option>';

        data.forEach(col => {

            let option = document.createElement("option");
            option.value = col.id_trabajador;
            option.textContent = col.nombres + " " + col.apellidos + " - " + col.cargo;

            select.appendChild(option);

        });

    })
    .catch(error => console.error("Error:", error));
}


// ==========================
// ENVIAR FORMULARIO + PDF
// ==========================
function activarFormularioRol(){

    const form = document.getElementById("formRol");

    if(!form){
        console.log("❌ No encontró el form");
        return;
    }

    console.log("✅ Form encontrado");

    form.addEventListener("submit", function(e){

        e.preventDefault();

        console.log("🔥 Enviando formulario");

        const formData = new FormData(form);

        fetch("/zulcom/routes/rolpagoRoutes.php?action=crear", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            alert(data.mensaje);

            const id = formData.get("id_trabajador");

            window.open("/zulcom/routes/rolpagoRoutes.php?action=pdf&id_trabajador=" + id);

        })
        .catch(error => console.error("Error:", error));

    });
}