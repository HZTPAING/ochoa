<?php
    // Verificar si una sesión ya está iniciada antes de llamar a session_start()
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Carga el controller.php para manejar las peticiones y redirecciones
    require_once(__DIR__ . '/controller.php');
    // Carga el model.php para trabajar con la base de datos
    require_once(__DIR__ . '/../model/model.php');

    $EmpresaDB = new DatosDB('app_empresa');
    $filtro = new FiltrarDatos();

    if ($_GET) {
        if (isset($_GET['views']) && $_GET['views'] == 'config') {
            // TAB=3 - EMPRESA
            if (isset($_GET['tab']) && $_GET['tab'] == '3') {
                $empresas = $EmpresaDB->ConsultarDatosDB();
                if (isset($empresas) && !empty($empresas)) {
                    foreach ($empresas as $empresa);
                }
            }
        }
    }

    if ($_POST) {
        // limpiar los dados en la variabla GET y validarla
        $datos_post = $filtro->Filtrar($_POST);
        if (isset($datos_post['action']) && !empty($datos_post['action'])) {
            // ADD_EMPRESA
            if ($_POST['action'] == 'ADD_EMPRESA') {
                foreach ($_POST as $key => $valor) {
                    if ($key == 'action' || $key == 'rowid') {
                    } else {

                        $datos[$key] = $valor;
                    }
                }

                $res = $EmpresaDB->GuardarDatosDB($datos);
                if ($res == 1) {
                    $msn = '<div class="alert alert-success">Datos actualizados correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&res=' . urlencode($msn));
                } else {
                    $msn = '<div class="alert alert-danger">No se han podido actualizar los datos correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&res=' . urlencode($msn));
                }
            }
            // EDIT_EMPRESA
            if ($_POST['action'] == 'EDIT_EMPRESA') {
                foreach ($_POST as $key => $valor) {
                    if ($key == 'action') {
                    } else {

                        $datos[$key] = $valor;
                    }
                }

                $res = $EmpresaDB->GuardarDatosDB($datos, $_POST['rowid']);
                if ($res == 1) {
                    $msn = '<div class="alert alert-success">Datos actualizados correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&res=' . urlencode($msn));
                } else {
                    $msn = '<div class="alert alert-danger">No se han podido actualizar los datos correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&res=' . urlencode($msn));
                }
            }
        }
    }
