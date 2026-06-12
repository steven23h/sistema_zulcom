<?php
require_once '../../controllers/ClientesController.php';
$clienteCtrl = new ClientesController();
$clientes = $clienteCtrl->index();
?>

<div class="header-seccion">
    <div>
        <h2>Gestión de Clientes</h2>
        <p>Total registrados: <strong><?= count($clientes) ?></strong></p>
    </div>

    <a href="administrador.php?page=crear_cliente" class="btn-new">
        ➕ Nuevo Cliente
    </a>
</div>

<input
    type="text"
    id="clienteSearch"
    class="search-input"
    placeholder="Buscar cliente por nombre, cédula o IP...">

<div class="table-container">

    <table class="zulcom-table" id="tablaClientes">

        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>IP</th>
                <th>Plan</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($clientes as $c): ?>

            <tr>

                <td class="text-bold">
                    <?= htmlspecialchars($c['cedula']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($c['nombre'] . " " . $c['apellido']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($c['telefono1']) ?>
                </td>

                <td>
                    <span class="ip-code">
                        <?= htmlspecialchars($c['ip']) ?>
                    </span>
                </td>

                <td class="plan-text">
                    <?= htmlspecialchars($c['nombre_plan'] ?? 'Sin plan') ?>
                </td>

                <td>
                    <span class="badge-status <?= strtolower($c['estado']) ?>">
                        <?= htmlspecialchars($c['estado']) ?>
                    </span>
                </td>

                <td>

                    <div class="actions">

                        <a href="administrador.php?page=editar_cliente&id=<?= $c['id_cliente'] ?>"
                           class="btn-edit"
                           title="Editar">
                            ✏️
                        </a>

                        <a href="../../actions/descargar_contrato.php?id=<?= $c['id_cliente'] ?>"
                           class="btn-info"
                           title="Contrato">
                            📄
                        </a>

                        <a href="administrador.php?action=eliminar_cliente&id=<?= $c['id_cliente'] ?>"
                           class="btn-delete"
                           onclick="return confirm('¿Eliminar cliente?')"
                           title="Eliminar">
                            🗑️
                        </a>

                    </div>

                </td>

            </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

<script src="../../public/js/clientes.js"></script>