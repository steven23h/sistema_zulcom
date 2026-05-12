
// BUSCADOR DE TABLA
document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("planSearch");
    const rows = document.querySelectorAll("#tablaPlanes tbody tr");

    input.addEventListener("keyup", function () {

        let value = this.value.toUpperCase();

        rows.forEach(row => {
            let text = row.textContent.toUpperCase();

            if (text.includes(value)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

    });

});