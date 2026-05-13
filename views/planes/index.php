<?php

require_once '../../controllers/PlanesController.php';

$planCtrl = new PlanesController();

$planes = $planCtrl->index();

?>

<link rel="stylesheet" href="/zulcom/public/css/planes.css">

<div class="planes-container">

    <!-- HEADER -->
    <div class="header-seccion">

        <div>

            <h2>Planes de Internet</h2>

            <p>
                Configuración de servicios contratables
            </p>

        </div>

        <a href="administrador.php?page=crear_plan"
           class="btn-new">

            ➕ Nuevo Plan

        </a>

    </div>

    <!-- BUSCADOR -->
    <input type="text"
           id="planSearch"
           class="search-input"
           placeholder="Buscar plan por nombre o velocidad...">

    <!-- TABLA -->
    <div class="table-container">

        <table class="zulcom-table"
               id="tablaPlanes">

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

                            <td>
                                #<?= $p['id_plan'] ?>
                            </td>

                            <td style="font-weight:600;">

                                <?= htmlspecialchars($p['nombre_plan']) ?>

                            </td>

                            <td>

                                <span class="badge-megas">

                                    <?= htmlspecialchars($p['megas']) ?> Mbps

                                </span>

                            </td>

                            <td class="costo">

                                $<?= number_format($p['costo'], 2) ?>

                            </td>

                            <td>

                                <div class="actions">

                                    <!-- EDITAR -->
                                    <a href="administrador.php?page=editar_plan&id=<?= $p['id_plan'] ?>"
                                       class="btn-edit">

                                        ✏️

                                    </a>

                                    <!-- ELIMINAR -->
                                    <a href="administrador.php?action=eliminar_plan&id=<?= $p['id_plan'] ?>"
                                       class="btn-delete"
                                       onclick="return confirm('¿Eliminar este plan?')">

                                        🗑️

                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5"
                            style="text-align:center;padding:40px;">

                            No hay planes registrados

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<script src="/zulcom/public/js/planes.js"></script>