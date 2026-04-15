<?php
// Cargamos el controlador y obtenemos los datos reales
require_once '../../controllers/PlanesController.php';
$controller = new PlanesController();
$planes = $controller->listarPlanes();
?>

<div class="planes-container">
    <div class="content-header-flex">
        <h2>Lista de Planes Disponibles</h2>
        <a href="administrador.php?page=crear_plan" class="btn">
            + Nuevo Plan
        </a>
    </div>

   

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nombre del Plan</th>
                    <th>Costo</th>
                    <th>Velocidad</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($planes)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">No hay planes registrados aún.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($planes as $plan): ?>
                        <tr>
                            <td><?= htmlspecialchars($plan['nombre_plan']) ?></td>
                            <td>$<?= number_format($plan['costo'], 2) ?></td>
                            <td><?= htmlspecialchars($plan['megas']) ?> Mbps</td>
                            <td class="actions-cell">
                                <a href="#" class="btn btn-sm">Editar</a>
                                <a href="#" class="btn danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>