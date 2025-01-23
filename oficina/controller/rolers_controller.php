<?php
// Verificar si una sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Carga el controller.php para manejar las peticiones y redirecciones
require_once(__DIR__ . '/controller.php');
// Carga el model.php para trabajar con la base de datos
require_once(__DIR__ . '/../model/model.php');
// Carga el presupuestos.php para administrar las presupuestos
require_once(__DIR__ . '/../librerias/app.php');

$roles = new Rol;
$roldb = new RolDB;
$MenuDB = new MenuDB();
$filtro = new FiltrarDatos();

use Saludo\Saludo\Saludo;

/*
if (isset($_SESSION['name'])) {
    $saludo = new Saludo($_SESSION['name']);
}
*/

$header = '';
/// 1er cambio
$body = '';
$footer ='';

$modal_add = new Modal('userRolModal','Rol de Usuarios',$header,$body,$footer,'Nuevo Rol','idBtnModal');

if ($_GET) {
    // Verifica si hay una acción en el GET
    if (isset($_GET['views']) && $_GET['views'] == 'config' ) {
        if (isset($_GET['tab']) && $_GET['tab'] == '2' ) {
            if (isset($_GET['action']) && !empty($_GET['action']) ) {
                // action = CAMBIAR_ROL
                if($_GET['action']== 'CAMBIAR_ROL'){
                    $datos['rowid'] = htmlspecialchars(trim($_GET['rowid']));
                    $datos['key'] = htmlspecialchars(trim($_GET['key']));
                    $vact = $roldb->ConsultarValorActual($datos['rowid'], $datos['key']); // que valor tiene en la BD

                    if ($vact == 1) {
                        $datos['valor'] = 0;
                    } else {
                        $datos['valor'] = 1;
                    }
                    $res = $roldb->UpdateDatosRol($datos);

                    try {

                        if ($res == 1) {
                            $resp['msn'] = '<div class="alert alert-success" >Permiso actualizado correctamente</div>';
                            $resp['valor'] = $datos['valor'];
                            echo json_encode($resp);
                        } else {
                            $resp['msn'] = '<div class="alert alert-danger" >Permiso no actualizado correctamente</div>';
                            $resp['valor'] = -1;
                            echo json_encode($resp);
                        }
                    } catch (Exception $e) {
                        $resp['msn'] = '<div class="alert alert-danger" >' . $e . '</div>';
                        $resp['valor'] = -1;
                        echo json_encode($resp);
                    }
                }
                // action = DELETE_ROL
                if ($_GET['action'] == 'DELETE_ROL') {
                    $rowid = htmlspecialchars($_GET['rowid']);
                    $res = $roldb->DeleteRol($rowid);
                    if ($res == 1) {
                        $resp['msn'] = '<div class="alert alert-success" >Permiso borrado correctamente</div>';
                        $resp['exito'] = 1;
                        $resp['valor'] = $rowid;
                        echo json_encode($resp);
                    } else {
                        $resp['msn'] = '<div class="alert alert-danger" >El Permiso no ha sido borrado</div>';
                        $resp['exito'] = -1;
                        $resp['valor'] = $rowid;
                        echo json_encode($resp);
                    }
                }
                // action = FORM_ADD_ROL
                if ($_GET['action'] == 'FORM_ADD_ROL') {
                    $res = $roles->PintarModalRolAdd($roles->roles);
                    echo json_encode([
                        'valor' => '',
                        'datos' => $res
                    ]);
                    exit();
                }
                // action = CONFIG_ROL
                if ($_GET['action'] == 'CONFIG_ROL') {
                    foreach ($roles->roles as $rol) {
                        if ($rol['rowid'] == $_GET['rowid']) {
                            foreach ($rol as $key => $value) {
                                $valor[$key] = $value;
                            }
                        }
                    }
                    $res = $roles->PintarModalRolEdit($valor);
                    echo json_encode([
                        'datos' => $res
                    ]);
                }
            }
        }
    }
}

if ($_POST) {
    // Verifica si hay una acción en el GET
    if (isset($_POST['action']) && !empty($_POST['action']) ) {
        // action = FORM_ADD_ROL
        if($_POST['action'] == 'FORM_ADD_ROL'){
            $res = $roldb->GuardarRol($_POST);
            if($res==1){
                $resp['msn'] = "Rol guardado correctamete";
                $resp['valor'] = 1;
                echo json_encode($resp);
            }
            else
            {
                $resp['msn'] = "El rol no ha sido guardado";
                $resp['valor'] = 0;
                echo json_encode($resp);
            }    
        }
    }
    // action = CONFIG_ROL
    if ($_POST['action'] == 'CONFIG_ROL') {
        foreach ($roles->roles as $rol) {
            if ($rol['rowid'] == $_POST['rowid']) {
                foreach ($rol as $key => $value) {
                    $valor[$key] = $value;
                }
            }
        }

        // Genera el HTML del modal usando PintarModalRolEdit y almacénalo en $res
        $res = $roles->PintarModalRolEdit($valor);

        // Devuelve el HTML generado y los valores de la consulta en formato JSON
        echo json_encode([
            'valor' => $valor,
            'datos' => $res
        ]);
        exit();
    }

}

?>