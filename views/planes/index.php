<?php
<<<<<<< HEAD
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
=======
require_once '../../controllers/PlanesController.php';
$planCtrl = new PlanesController();
$planes = $planCtrl->index();
?>
<link rel="stylesheet" href="../../public/css/planes.css">

<div class="header-seccion">
    <div>
        <h2>Planes de Internet</h2>
        <p>Configuración de servicios contratables</p>
    </div>
    <a href="administrador.php?page=crear_planes" class="btn-new">➕ Nuevo Plan</a>
</div>

<input type="text" id="planSearch" class="search-input" placeholder="Buscar plan por nombre o velocidad...">

<div class="table-container">
    <table class="zulcom-table" id="tablaPlanes">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Velocidad</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($planes)): ?>
                <?php foreach ($planes as $p): ?>
                <tr>
                    <td>#<?= $p['id_plan'] ?></td>
                    <td style="font-weight: 600;"><?= htmlspecialchars($p['nombre_plan']) ?></td>
                    <td><span class="badge-megas"><?= $p['megas'] ?> Mbps</span></td>
                    <td class="costo">$<?= number_format($p['costo'], 2) ?></td>
                    <td>
                        <div class="actions">
                            <a href="administrador.php?page=editar_plan&id=<?= $p['id_plan'] ?>" class="btn-edit">✏️</a>
                            <a href="administrador.php?action=eliminar_plan&id=<?= $p['id_plan'] ?>" class="btn-delete" onclick="return confirm('¿Eliminar este plan?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center; padding:40px;">No hay planes registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="../../public/js/planes.js"></script>
>>>>>>> master
