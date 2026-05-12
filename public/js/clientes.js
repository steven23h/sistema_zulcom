
document.getElementById('clienteSearch').addEventListener('keyup', function () {

    let filter = this.value.toUpperCase();
    let rows = document.querySelector("#tablaClientes tbody").rows;

    for (let i = 0; i < rows.length; i++) {
        let text = rows[i].textContent.toUpperCase();
        rows[i].style.display = text.includes(filter) ? "" : "none";
    }

    });
    
// VALIDACIÓN SIMPLE CLIENTE

document.getElementById("formCliente").addEventListener("submit", function (e) {

    let cedula = document.querySelector("[name='cedula']").value;
    let ip = document.querySelector("[name='ip']").value;
    let correo = document.querySelector("[name='correo']").value;

    // CÉDULA ECUADOR (10 dígitos)
    if (cedula.length !== 10 || isNaN(cedula)) {
        alert("La cédula debe tener 10 números");
        e.preventDefault();
        return;
    }

    // IP básica
    if (!ip.includes(".")) {
        alert("Ingrese una IP válida");
        e.preventDefault();
        return;
    }

    // EMAIL simple
    if (!correo.includes("@")) {
        alert("Correo inválido");
        e.preventDefault();
        return;
    }

});

