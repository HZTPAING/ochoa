<?php
// Verificamos la variable $_GET['action'] para identificar el formulario ADD o EDIT
if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'add_user') {
?>

    <h3>Nuevo Usuario</h3>

    <form class="form-control" method="post" action="/oficina/controller/usuarios.php">
        <div class="row p-2">
            <div class="col-lg-4">
                <input class="form-control" type="text" name="name" placeholder="Nombre de usuario:" minlength="5" maxlength="15" required>
            </div>
            <div class="col-lg-4">
                <input id="pass1" class="form-control" type="password" placeholder="Contraseña:" minlength="5" maxlength="15" required>
            </div>
            <div class="col-lg-4">
                <input id="pass2" onchange="Validarpass(this.Value)" class="form-control" type="password" name="pass" placeholder="Repite la contraseña:" minlength="5" maxlength="15" required>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <input class="form-control" type="email" name="email" placeholder="Correo Electronico:" minlength="10" maxlength="150" required>
                    <span class="input-group-text" id="basic-addon2">@example.com</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <label for="labstatus">Estado del Usuario</label>
                <select class="form-select" name="status" id="labstatus">
                    <option value=""></option>
                    <option value="1">Bloqueado</option>
                    <option value="2">Activo</option>
                </select>
            </div>
            <div class="col-lg-6">
                <input type="hidden" name="action" value="FORM_REG_USER">
                <input class="btn btn-success" type="submit" value="GUARDAR" style="margin-top: 1.5rem;">
                <input class="btn btn-danger" type="reset" value="RESET" style="margin-top: 1.5rem;">
            </div>
        </div>
    </form>

<?php
} else if (isset($_GET['action']) and !empty($_GET['action']) and $_GET['action'] == 'edt_user') {
?>

    <h3>Editar Uusuario</h3>

    <form class="form-control" method="post" action="/oficina/controller/usuarios.php">
        <div class="row p-2">
            <div class="col-lg-4">
                <input class="form-control" type="text" name="name" placeholder="Nombre de usuario:" minlength="5" maxlength="15" value="<?php echo $datosUser['name']; ?>" required>
            </div>
            <div class="col-lg-4">
                <input id="pass1" class="form-control" type="password" placeholder="Contraseña:" minlength="5" maxlength="15">
            </div>
            <div class="col-lg-4">
                <input id="pass2" onchange="Validarpass(this.Value)" class="form-control" type="password" name="pass" placeholder="Repite la contraseña:" minlength="5" maxlength="15">
            </div>
        </div>

        <div class="row p-2">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <input class="form-control" type="email" name="email" placeholder="Correo Electronico:" minlength="10" maxlength="150" value="<?php echo $datosUser['email']; ?>" required>
                    <span class="input-group-text" id="basic-addon2">@example.com</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <label for="labstatus">Estado del Usuario</label>
                <?php
                if ($datosUser['status'] == 2) {
                    $sel2 = "selected";
                } else {
                    $sel2 = "";
                }
                if ($datosUser['status'] == 1) {
                    $sel1 = "selected";
                } else {
                    $sel1 = "";
                }
                ?>
                <select class="form-select" name="status" id="labstatus">
                    <option value=""></option>
                    <option value="1" <?php echo $sel1; ?>>Bloqueado</option>
                    <option value="2" <?php echo $sel2; ?>>Activo</option>
                </select>
            </div>
            <div class="col-lg-6">
                <input type="hidden" name="rowid" value="<?php echo $datosUser['rowid'] ?>">
                <input type="hidden" name="action" value="FORM_UPD_USER">
                <input class="btn btn-success" type="submit" value="GUARDAR" style="margin-top: 1.5rem;">
                <input class="btn btn-danger" type="submit" value="RESET" style="margin-top: 1.5rem;">
            </div>
        </div>
    </form>

    <form class="form-control container" method="post" action="">
        <label>Asignar el Rol del Usuario:</label>
        <select class="form-select" name="idrol" required>
            <option></option>
            <?php
            if (isset($datosrol)) {
                foreach ($datosrol as $datorol) {
                    foreach ($relRol as $rol) {
                        if (isset($rol) and !empty($rol['iduser']) && $rol['iduser'] == $datosUser['rowid']) {
                            if ($rol['idrol'] == $datorol['rowid']) {
                                $role = "selected";
                            } else {
                                $role = "";
                            }
                        }
                    }
                    echo '<option value="' . $datorol['rowid'] . '" ' . $role . ' >' . $datorol['nombre'] . '</option>';
                }
            }
            ?>
        </select>
        <?php
        if (isset($relRol) && !empty($relRol)) {
            foreach ($relRol as $rol) {
                if (isset($rol['idrol']) and !empty($rol['idrol'])) {
                    echo '<input type="hidden" name="rowid" value="' . $rol['rowid'] . '" />';
                }
            }
        }
        ?>
        <input type="hidden" name="iduser" value="<?php echo $datosUser['rowid']; ?>" />
        <input type="hidden" name="action" value="FORM_UPDATE_ROL_USER" />
        <input class="btn btn-success" type="submit" value="Guardar" style="margin-top:1.4rem" />
    </form>

<?php
}
?>

<script>
    // Validación de contraseñas
    /*
    document.getElementById("pass1").addEventListener("input", function () {
        var pass1 = document.getElementById("pass1").value;
        var pass2 = document.getElementById("pass2").value;
        if (pass1!= pass2) {
            document.getElementById("pass2").setCustomValidity("Las contraseñas no coinciden.");
        } else {
            document.getElementById("pass2").setCustomValidity("");
        }
        this.checkValidity();
    }
    */
    // Validación de contraseñas con AJAX
    /*
    function Validarpass(pass) {
        var data = {
            'accion': 'VALIDAR_PASS',
            'pass': pass
        };
        $.ajax({
            url: 'controllers/usuarios.php',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response == '1') {
                    document.getElementById("pass2").setCustomValidity("La contraseña debe tener al menos 5 caracteres y no puede ser igual a la anterior.");
                } else {
                    document.getElementById("pass2").setCustomValidity("");
                }
                this.checkValidity();
            }
        });
    }
    */
    let pass1 = document.getElementById('pass1');
    let pass2 = document.getElementById('pass2');
    let res = document.getElementById('res');

    function ValidarPass(ValPass2) {
        if (pass1.value != ValPass2) {
            pass2.style.backgroundColor = "red";
            pass2.Value = "";
            res.innerHTML = '<div class="alert alert-danger">Las contraseñas no considen!!!</div>';
        }
    }
</script>