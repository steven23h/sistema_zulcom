<div class="dashboard-content">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="page-header">

        <div>
            <h2 class="page-title">
                💰 Gestión de Roles de Pago
            </h2>

            <p class="page-subtitle">
                Generación y administración de roles de pago del personal.
            </p>
        </div>

    </div>


    <!-- ===================================================== -->
    <!-- CARD PRINCIPAL -->
    <!-- ===================================================== -->

    <div class="form-card">

        <form id="formRol" class="zul-form">

            <!-- ============================================= -->
            <!-- FILA 1 -->
            <!-- ============================================= -->

            <div class="form-row">

                <div class="form-group">
                    <label>Colaborador</label>

                    <select id="colaborador" name="id_trabajador" required>
                        <option value="">
                            Seleccione colaborador
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Salario</label>

                    <input type="number"
                           name="salario"
                           placeholder="Ingrese salario"
                           required>
                </div>

            </div>


            <!-- ============================================= -->
            <!-- FILA 2 -->
            <!-- ============================================= -->

            <div class="form-row">

                <div class="form-group">
                    <label>Periodo</label>

                    <input type="text"
                           name="periodo"
                           id="periodo"
                           readonly>
                </div>

                <div class="form-group">
                    <label>Horas Extra</label>

                    <input type="number"
                           name="horas_extra"
                           placeholder="0">
                </div>

            </div>


            <!-- ============================================= -->
            <!-- FILA 3 -->
            <!-- ============================================= -->

            <div class="form-row">

                <div class="form-group">
                    <label>Décimos</label>

                    <input type="number"
                           name="decimos"
                           value="0">
                </div>

                <div class="form-group">
                    <label>Bonos</label>

                    <input type="number"
                           name="bonos"
                           value="0">
                </div>

            </div>


            <!-- ============================================= -->
            <!-- FILA 4 -->
            <!-- ============================================= -->

            <div class="form-row">

                <div class="form-group full-width">
                    <label>Descuentos</label>

                    <input type="number"
                           name="descuentos"
                           value="0">
                </div>

            </div>


            <!-- ============================================= -->
            <!-- BOTÓN -->
            <!-- ============================================= -->

            <button type="submit"
                    name="crearRol"
                    class="btn-save">

                💾 Generar Rol de Pago

            </button>

        </form>

    </div>

</div>

<script src="/zulcom/public/js/rolespago.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    cargarColaboradores();

    activarFormularioRol();

    asignarPeriodo();

});
</script>