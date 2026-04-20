function cargarColaboradores(){

    fetch("/zulcom/routes/rolpagoRoutes.php?action=colaboradores")
    .then(res => res.json())
    .then(data => {

        console.log(data);

        const select = document.getElementById("colaborador");

        if(!select) return; // 👈 evita errores si no existe

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