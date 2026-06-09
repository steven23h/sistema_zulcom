<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../controllers/rolpagoController.php';

$controller = new RolPagoController();

$resultado = null;

// GENERAR ROL
if (isset($_POST['crearRol'])) {
    $resultado = $controller->crearRolPago($_POST);
}
$colaboradores = $controller->listarColaboradores();
?>

<div class="dashboard-content">
    <link rel="stylesheet" href="../../css/styles.css">
   <link rel="stylesheet" href="../../public/css/navbar.css">
    <!-- HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                Gestión de Roles de Pago
            </h1>

            <p class="page-subtitle">
                Genera y administra los roles de pago de los colaboradores.
            </p>
        </div>
    </div>

    <p class="stats-text">
        Complete los datos necesarios para generar el rol de pago.
    </p>
    <?php
    if (!empty($resultado['mensaje'])) {
        echo "<script>alert('" . $resultado['mensaje'] . "');</script>";
    }
    ?>
    <?php if ($resultado): ?>

        <div class="alert alert-info">
            <?= $resultado['mensaje']; ?>
        </div>

    <?php endif; ?>
    <hr class="divider">

    <div class="module-card">

        <form id="formRol" method="POST">

            <div class="form-grid">

                <div class="form-group">
                    <label>Colaborador</label>

                    <select id="colaborador" name="id_trabajador" required>

                        <option value="">Seleccione colaborador</option>

                        <?php foreach ($colaboradores as $col): ?>

                            <option value="<?= $col['id_trabajador']; ?>">
                                <?= $col['nombres']; ?>
                                <?= $col['apellidos']; ?>
                                - <?= $col['cargo']; ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label>Salario</label>

                    <input
                        type="number"
                        name="salario"
                        required>
                </div>

                <div class="form-group">
                    <label>Periodo</label>

                    <input
                        type="text"
                        name="periodo"
                        id="periodo"
                        readonly>
                </div>

                <div class="form-group">
                    <label>Horas Extra</label>

                    <input
                        type="number"
                        name="horas_extra"
                        value="0">
                </div>

                <div class="form-group">
                    <label>Décimos</label>

                    <input
                        type="number"
                        name="decimos"
                        value="0">
                </div>

                <div class="form-group">
                    <label>Bonos</label>

                    <input
                        type="number"
                        name="bonos"
                        value="0">
                </div>

                <div class="form-group">
                    <label>Descuentos</label>

                    <input
                        type="number"
                        name="descuentos"
                        value="0">
                </div>

            </div>

            <div class="actions-container">
                <button
                    type="submit"
                    name="crearRol"
                    class="btn-success-custom">
                    + Generar Rol
                </button>
            </div>

        </form>

    </div>

</div>

<script src="/zulcom2/public/js/rolespago.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        activarFormularioRol();
        asignarPeriodo();
    });
</script>