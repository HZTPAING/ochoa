<?php
// Verificamos la variabla $_GET['action'] es 'edt_tarea_user' o es 'add_tarea_user'
// para identificar el formulario ADD o EDIT
if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'add_tarea_user') {
?>

    <h3>Añadir tareas de usuario actual</h3>

    <form class="form-control" method="post" action="/oficina/controller/tareas.php">
        <div class="row p-2">
            <div class="col-lg-12">
                <input class="form-control" type="text" name="nombre" placeholder="El nombre de la tarea" required>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-lg-12">
                <textarea class="form-control" name="descripcion" id="idDescr" rows="10" placeholder="La descripcion de la tarea"></textarea>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-lg-4">
                <input class="form-control" type="datetime-local" name="horaProgram" id="idHoraProgram" placeholder="La hora programada de la tarea">
            </div>
            <div class="col-lg-4">
                <input class="form-control" type="date" name="fechaInicio" id="idFechaInicio" placeholder="La fecha de inicio">
            </div>
            <div class="col-lg-4">
                <input class="form-control" type="date" name="fechaFinal" id="idFechaFinal" placeholder="La fecha de final">
            </div>
        </div>
        <div class="row p-2">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <!-- icono de "circle-dot" de https://fontawesome.com/ -->
                    <span class="input-group-text" id="ico-estado"><i id="idIcoE" class="fa-solid fa-circle-dot"></i></span>
                    <select onchange="CambioColor(this.value)" class="form-select" name="estado" id="idEstado" aria-describedby="ico-estado">
                        <option></option>
                        <option value="activa">Activa</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="finalizada">Finalizada</option>
                        <option value="en_marcha">En marcha</option>
                        <option value="cancelada">Cancelada</option>
                        <option value="fallada">Fallada</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="idUser" id="idUser" value="<?php echo $_SESSION['rowid']; ?>">
                <input type="hidden" name="action" value="ADD_TAREA_USER">
                <input class="btn btn-success" type="submit" value="GUARDAR" style="margin: 1.5rem;">
                <input class="btn btn-danger" type="reset" value="RESET" style="margin: 1.5rem;">
            </div>
        </div>
    </form>

<?php
} else if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edt_tarea_user') {
?>

    <h3>Editar tarea de usuario actual</h3>

    <form class="form-control" method="post" action="/oficina/controller/tareas.php">
        <div class="row p-2">
            <div class="col-lg-12">
                <input class="form-control" type="text" name="nombre" placeholder="El nombre de la tarea" value="<?php echo $datosTareas_user['nombre']; ?>" required>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-lg-12">
                <textarea class="form-control" name="descripcion" id="idDescr" rows="10" placeholder="La descripcion de la tarea"><?php echo $datosTareas_user['descripcion']; ?></textarea>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-lg-4">
                <input class="form-control" type="datetime-local" name="horaProgram" id="idHoraProgram" value="<?php echo $datosTareas_user['horaProgramada']; ?>">
            </div>
            <div class="col-lg-4">
                <input class="form-control" type="date" name="fechaInicio" id="idFechaInicio" value="<?php echo $datosTareas_user['inicio']; ?>">
            </div>
            <div class="col-lg-4">
                <input class="form-control" type="date" name="fechaFinal" id="idFechaFinal" value="<?php echo $datosTareas_user['final']; ?>">
            </div>
        </div>
        <div class="row p-2">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <!-- icono de "circle-dot" de https://fontawesome.com/ -->
                    <span class="input-group-text" id="ico-estado"><i id="idIcoE" class="fa-solid fa-circle-dot"></i></span>
                    <select onchange="CambioColor(this.value)" class="form-select" name="estado" id="idEstado" aria-describedby="ico-estado">
                        <option value="activa" <?php if ($datosTareas_user['estado'] == 'activa') echo 'selected'; ?>>Activa</option>
                        <option value="pendiente" <?php if ($datosTareas_user['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                        <option value="finalizada" <?php if ($datosTareas_user['estado'] == 'finalizada') echo 'selected' ?>>Finalizada</option>
                        <option value="en_marcha" <?php if ($datosTareas_user['estado'] == 'en_marcha') echo 'selected' ?>>En marcha</option>
                        <option value="cancelada" <?php if ($datosTareas_user['estado'] == 'cancelada') echo 'selected' ?>>Cancelada</option>
                        <option value="fallada" <?php if ($datosTareas_user['estado'] == 'fallada') echo 'selected' ?>>Fallada</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="idTarea" id="idTarea" value="<?php echo $datosTareas_user['rowid']; ?>">
                <input type="hidden" name="idUser" id="idUser" value="<?php echo $datosTareas_user['idUser']; ?>">
                <input type="hidden" name="action" value="EDT_TAREA_USER">
                <input class="btn btn-success" type="submit" value="GUARDAR" style="margin: 1.5rem;">
                <input class="btn btn-danger" type="reset" value="RESET" style="margin: 1.5rem;">
            </div>
        </div>
    </form>

<?php
}
?>

<script>
    // El escript para precargar el fichero /css/nombre.css
    var cssId = 'idCss';
    if (!document.getElementById(cssId)) {
        var head = document.getElementsByTagName('head')[0];
        var link = document.createElement('link');
        link.id = cssId;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = 'https://SuWeb.com/nombre.css';
        link.media = 'all';
        head.appendChild(link);
    }
</script>

<script>
    // El escript para precargar el fichero /js/tareas.js
    var jsId = 'TareasJs';
    if (!document.getElementById(jsId)) {
        var body = document.getElementsByTagName('body')[0];
        var script = document.createElement('script');
        script.id = jsId;
        script.src = '/js/tareas.js';
        body.appendChild(script);
    }
</script>