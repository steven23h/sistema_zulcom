<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administracion') {
    die("Acceso denegado.");
}

require_once '../../controllers/AuthController.php';

$authCtrl = new AuthController();
$usuarios = $authCtrl->listUsers();
?>

<div class="header-seccion">

    <div>
        <h2>Gestión de Personal</h2>
        <p>Total colaboradores: <strong><?= count($usuarios) ?></strong></p>
    </div>

    <a href="administrador.php?page=registrar" class="btn-new">
        ➕ Registrar Personal
    </a>

</div>

<input
    type="text"
    id="personalSearch"
    class="search-input"
    placeholder="Buscar colaborador por nombre, cédula o usuario...">

<div class="table-container">

    <table class="zulcom-table" id="tablaPersonal">

        <thead>
            <tr>
                <th>Cédula</th>
                <th>Colaborador</th>
                <th>Usuario</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Rol / Cargo</th>
            </tr>
        </thead>

        <tbody>

            <?php if (!empty($usuarios)): ?>

                <?php foreach ($usuarios as $u): ?>

                    <tr>

                        <td class="text-bold">
                            <?= htmlspecialchars($u['cedula']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['nombres'] . " " . $u['apellidos']) ?>
                        </td>

                        <td>
                            <span class="ip-code">
                                <?= htmlspecialchars($u['username']) ?>
                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['telefono']) ?>
                        </td>

                        <td>
                            <span class="badge-status <?= strtolower($u['role']) === 'administracion' ? 'activo' : 'pendiente' ?>">
                                <?= htmlspecialchars($u['role']) ?>
                            </span>
                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="6" class="empty-row">
                        No hay colaboradores registrados en el sistema.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>

<script src="../../public/js/register.js"></script>