document.addEventListener("DOMContentLoaded", () => {
    const btnCliente = document.getElementById("btn-cliente");
    const btnPersonal = document.getElementById("btn-personal");
    const camposPersonal = document.getElementById("campos-personal");
    const desc = document.getElementById("form-desc");
    const tipoInput = document.getElementById("tipo_registro");
    const form = document.getElementById("main-form");

    // Inputs dinámicos
    const inputCodigo = document.querySelector('input[name="codigo_empresa"]');
    const fileCedula = document.querySelector('input[name="copia_cedula"]');
    const fileRecord = document.querySelector('input[name="record_policial"]');

    // ================================
    // LOGICA DE REMUTACIÓN DE VISTA (TOGGLE)
    // ================================
    function toggleForm(tipo) {
        btnCliente.classList.toggle("active", tipo === "cliente");
        btnPersonal.classList.toggle("active", tipo === "personal");
        
        if (tipo === "personal") {
            camposPersonal.classList.remove("hidden");
            desc.innerHTML = "Tipo: <strong>Personal</strong>";
            tipoInput.value = "personal";
            
            // Hacer obligatorios en HTML dinámicamente si es personal
            if(inputCodigo) inputCodigo.required = true;
            if(fileCedula) fileCedula.required = true;
            if(fileRecord) fileRecord.required = true;
        } else {
            camposPersonal.classList.add("hidden");
            desc.innerHTML = "Tipo: <strong>Cliente</strong>";
            tipoInput.value = "cliente";
            
            // Quitar obligaciones y limpiar estados de error de campos de personal
            if(inputCodigo) { inputCodigo.required = false; removeMessage(inputCodigo); inputCodigo.classList.remove("input-error"); }
            if(fileCedula) { fileCedula.required = false; removeMessage(fileCedula); fileCedula.classList.remove("input-error"); }
            if(fileRecord) { fileRecord.required = false; removeMessage(fileRecord); fileRecord.classList.remove("input-error"); }
        }
    }

    btnCliente.addEventListener("click", () => toggleForm("cliente"));
    btnPersonal.addEventListener("click", () => toggleForm("personal"));

    // ================================
    // ALGORITMO COMPLETO CÉDULA ECUADOR
    // ================================
    const validarCedulaEcuador = (cedula) => {
        const digits = cedula.trim();
        if (digits.length !== 10 || isNaN(digits)) return false;
        
        const digito_region = parseInt(digits.substring(0, 2), 10);
        if (digito_region < 1 || digito_region > 24) return false;
        
        const ultimo_digito = parseInt(digits.substring(9, 10), 10);
        let pares = 0, impares = 0;
        
        for (let i = 0; i < 9; i++) {
            let mult = (i % 2 === 0) ? parseInt(digits[i], 10) * 2 : parseInt(digits[i], 10);
            if (mult > 9) mult -= 9;
            (i % 2 === 0) ? impares += mult : pares += mult;
        }
        const suma_total = pares + impares;
        const decena_superior = Math.ceil(suma_total / 10) * 10;
        let verificador = decena_superior - suma_total;
        if (verificador === 10) verificador = 0;
        
        return verificador === ultimo_digito;
    };

    // Reglas de validación en tiempo real
    const rules = {
        nombres: { test: v => v.trim().length >= 3, msg: "Mínimo 3 caracteres requeridos" },
        apellidos: { test: v => v.trim().length >= 3, msg: "Mínimo 3 caracteres requeridos" },
        cedula: { test: v => validarCedulaEcuador(v), msg: "Número de cédula ecuatoriana inválido" },
        telefono: { test: v => /^[0-9]{9,10}$/.test(v.trim()), msg: "Número telefónico inválido (9 o 10 dígitos)" },
        email: { test: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()), msg: "Estructura de correo no válida" },
        domicilio: { test: v => v.trim().length >= 5, msg: "La dirección provista es demasiado corta" },
        codigo_empresa: { test: v => tipoInput.value === 'cliente' || v.trim() === "ZULCOM2024", msg: "Código institucional no válido" }
    };

    // ================================
    // MANIPULACIÓN DEL DOM / MENSAJES DE ERROR
    // ================================
    function setError(input, msg) {
        input.classList.add("input-error");
        input.classList.remove("input-success");
        removeMessage(input);
        
        const small = document.createElement("small");
        small.className = "input-message error-text";
        small.innerText = msg;
        input.parentNode.appendChild(small);
    }

    function setSuccess(input) {
        input.classList.remove("input-error");
        input.classList.add("input-success");
        removeMessage(input);
    }

    function removeMessage(input) {
        const msg = input.parentNode.querySelector(".input-message");
        if (msg) msg.remove();
    }

    // Validar subida de ficheros del Personal
    const validarFile = (fileInput) => {
        if (tipoInput.value === "cliente") return true;
        const file = fileInput.files[0];
        
        if (!file) {
            if (fileInput.hasAttribute('required')) {
                setError(fileInput, "Este documento adjunto es obligatorio.");
                return false;
            }
            return true;
        }
        
        const ext = file.name.split('.').pop().toLowerCase();
        if (ext !== 'pdf') {
            setError(fileInput, "Formato no válido. Solo se admiten archivos (.pdf)");
            return false;
        }
        if (file.size > 2 * 1024 * 1024) { 
            setError(fileInput, "El tamaño excede el límite permitido (Máx. 2MB)");
            return false;
        }
        setSuccess(fileInput);
        return true;
    };

    // Eventos de validación al perder foco o cambiar entrada
    form.querySelectorAll("input, select").forEach(input => {
        input.addEventListener("change", () => {
            if (input.type === "file") {
                validarFile(input);
            } else {
                const name = input.name;
                const value = input.value;
                if (rules[name]) {
                    rules[name].test(value) ? setSuccess(input) : setError(input, rules[name].msg);
                }
            }
        });
    });

    // ================================
    // MANEJADOR DE ENVÍO DE FORMULARIO
    // ================================
    form.addEventListener("submit", (e) => {
        let isValid = true;

        // Validar todos los inputs textuales activos / obligatorios
        form.querySelectorAll("input").forEach(input => {
            // Saltarse la validación si el elemento pertenece al bloque personal oculto
            if (tipoInput.value === "cliente" && (input.name === "codigo_empresa" || input.type === "file")) {
                return;
            }

            const rule = rules[input.name];
            if (rule) {
                if (!rule.test(input.value)) {
                    setError(input, rule.msg);
                    isValid = false;
                } else {
                    setSuccess(input);
                }
            }
        });

        // Validar archivos sólo si es cuenta personal laboral
        if (tipoInput.value === "personal") {
            const f1 = validarFile(fileCedula);
            const f2 = validarFile(fileRecord);
            if (!f1 || !f2) isValid = false;
        }

        if (!isValid) {
            e.preventDefault(); // CANCELA EL ENVÍO AL BACKEND COMPLETAMENTE
            alert("Existen campos pendientes o con datos erróneos. Por favor verifique el formulario.");
        }
    });
});