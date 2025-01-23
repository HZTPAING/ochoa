<h3>Listado de usuarios</h3>
<a class="btn btn-primary" href="/oficina/index.php?views=usuarios&&action=add_user">Nuevo USUARIO</a>
<table id="table-users" class="table table-striped table-primary table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>eMail</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (isset($datosUsers)) {
                $i = 1;
                foreach ($datosUsers as $DatosUser) {
                    if ($DatosUser['status'] == 2) {
                        $checked = "checked";
                    } else {
                        $checked = "";
                    }
                    // Convertir el array PHP a JSON
                    $DatosUserJson = json_encode($DatosUser);
                    echo '<tr>';
                    echo '<td>'. $i. '</td>';
                    echo '<td>'. $DatosUser['name']. '</td>';
                    echo '<td>'. $DatosUser['email']. '</td>';
                    echo '<td>
                        <div class="form-check form-switch">
                            <input onchange=\'CStatus(' . $DatosUserJson . ')\' class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"' . $checked . ' >
                        </div>
                    </td>';
                    echo '<td><a class="btn btn-success" href="/oficina/index.php?views=usuarios&&action=edt_user&&id=' . base64_encode($DatosUser['rowid']) . '"><i class="fa-solid fa-pen-to-square"></i></td>';
                    // echo '<td><a class="btn btn-danger" href="controllers/usuarios.php?views=usuarios&&action=del_user&&id=' . base64_encode($DatosUser['rowid']) . '"><i class="fa-solid fa-trash"></i></td>';
                    echo '<td><a class="btn btn-danger" href="#" onclick="confirmarBorrado(\'' . base64_encode($DatosUser['rowid']) . '\', \'' . addslashes(base64_encode($DatosUser['name'])) . '\', \'usuarios\', \'del_user\')"><i class="fa-solid fa-trash"></i></a></td>';
                    /*
                    echo '<td>'. $DatosUser['user']. '</td>';
                    echo '<td>'. $DatosUser['email']. '</td>';
                    echo '<td>'. ($DatosUser['status'] == 1? 'Activo' : 'Inactivo'). '</td>';
                    echo '<td><a href="editar_usuario.php?id='. $DatosUser['id']. '" class="btn btn-warning">Editar</a></td>';
                    echo '<td><a href="borrar_usuario.php?id='. $DatosUser['id']. '" class="btn btn-danger">Borrar</a></td>';
                    */
                    echo '</tr>';
                    $i++;
                }
            }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
</table>

<script>
    let table = new DataTable('#table-users');
    //
    function CStatus(DatosUser) {
        // jQuery and JSON
        // Extraer valores del array DatosUser
        let id = DatosUser.rowid;
        let name = DatosUser.name;
        let email = DatosUser.email;
        //
        Data = {'action' : 'CAMBIAR_STATUS_USER', 'id' : id}
        // Enviar los parametros a controlador atraves de una tecnica AJAX
        $.post('/controllers/usuarios.php', Data, function(res) {
            // Recibir respuesta del controlador
            /*
            let respuesta = JSON.parse(res);
            // Mostrar mensaje en pantalla
            alert(respuesta.mensaje);
            */
            if (res == 1) {
                $('#res').html('<div class="alert alert-success">El estatus de usuario <strong>' + DatosUser.email + '</strong> actualizado correctamente</div>');
            } else {
                $('#res').html('<div class="alert alert-danger">Error al actualizar el estatus de usuario en la BD</div>');
            }

        })
    }
</script>