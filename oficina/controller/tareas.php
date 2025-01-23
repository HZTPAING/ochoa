<?php
    // Verificar si una sesión ya está iniciada antes de llamar a session_start()
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once(__DIR__ . '/controller.php');
    require_once(__DIR__ . '/../model/model.php');

    $datosDB = new TareasDB();
    $filtro = new FiltrarDatos();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && !empty($_POST['action']))  {
            // Filtrar los datos del POST y validarlos
            $datos_post = $filtro->Filtrar($_POST);
            // action = ADD_TAREA_USER
            if ($datos_post['action'] == 'ADD_TAREA_USER') {
                $res = $datosDB->GuardarTareaDB($datos_post);
                if ($res) {
                    $mensage = '<div class="alert alert-success">La tarea <strong>' . $datos_post['nombre'] . '</strong> guardado correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=tareas_user&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al guardar la tarea en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=tareas_user&&res=' . urlencode($mensage));
                }
            }
            // action = EDT_TAREA_USER
            if ($datos_post['action'] == 'EDT_TAREA_USER') {
                // Editar la tarea de usuario
                $datos['rowid'] = $datos_post['idTarea'];
                $datos['nombre'] = $datos_post['nombre'];
                $datos['descripcion'] = $datos_post['descripcion'];
                $datos['horaProgram'] = $datos_post['horaProgram'];
                $datos['fechaInicio'] = $datos_post['fechaInicio'];
                $datos['fechaFinal'] = $datos_post['fechaFinal'];
                $datos['estadoID'] = 0;
                $datos['estado'] = $datos_post['estado'];
                $res = $datosDB->UpdateTareaDB($datos);
                if ($res) {
                    $mensage = '<div class="alert alert-success">La tarea <strong>'.$datos_post['nombre'].'</strong> modificado correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=tareas_user&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al modificar la tarea en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=tareas_user&&res=' . urlencode($mensage));
                }
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // limpiar los dados en la variabla GET y validarla
        $datos_get = $filtro->Filtrar($_GET);
        if (isset($datos_get['views']) && !empty($datos_get['views'])) {
            if ($datos_get['views'] == 'tareas_user') {
                // Mostrar la lista de las tareas
                if (isset($_SESSION['rowid']) && !empty($_SESSION['rowid'])) {
                    if (!isset($datos_get['action']) || empty($datos_get['action'])) {
                        // Selecionamos las tareas del usuario de BD
                        $datosTareas_user = $datosDB->ListaTareasDB_usuario($_SESSION['rowid']);
                    } else {
                        // action = edt_tarea_user [Editar tarea de usuario]
                        if ($datos_get['action'] == 'edt_tarea_user') {
                            $rowid = base64_decode($datos_get['id']);
                            $datosTareas_user = $datosDB->BuscarTareaDB_id($rowid);
                        }
                        // action = del_tarea_user [Borrar tarea de usuario]
                        if ($datos_get['action'] == 'del_tarea_user') {
                            $rowid = base64_decode($datos_get['id']);
                            $res = $datosDB->BorrarTareaDB_id($rowid);
                            if ($res == 1) {
                                $mensage = '<div class="alert alert-success">La tarea <strong>' . base64_decode($datos_get['nombre']) . '</strong> borrada correctamente</div>';
                                header('location:' . BASE_URL . '/oficina/index.php?views=tareas_user&&res=' . urlencode($mensage));
                            } else {
                                $mensage = '<div class="alert alert-danger">Error al borrar la tarea en la BD</div>';
                                header('location:' . BASE_URL . '/oficina/index.php?views=tareas_user&&res=' . urlencode($mensage));
                            }
                        }
                    }
                }
            }

        }
    }

    function EstadoColor ($estado) {
        $color = 'black';
        if ($estado == "activa")
            $color = "blue";
        if ($estado == "pendiente")
            $color = "yellow";
        if ($estado == "finalizada")
            $color = "green";
        if ($estado == "en_marcha")
            $color = "orange";
        if ($estado == "cancelada")
            $color = "red";
        if ($estado == "fallada")
            $color = "blpurpleue";
        return $color;
    }
?>