document.addEventListener("DOMContentLoaded", () => {
    const btnCliente = document.getElementById("btn-cliente");
    const btnPersonal = document.getElementById("btn-personal");
    const camposPersonal = document.getElementById("campos-personal");
    const desc = document.getElementById("form-desc");
    const tipoInput = document.getElementById("tipo_registro");
    const form = document.querySelector("form");

    // ================================
    // LOGICA DE TOGGLE
    // ================================
    function toggleForm(tipo) {
        btnCliente.classList.toggle("active", tipo === "cliente");
        btnPersonal.classList.toggle("active", tipo === "personal");
        
        if (tipo === "personal") {
            camposPersonal.classList.remove("hidden");
            desc.innerHTML = "Tipo: <strong>Personal</strong>";
            tipoInput.value = "personal";
        } else {
            camposPersonal.classList.add("hidden");
            desc.innerHTML = "Tipo: <strong>Cliente</strong>";
            tipoInput.value = "cliente";
        }
    }

    btnCliente.addEventListener("click", () => toggleForm("cliente"));
    btnPersonal.addEventListener("click", () => toggleForm("personal"));

    // ================================
    // REGLAS DE VALIDACIÓN (Ecuador Style)
    // ================================
    const validarCedulaEcuador = (cedula) => {
        if (cedula.length !== 10) return false;
        const digito_region = parseInt(cedula.substring(0, 2));
        if (digito_region < 1 || digito_region > 24) return false;
        
        const ultimo_digito = parseInt(cedula.substring(9, 10));
        let pares = 0, impares = 0;
        
        for (let i = 0; i < 9; i++) {
            let mult = (i % 2 === 0) ? parseInt(cedula[i]) * 2 : parseInt(cedula[i]);
            if (mult > 9) mult -= 9;
            (i % 2 === 0) ? impares += mult : pares += mult;
        }
        const suma_total = pares + impares;
        const decena_superior = Math.ceil(suma_total / 10) * 10;
        let verificador = decena_superior - suma_total;
        if (verificador === 10) verificador = 0;
        
        return verificador === ultimo_digito;
    };

    const rules = {
        nombres: { test: v => v.length >= 3, msg: "Mínimo 3 caracteres" },
        apellidos: { test: v => v.length >= 3, msg: "Mínimo 3 caracteres" },
        cedula: { test: v => validarCedulaEcuador(v), msg: "Cédula inválida" },
        telefono: { test: v => /^[0-9]{10}$/.test(v), msg: "Deben ser 10 números (ej. 09...)" },
        email: { test: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v), msg: "Correo no válido" },
        domicilio: { test: v => v.length > 5, msg: "Dirección muy corta" },
        codigo_empresa: { test: v => tipoInput.value === 'cliente' || v.length > 2, msg: "Código obligatorio para personal" }
    };

    // ================================
    // FUNCIONES DE UI
    // ================================
    function setError(input, msg) {
        input.classList.add("input-error");
        input.classList.remove("input-success");
        removeMessage(input);
        const small = document.createElement("small");
        small.className = "input-message error-text";
        small.style.color = "red";
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

    // ================================
    // VALIDACIÓN DE ARCHIVOS
    // ================================
    const validarFile = (fileInput) => {
        if (tipoInput.value === "cliente") return true;
        const file = fileInput.files[0];
        if (!file) {
            setError(fileInput, "Este archivo es obligatorio");
            return false;
        }
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['pdf', 'jpg', 'png', 'jpeg'].includes(ext)) {
            setError(fileInput, "Solo PDF o Imágenes");
            return false;
        }
        if (file.size > 2 * 1024 * 1024) { // 2MB
            setError(fileInput, "Máximo 2MB");
            return false;
        }
        setSuccess(fileInput);
        return true;
    };

    // ================================
    // EVENTOS
    // ================================
    form.querySelectorAll("input, select").forEach(input => {
        input.addEventListener("change", () => {
            if (input.type === "file") {
                validarFile(input);
            } else {
                const name = input.name;
                const value = input.value.trim();
                if (rules[name]) {
                    rules[name].test(value) ? setSuccess(input) : setError(input, rules[name].msg);
                }
            }
        });
    });

    form.addEventListener("submit", (e) => {
        let isValid = true;

        // Validar textos
        form.querySelectorAll("input[required]").forEach(input => {
            const rule = rules[input.name];
            if (rule && !rule.test(input.value.trim())) {
                setError(input, rule.msg);
                isValid = false;
            }
        });

        // Validar archivos solo si es personal
        if (tipoInput.value === "personal") {
            const f1 = validarFile(form.querySelector('input[name="copia_cedula"]'));
            const f2 = validarFile(form.querySelector('input[name="record_policial"]'));
            if (!f1 || !f2) isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            alert("Por favor, revisa los errores en el formulario.");
        }
    });
});