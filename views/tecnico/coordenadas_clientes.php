<?php
require_once '../../controllers/TecnicoController.php';

$tecnicoCtrl = new TecnicoController();
// Llamamos al nuevo método para listar los abonados
$clientes = $tecnicoCtrl->getClientesCoordenadas() ?: [];
?>

<div style="margin-bottom: 25px; font-family: sans-serif;">
    <h2>📍 Coordenadas y Ubicación de Clientes</h2>
    <p style="color: #666;">Busca un cliente para abrir su ubicación exacta directamente en Google Maps.</p>
</div>

<div class="filters" style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; font-family: sans-serif;">
    <input type="text" id="buscarCliente" placeholder="🔍 Buscar por Cédula, Nombre, Apellido o IP..." 
           style="padding: 10px 15px; width: 100%; max-width: 450px; border-radius: 8px; border: 1px solid #cbd5e0; font-size: 0.95em; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
</div>

<div class="container-table" style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; padding: 10px;">
    <table class="table" id="tablaCoordenadas" style="width: 100%; border-collapse: collapse; text-align: left; font-family: sans-serif;">
        <thead>
            <tr style="background: #4361ee; color: white;">
                <th style="padding: 12px 15px;">Cliente / Abonado</th>
                <th style="padding: 12px 15px;">Cédula</th>
                <th style="padding: 12px 15px;">Dirección</th>
                <th style="padding: 12px 15px;">Dirección IP</th>
                <th style="padding: 12px 15px; text-align: center;">Geolocalización</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clientes)): ?>
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: #a0aec0; font-style: italic;">No se encontraron clientes registrados en la base de datos.</td>
                </tr>
            <?php else: ?>
                <?php foreach($clientes as $c): 
                    $nombreCompleto = trim(($c['nombre'] ?? '') . ' ' . ($c['apellido'] ?? ''));
                    $coordenadas = trim($c['coordenadas'] ?? '');
                ?>
                <tr class="fila-cliente" 
                    data-buscar="<?= strtolower(htmlspecialchars($nombreCompleto . ' ' . ($c['cedula'] ?? '') . ' ' . ($c['ip'] ?? ''))) ?>" 
                    style="border-bottom: 1px solid #edf2f7; transition: background 0.2s;" 
                    onmouseover="this.style.backgroundColor='#f8fafc'" 
                    onmouseout="this.style.backgroundColor='transparent'">
                    
                    <td style="padding: 12px 15px;">
                        <strong style="color: #2d3748; text-transform: capitalize;"><?= htmlspecialchars($nombreCompleto) ?></strong>
                    </td>
                    
                    <td style="padding: 12px 15px; color: #4a5568; font-weight: 500;">
                        <?= htmlspecialchars($c['cedula'] ?? '—') ?>
                    </td>
                    
                    <td style="padding: 12px 15px; color: #718096; max-width: 280px; word-wrap: break-word; font-size: 0.9em;">
                        <?= htmlspecialchars($c['direccion'] ?? 'No especificada') ?>
                    </td>
                    
                    <td style="padding: 12px 15px;">
                        <span style="background: #e2e8f0; color: #4a5568; padding: 4px 10px; border-radius: 6px; font-family: monospace; font-size: 0.9em; font-weight: bold;">
                            <?= htmlspecialchars($c['ip'] ?? 'Sin IP') ?>
                        </span>
                    </td>
                    
                    <td style="padding: 12px 15px; text-align: center;">
                        <?php if (!empty($coordenadas)): ?>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($coordenadas) ?>" 
                               target="_blank" 
                               style="background: #2a9d8f; color: white; padding: 8px 14px; text-decoration: none; border-radius: 6px; font-size: 0.85em; font-weight: bold; box-shadow: 0 2px 5px rgba(42, 157, 143, 0.3); display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;"
                               onmouseover="this.style.background='#1f766c'" 
                               onmouseout="this.style.background='#2a9d8f'">
                                📍 Abrir en Maps
                            </a>
                        <?php else: ?>
                            <span style="color: #a0aec0; font-size: 0.85em; font-style: italic; background: #f7fafc; padding: 6px 12px; border-radius: 6px; border: 1px dashed #cbd5e0;">
                                ❌ Sin Coordenadas
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('buscarCliente').addEventListener('input', function() {
    let filtro = this.value.toLowerCase().trim();
    let filas = document.querySelectorAll('.fila-cliente');

    filas.forEach(function(fila) {
        // Captura el bloque consolidado de datos (nombre + cédula + ip) guardado en la fila
        let datosFila = fila.getAttribute('data-buscar');
        
        if (datosFila.includes(filtro)) {
            fila.style.display = ''; // Muestra la fila si coincide
        } else {
            fila.style.display = 'none'; // La oculta si no coincide
        }
    });
});
</script>