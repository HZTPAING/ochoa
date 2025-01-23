<?php
    require_once(__DIR__ . '/../model/model.php');
    $datosDB = new UsuariosDB();
    $RolDB = new RolDB();
   
    if (isset($_GET)) {
        // session
        if (isset($_GET['views']) && !empty($_GET['views'])) {
            // views = usuarios
            if ($_GET['views'] == 'usuarios') {
                $datosUsers = $datosDB->ListaUsuarioDB();
                if (isset($_GET['action']) && !empty($_GET['action'])) {
                    // edt_user
                    if ($_GET['action'] == 'edt_user') {
                        $rowid = base64_decode(trim(htmlspecialchars($_GET['id'])));
                        $datosUser = $datosDB->BuscarUsuarioDB_id($rowid);

                        $datosrol = $RolDB->CargarRoles();
                        $relRol = $RolDB->RelacionUserRol($rowid);
                    }
                    // del_user
                    if ($_GET['action'] == 'del_user') {
                        $rowid = base64_decode(trim(htmlspecialchars($_GET['id'])));
                        $res = $datosDB->BorrarUsuarioDB_id($rowid);
                        if ($res == 1) {
                            $mensage = '<div class="alert alert-success">El usuario <strong>'.$_POST['email'].'</strong> borrado correctamente</div>';
                            header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($mensage));
                        } else {
                            $mensage = '<div class="alert alert-danger">Error al borrar el usuario en la BD</div>';
                            header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($mensage));
                        }
                    }
                }
            }
        }
    }

    if ($_POST) {
        if (isset($_POST['action']) && !empty($_POST['action'])) {
            // action = FORM_REG_USER
            if ($_POST['action'] == 'FORM_REG_USER') {
                echo print_r($_POST);
                $datos['user'] = htmlspecialchars($_POST['name']);
                $datos['email'] = htmlspecialchars($_POST['email']);
                $datos['pass'] = htmlspecialchars($_POST['pass']);
                $datos['status'] = htmlspecialchars($_POST['status']);
                $res = $datosDB->GuardarUsuarioDB($datos);
                if ($res == 1) {
                    $mensage = '<div class="alert alert-success">El usuario <strong>'.$_POST['email'].'</strong> guardado correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al guardar el usuario en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($mensage));
                }
            }
            // action = CAMBIAR_STATUS_USER [devolver el resultado a una llamada AJAX]
            if ($_POST['action'] == 'CAMBIAR_STATUS_USER') {
                $res = $datosDB->CambiarEstadoDB($_POST['id']);
                echo $res;
            }
            // action = FORM_UPD_USER
            if ($_POST['action'] == 'FORM_UPD_USER') {
                $datos['rowid'] = htmlspecialchars($_POST['rowid']);
                $datos['user'] = htmlspecialchars($_POST['name']);
                $datos['email'] = htmlspecialchars($_POST['email']);
                $datos['pass'] = htmlspecialchars($_POST['pass']);
                $datos['status'] = htmlspecialchars($_POST['status']);
                $res = $datosDB->UpdateUsuarioDB($datos);
                if ($res == 1) {
                    $mensage = '<div class="alert alert-success">El usuario <strong>'.$_POST['email'].'</strong> actualizado correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al actualizar el usuario en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($mensage));
                }
            }
            // action = FORM_UPDATE_ROL_USER [Asignar el role a un usuario]
            if ($_POST['action'] == 'FORM_UPDATE_ROL_USER') {
                if (isset($_POST['rowid'])) {
                    $datos['rowid'] = $_POST['rowid'];
                } else {
                    $datos['rowid'] = '';
                }
                $datos['iduser'] = $_POST['iduser'];
                $datos['idrol'] = $_POST['idrol'];
                $res = $RolDB->GuardarRolDB($datos);
                if ($res == 1) {
                    $msn = '<div class="alert alert-success">Rol Usuario Actualizado Correctamente</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($msn));
                } else {
                    $msn = '<div class="alert alert-success">Error al actualizar el Rol de Usuario en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=usuarios&&res=' . urlencode($msn));
                }
            }

        }
    }

    class Usuarios {
        public $user;
        public $validar;

        public function GetUser() {

            return $this->user;
        }

        public function SetUser($user) {

            $this->user = $user;
        }

        public function VerificarUsuario($user) {
            $UserDB = new UsuariosDB();
            $this->validar = false;
            $res = $UserDB->CambiarEstadoUsuariosDB($user);
            if ($res) {
                $this->validar = true;
            }
            // Implementar la conexión a la base de datos y la inserción del usuario
        }
    }
?>