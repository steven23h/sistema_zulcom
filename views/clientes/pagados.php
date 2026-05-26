<?php
require_once '../../controllers/ClientesController.php';
$clienteCtrl = new ClientesController();
$noDeudores = $clienteCtrl->listarPagados();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes al Día - Zulcom</title>
    <link rel="stylesheet" href="../../public/css/cliente.css">
</head>
<body>

<div class="table-container">
    <div class="header-seccion-pagados">
        <div>
            <h2>✅ Clientes al Día (Pagados)</h2>
            <p>Total pagados este mes: <strong><?= count($noDeudores) ?></strong></p>
        </div>
    </div>

    <table class="zulcom-table" id="tablaPagados">
        <thead class="bg-pagados">
            <tr>
                <th>Cédula</th>
                <th>Cliente</th>
                <th>Teléfono</th>
                <th>Plan</th>
                <th>Fecha de Pago</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($noDeudores)): ?>
                <?php foreach ($noDeudores as $c): ?>
                <tr>
                    <td style="font-weight: bold;"><?= htmlspecialchars($c['cedula']) ?></td>
                    <td><?= htmlspecialchars($c['nombre'] . " " . $c['apellido']) ?></td>
                    <td><?= htmlspecialchars($c['telefono1']) ?></td>
                    <td class="plan-text"><?= htmlspecialchars($c['nombre_plan'] ?? 'Sin plan') ?></td>
                    <td class="fecha-pago-text">
                        <?= !empty($c['fecha_pago']) ? date('d/m/Y - H:i', strtotime($c['fecha_pago'])) : 'N/A' ?>
                    </td>
                    <td>
                        <span class="badge-status pagado">
                            PAGADO
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 40px; color: #999; font-size: 1.3rem;">
                        No se registran cobros efectuados para este periodo.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>