document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("main-form") || document.querySelector("form");

    if (!form) return;

    form.addEventListener("submit", (e) => {
        let isValid = true;
        
        // 1. Validar que la cédula tenga exactamente 10 caracteres numéricos
        const cedulaInput = form.querySelector('input[name="cedula"]');
        if (cedulaInput) {
            const val = cedulaInput.value.trim();
            if (val.length !== 10 || isNaN(val)) {
                alert("La cédula debe contener exactamente 10 números.");
                isValid = false;
            }
        }

        // 2. Validar que los archivos adjuntos terminen en extensión .pdf
        const fileInputs = form.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            if (input.files.length > 0) {
                const fileName = input.files[0].name;
                const extension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
                if (extension !== '.pdf') {
                    alert("El archivo '" + fileName + "' no es un PDF válido.");
                    isValid = false;
                }
            } else {
                alert("Por favor, seleccione ambos archivos PDF requeridos.");
                isValid = false;
            }
        });

        // Si se encuentra un problema real de archivos o dígitos de cédula, frena el flujo
        if (!isValid) {
            e.preventDefault();
        }
    });
});