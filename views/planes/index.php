<?php
require_once '../../controllers/PlanesController.php';
$controller = new PlanesController();
$planes = $controller->listarPlanes();
?>
<link rel="stylesheet" href="../../public/css/planes.css">

<div class="planes-container">

    <div class="content-header-flex">
        <div>
            <h2>Planes de Internet</h2>
            <p>Configuración de servicios contratables</p>
        </div>
        <a href="administrador.php?page=crear_plan" class="btn-new">
            ➕ Nuevo Plan
        </a>
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
                            <td class="plan-name-cell"><?= htmlspecialchars($p['nombre_plan']) ?></td>
                            <td>
                                <span class="badge-megas"><?= $p['megas'] ?> Mbps</span>
                            </td>
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
                    <tr>
                        <td colspan="5" class="table-empty-cell">
                            No hay planes registrados
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="../../public/js/planes.js"></script>