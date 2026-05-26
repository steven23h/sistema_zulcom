<?php
require_once '../../controllers/ClientesController.php';
$clienteCtrl = new ClientesController();
$deudores = $clienteCtrl->listarDeudores();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes Pendientes de Pago - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/cliente.css">
</head>
<body>

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
                    <td style="font-weight: bold;"><?= htmlspecialchars($c['cedula']) ?></td>
                    <td><?= htmlspecialchars($c['nombre'] . " " . $c['apellido']) ?></td>
                    <td><?= htmlspecialchars($c['telefono1']) ?></td>
                    <td class="plan-text-deuda"><?= htmlspecialchars($c['nombre_plan'] ?? 'Sin plan') ?></td>
                    <td>
                        <span class="badge-status pendiente">
                            PENDIENTE
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="administrador.php?page=crear_factura&cedula=<?= urlencode($c['cedula']) ?>" class="btn-pagar">
                                📝 Registrar Pago
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 40px; color: #999; font-size: 1.3rem;">
                        🎉 ¡Excelente! Todos los clientes se encuentran al día.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>