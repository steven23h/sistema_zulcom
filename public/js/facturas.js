document.getElementById('buscador').addEventListener('input', function() {
    let query = this.value;
    if (query.length > 2) {
        fetch(`facturas/buscarCliente/${query}`)
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.forEach(cliente => {
                    html += `<a href="#" class="list-group-item list-group-item-action" 
                             onclick="seleccionarCliente(${JSON.stringify(cliente).replace(/"/g, '&quot;')})">
                             ${cliente.nombre} ${cliente.apellido} (${cliente.cedula})
                             </a>`;
                });
                document.getElementById('resultados').innerHTML = html;
            });
    }
});

function seleccionarCliente(cliente) {
    document.getElementById('id_cliente').value = cliente.id_cliente;
    document.getElementById('view_cedula').value = cliente.cedula;
    document.getElementById('view_correo').value = cliente.correo;
    document.getElementById('view_telefono').value = cliente.telefono1;
    document.getElementById('buscador').value = cliente.nombre + ' ' + cliente.apellido;
    document.getElementById('resultados').innerHTML = '';
}