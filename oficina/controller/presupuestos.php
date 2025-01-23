<?php
    // Verificar si una sesión ya está iniciada antes de llamar a session_start()
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once(__DIR__ . '/controller.php');
    require_once(__DIR__ . '/utils.php');
    require_once(__DIR__ . '/../model/model.php');
    require_once(__DIR__ . '/../librerias/presupuestos.php');
    // Carga el mail.php para enviar emails
    require_once(__DIR__ . '/../controller/mail.php');

    $datosDB = new TareasDB();
    $EmpresaDB = new DatosDB('app_empresa');
    $datosPresupDB = new DatosDB('app_presupuestos');
    $datosPresupDetDB = new DatosDB('app_presupuesto_detalles');
    $datosUsersDB = new DatosDB('app_users');
    $filtro = new FiltrarDatos();
    $utils = new Utils();

    if ($_POST) {
        // limpiar los dados en la variabla GET y validarla
        $datos_post = $filtro->Filtrar($_POST);
        if (isset($datos_post['action']) && !empty($datos_post['action'])) {
            // INS_PRESUP
            if ($datos_post['action'] == 'INS_PRESUP') {
                // Accion del añadir presupuesto
                $datos['numero'] = $datos_post['numero'];
                $datos['nombre'] = $datos_post['nombre'];
                $datos['fecha'] = $datos_post['fecha'];
                $datos['fecha_entrega'] = $datos_post['fecha_entrega'];
                $datos['empleado'] = $datos_post['empleado'];
                $datos['idUser'] = $datos_post['user'];
                // Verificamos si el nombre del Item ya existe
                $res = $datosPresupDB->ConsultarDatosCampo('numero', $datos['numero']);
                if ($res) {
                    $mensage = '<div class="alert alert-danger">El nombre del Presupuesto <strong>' . $datos['nombre'] . '</strong> ya existe. Por favor, elige otro nombre.</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=presup_form&&res=' . urlencode($mensage));
                } else {
                    // Añadimos el Presupuesto
                    $res = $datosPresupDB->GuardarDatosDB($datos);
                    if ($res) {
                        $mensage = '<div class="alert alert-success">El Presupuesto <strong>' . $datos['nombre'] . '</strong> añadido correctamente.</div>';
                        header('location:' . BASE_URL . '/oficina/index.php?views=presup_form&&res=' . urlencode($mensage));
                    } else {
                        $mensage = '<div class="alert alert-danger">Error al añadir el Presupuesto en la BD</div>';
                        header('location:' . BASE_URL . '/oficina/index.php?views=presup_form&&res=' . urlencode($mensage));
                    }
                }
            }
            // INS_PRESUP_AJAX
            if ($datos_post['action'] == 'INS_PRESUP_AJAX') {
                // Accion del añadir presupuesto
                $datos['numero'] = $datos_post['numero'];
                $datos['nombre'] = $datos_post['nombre'];
                $datos['fecha'] = $datos_post['fecha'];
                $datos['fecha_entrega'] = $datos_post['fecha_entrega'];
                $datos['empleado'] = $datos_post['empleado'];
                $datos['idUser'] = $datos_post['user'];
                // Verificamos si el nombre del Item ya existe
                $res = $datosPresupDB->ConsultarDatosPresup($datos['numero']);
                if (!empty($res)) {
                    // El nombre del Presupuesto ya existe
                    echo json_encode([
                        'success' => false,
                        'mensaje' => 'El nombre del Presupuesto "<strong>'
                            . $datos['nombre'] .
                        '"</strong> ya existe'
                    ]);
                    exit();
                } else {
                    // Añadimos el Presupuesto
                    $res = $datosPresupDB->GuardarDatosDB($datos);
                    if ($res) {
                        // El Presupuesto ha guardado correctamente
                        echo json_encode([
                            'success' => true,
                            'mensaje' => 'El nombre del Presupuesto "<strong>'
                                . $datos['nombre'] .
                            '"</strong> ha guardado correctamente'
                        ]);
                        exit();
                    } else {
                        // Error al añadir el Presupuesto en la BD
                        echo json_encode([
                            'success' => false,
                            'mensaje' => 'Error al añadir el Presupuesto en la BD'
                        ]);
                        exit();
                    }
                }
            }
            // DELETE_PRESUP_AJAX
            if ($datos_post['action'] == 'DELETE_PRESUP_AJAX') {
                // Accion del Borrar el presupuesto
                $datos['rowId'] = $datos_post['rowId'];
                $datos['presupNumero'] = $datos_post['numero'];

                // Verificamos si el Presupuesto tienen los Detalles
                $res = $datosPresupDB->ConsultarDatosPresupDet($datos['rowId']);
                if (!empty($res)) {
                    // El presupuesto tienen los detalles
                    echo json_encode([
                        'success' => false,
                        'mensaje' => 'El Presupuesto "<strong>'
                            . $datos['presupNumero'] .
                        '"</strong> tiene los Detalles'
                    ]);
                    exit();
                } else {
                    // Añadimos el Presupuesto
                    $res = $datosPresupDB->DeleteDatosId($datos['rowId']);
                    if ($res) {
                        // El Presupuesto ha guardado correctamente
                        echo json_encode([
                            'success' => true,
                            'mensaje' => 'El nombre del Presupuesto "<strong>'
                                . $datos['presupNumero'] .
                            '"</strong> ha borrado correctamente'
                        ]);
                        exit();
                    } else {
                        // Error al añadir el Presupuesto en la BD
                        echo json_encode([
                            'success' => false,
                            'mensaje' => 'Error al borrar el Presupuesto en la BD'
                        ]);
                        exit();
                    }
                }
            }
            // PDF_PRESUP_AJAX
            if ($datos_post['action'] == 'PDF_PRESUP_AJAX') {
                // Accion del crear PDF del presupuesto
                $datosPresup['rowid'] = $datos_post['rowId'];
                $datosPresup['numero'] = $datos_post['numero'];
                $datosPresup['nombre'] = $datos_post['nombre'];
                $datosPresup['fecha'] = $datos_post['fecha'];
                $datosPresup['fecha_entrega'] = $datos_post['fecha_entrega'];
                $datosPresup['empleado'] = $datos_post['empleado'];
                $datosPresup['idUser'] = $datos_post['idUser'];
                // Detalles del Presupuesto
                $datosPresupDet = [];
                // Detalles de la empresa
                $empresaPDF = [];
                // Usuario
                $userPDF = [
                    'nombre' => '',
                    'direccion' => '',
                    'email' => '',
                    'telefono' => ''
                ];
                // Empleado
                $empleadoPDF = '';
                $empresasPDF = $EmpresaDB->ConsultarDatosDB();
                if (isset($empresasPDF) && !empty($empresasPDF)) {
                    foreach ($empresasPDF as $empresaPDF);
                }
                // Instanciamos la clase PDF
                $pdf = new Presupuestos($datosPresup, $datosPresupDet, $empresaPDF, $userPDF, $empleadoPDF, $datosPresup['numero']. '.pdf', false);
                // Generamos el PDF
                $pdf->crearPresupuesto();
                // Enviamos el archivo PDF al navegador
                $pdf->mostrarPDF();
                // Procesamos la respuesta a la vista
                echo json_encode([
                    'success' => true,
                    'mensaje' => 'El PDF del Presupuesto "<strong>'
                        . $datosPresup['nombre'] .
                    '"</strong> se ha creado correctamente'
                ]);
                exit();

            }
            // PDF_PRESUP_MAIL_AJAX
            if ($datos_post['action'] == 'PDF_PRESUP_MAIL_AJAX') {
                // Accion del enviar el PDF del presupuesto por Mail
                // localizar el PDF del presupuest y pasarlo como adjunto del mail
                // mail

                $datosPresup['rowid'] = $datos_post['rowId'];
                $datosPresup['numero'] = $datos_post['numero'];
                $datosPresup['nombre'] = $datos_post['nombre'];
                $datosPresup['fecha'] = $datos_post['fecha'];
                $datosPresup['fecha_entrega'] = $datos_post['fecha_entrega'];
                $datosPresup['empleado'] = $datos_post['empleado'];
                $datosPresup['idUser'] = $datos_post['idUser'];

                // Detalles del Presupuesto
                $datosPresupDet = [];

                // Detalles de la empresa
                $empresaPDF = [];

                // Usuario
                $usersPDF = $datosUsersDB->ConsultarDatosCampo('rowid', $datosPresup['idUser']);
                foreach ($usersPDF as $userPDF);

                /*
                $userPDF = [
                    'nombre' => '',
                    'direccion' => '',
                    'email' => '',
                    'telefono' => ''
                ];
                */
                
                // Empleado
                $empleadoPDF = '';
                $empresasPDF = $EmpresaDB->ConsultarDatosDB();
                if (isset($empresasPDF) && !empty($empresasPDF)) {
                    foreach ($empresasPDF as $empresaPDF);
                }

                // Instanciamos la clase PDF
                $pdf = new Presupuestos($datosPresup, $datosPresupDet, $empresaPDF, $empleadoPDF, $userPDF, $datosPresup['numero']. '.pdf', false);

                // Verificamos si el PDF existe
                $isPdf = $pdf->validarPdf();

                if (!$isPdf) {
                    // El PDF no existe
                    echo json_encode([
                        'success' => false,
                        'error' => 'El PDF del Presupuesto "<strong>'
                            . $datosPresup['numero'] .
                        '"</strong> no se ha generado'
                    ]);
                    exit();
                }

                // Enviamos el archivo PDF al navegador
                $mail = new Mail($userPDF['email'], $userPDF['name'], 'presup');

                // Construimos la carta y adjuntamos el PDF
                $mail->ConstruirMailPresu($datosPresup['numero'], $utils->convertirFecha($datosPresup['fecha']), $userPDF['name']);

                // Procesamos la respuesta a la vista
                echo json_encode([
                    'success' => true,
                    'mensaje' => 'El PDF del Presupuesto "<strong>'
                        . $datosPresup['nombre'] .
                    '"</strong> se ha ENVIADO correctamente'
                ]);
                exit();

            }
        }
    }

    if (isset($_GET)) {
        // limpiar los dados en la variabla GET y validarla
        $datos_get = $filtro->Filtrar($_GET);
        // Validamos los datos de la peticion
        if (isset($datos_get['views']) &&!empty($datos_get['views'])) {
            // Mostrar la lista de presupuestos
            if ($datos_get['views'] == 'presup_form') {
                // Selecionamos los presupuestos de BD
                $datosPresupDB->tabla = 'app_presupuestos';
                $datosPresupuestos = $datosPresupDB->ConsultarDatosPresupUser();
            }
        }
    }
?>