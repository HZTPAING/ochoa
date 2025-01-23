<h3>Listado de tareas</h3>
<a class="btn btn-primary" href="/oficina/index.php?views=tareas_user&&action=add_tarea_user">Nueva TAREA</a>
<table id="table-tareas" class="table table-scriped table-primary table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Tarea</th>
            <th>Descripcion</th>
            <th>Hora programada</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Final</th>
            <th>Estado</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (isset($datosTareas_user)) {
                // Mostramos las tareas de la base de datos para usuario actual
                $i = 1;
                foreach ($datosTareas_user as $datosTarea_user) {
                    // Formatear las fechas
                    $inicio_formateado = date('d-m-Y', strtotime($datosTarea_user['inicio']));
                    $final_formateado = date('d-m-Y', strtotime($datosTarea_user['final']));
                    $horaProgramada_formateada = date('d-m-Y H:i', strtotime($datosTarea_user['horaProgramada']));
                    echo '<tr>';
                        echo '<td>' . $datosTarea_user['rowid'] . '</td>';
                        echo '<td>' . $datosTarea_user['name_user'] . '</td>';
                        echo '<td>' . $datosTarea_user['nombre'] . '</td>';
                        echo '<td>' . $datosTarea_user['descripcion'] . '</td>';
                        echo '<td>' . $horaProgramada_formateada . '</td>';
                        echo '<td>' . $inicio_formateado . '</td>';
                        echo '<td>' . $final_formateado . '</td>';
                        $color = EstadoColor($datosTarea_user['estado']);
                        echo '<td class="text-center"><i id="idIcoE" class="fa-solid fa-circle-dot" style="color: ' . $color . '"></i>' . $datosTarea_user['estado'] . '</td>';
                        // echo '<td>' . $datosTarea_user['estado'] . '</td>';
                        // Dibujamos los botones de borrar y editar las filas
                        echo '<td><a class="btn btn-success" href="/oficina/index.php?views=tareas_user&&action=edt_tarea_user&&id=' . base64_encode($datosTarea_user['rowid']) . '"><i class="fa-solid fa-pen-to-square"></i></td>';
                        //echo '<td><a class="btn btn-danger" href="controllers/tareas.php?views=tareas_user&&action=del_tarea_user&&id=' . base64_encode($datosTarea_user['rowid']) . '&&nombre=' . base64_encode($datosTarea_user['nombre']) . '"><i class="fa-solid fa-trash"></i></td>';
                        // Boton de borrar la tarea con la confirmacion
                        // echo '<td><a class="btn btn-danger" href="#" onclick="confirmarBorrado(' . $datosTarea_user['rowid'] . ', ' . $datosTarea_user['nombre'] . ', "tareas_user", "del_tarea_user")"><i class="fa-solid fa-trash"></i></td>';
                        //echo '<td><a class="btn btn-danger" href="#" onclick="confirmarBorrado(' . base64_encode($datosTarea_user['rowid']) . ', \'' . addslashes($datosTarea_user['nombre']) . '\', \'tareas_user\', \'del_tarea_user\')"><i class="fa-solid fa-trash"></i></a></td>';
                        echo '<td><a class="btn btn-danger" href="#" onclick="confirmarBorrado(\'' . base64_encode($datosTarea_user['rowid']) . '\', \'' . addslashes(base64_encode($datosTarea_user['nombre'])) . '\', \'tareas_user\', \'del_tarea_user\')"><i class="fa-solid fa-trash"></i></a></td>';
                    echo '</tr>';
                }
            }
       ?>
    </tbody>
</table>

<script>
    let table = new DataTable('#table-tareas');

</script>