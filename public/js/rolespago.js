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