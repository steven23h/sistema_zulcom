/* ============================================================
   JS DE BÚSQUEDA FILTRADA POR CÉDULA Y NOMBRE - ZULCOM
   ============================================================ */
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('personalSearch');
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase().trim();
            let rows = document.querySelectorAll('#tablaPersonal tbody tr');
            
            rows.forEach(row => {
                // Si la fila es la informativa de "No hay colaboradores", se salta
                if (row.cells.length < 2) return; 

                // Apunta directamente a Cédula (celda 0) y Colaborador (celda 1)
                let cedulaText = row.cells[0].textContent.toLowerCase();
                let nombreText = row.cells[1].textContent.toLowerCase();

                // Filtra por coincidencia exacta de esos campos
                if (cedulaText.includes(filter) || nombreText.includes(filter)) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none'; 
                }
            });
        });
    }
});