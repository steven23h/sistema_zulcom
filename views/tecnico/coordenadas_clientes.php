<?php
require_once '../../controllers/TecnicoController.php';

$tecnicoCtrl = new TecnicoController();
$clientes = $tecnicoCtrl->getClientesCoordenadas() ?: [];
?>

<div class="header-seccion">
    <div>
        <h2>Coordenadas y Ubicación de Clientes</h2>
        <p>
            Busca un cliente para abrir su ubicación exacta directamente en Google Maps.
        </p>
    </div>
</div>

<input
    type="text"
    id="buscarCliente"
    class="search-input"
    placeholder="Buscar por Cédula, Nombre, Apellido o IP...">

<div class="table-container">

    <table class="zulcom-table" id="tablaCoordenadas">

        <thead>
            <tr>
                <th>Cliente / Abonado</th>
                <th>Cédula</th>
                <th>Dirección</th>
                <th>Dirección IP</th>
                <th>Geolocalización</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($clientes)): ?>

                <tr>
                    <td colspan="5" class="empty-row">
                        No se encontraron clientes registrados en la base de datos.
                    </td>
                </tr>

            <?php else: ?>

                <?php foreach($clientes as $c): 
                    $nombreCompleto = trim(($c['nombre'] ?? '') . ' ' . ($c['apellido'] ?? ''));
                    $coordenadas = trim($c['coordenadas'] ?? '');
                    $datosBuscar = strtolower($nombreCompleto . ' ' . ($c['cedula'] ?? '') . ' ' . ($c['ip'] ?? ''));
                ?>

                    <tr class="fila-cliente"
                        data-buscar="<?= htmlspecialchars($datosBuscar) ?>">

                        <td>
                            <strong>
                                <?= htmlspecialchars($nombreCompleto) ?>
                            </strong>
                        </td>

                        <td>
                            <?= htmlspecialchars($c['cedula'] ?? '—') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($c['direccion'] ?? 'No especificada') ?>
                        </td>

                        <td>
                            <span class="ip-badge">
                                <?= htmlspecialchars($c['ip'] ?? 'Sin IP') ?>
                            </span>
                        </td>

                        <td>
                            <?php if (!empty($coordenadas)): ?>

                                <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($coordenadas) ?>"
                                   target="_blank"
                                   class="btn-maps">
                                    Abrir en Maps
                                </a>

                            <?php else: ?>

                                <span class="sin-coordenadas">
                                    Sin Coordenadas
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
        let datosFila = fila.getAttribute('data-buscar');

        fila.style.display = datosFila.includes(filtro) ? '' : 'none';
    });
});
</script>