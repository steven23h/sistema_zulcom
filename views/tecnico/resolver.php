<?php
require_once '../../controllers/TecnicoController.php';

// 🔥 Validar ID
if (!isset($_GET['id'])) {
    echo "Ticket no válido";
    exit;
}

$id = $_GET['id'];

// 🔥 Usar controlador de técnico
$tecnicoCtrl = new TecnicoController();
$ticket = $tecnicoCtrl->show($id);

if (!$ticket) {
    echo "Ticket no encontrado";
    exit;
}
?>

<h2>Resolver Ticket</h2>

<p><strong>Número:</strong> <?= $ticket['numero_ticket'] ?></p>
<p><strong>Cliente:</strong> <?= $ticket['nombre'].' '.$ticket['apellido'] ?></p>
<p><strong>Descripción:</strong> <?= $ticket['descripcion'] ?></p>

<p><strong>Fecha solución:</strong> <span id="fechaSol"></span></p>
<p><strong>Hora solución:</strong> <span id="horaSol"></span></p>

<form method="POST" action="../../controllers/TecnicoController.php">

    <input type="hidden" name="id" value="<?= $ticket['id'] ?>">

    <div>
        <label>Solución:</label><br>
        <textarea name="solution" required></textarea>
    </div>

    <div>
        <label>Estado:</label>
        <select name="status" required>
            <option value="Completado">Completado</option>
            <option value="Cerrado">Cerrado</option>
        </select>
    </div>

    <br>

    <button type="submit" name="resolver_ticket">
        Guardar solución
    </button>

</form>

<script>
let ahora = new Date();

document.getElementById('fechaSol').innerText = ahora.toLocaleDateString('es-EC');
document.getElementById('horaSol').innerText = ahora.toLocaleTimeString('es-EC');
</script>