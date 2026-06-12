<?php
require_once '../../controllers/ClientesController.php';

$clienteCtrl = new ClientesController();
$deudores = $clienteCtrl->listarDeudores();
?>

<div class="table-container">

    <div class="header-seccion-deudores">
        <div>
            <h2>⚠️ Clientes Pendientes de Pago</h2>
            <p>Total deudores este mes: <strong><?= count($deudores) ?></strong></p>
        </div>
    </div>

    <table class="zulcom-table" id="tablaDeudores">

        <thead class="bg-deudores">
            <tr>
                <th>Cédula</th>
                <th>Cliente</th>
                <th>Teléfono</th>
                <th>Plan</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>

            <?php if (!empty($deudores)): ?>

                <?php foreach ($deudores as $c): ?>

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

                        <td class="plan-text-deuda">
                            <?= htmlspecialchars($c['nombre_plan'] ?? 'Sin plan') ?>
                        </td>

                        <td>
                            <span class="badge-status pendiente">
                                PENDIENTE
                            </span>
                        </td>

                        <td>
                            <div class="actions">
                                <a href="administrador.php?page=crear_factura&cedula=<?= urlencode($c['cedula']) ?>"
                                   class="btn-pagar">
                                    📝 Registrar Pago
                                </a>
                            </div>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="6" class="empty-row">
                        🎉 ¡Excelente! Todos los clientes se encuentran al día.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>