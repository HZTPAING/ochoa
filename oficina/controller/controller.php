<?php
    // Carga config.php
    require_once(__DIR__ . '/../../config.php');
    // Carga automáticamente todas las dependencias de Composer (incluyendo PHPMailer) utilizando el autoloader generado
    require_once(__DIR__ . '/../../vendor/autoload.php');
    // Carga el model.php para trabajar con la base de datos
    require_once(__DIR__ . '/../model/model.php');
    // Carga el mail.php para enviar emails
    require_once(__DIR__ . '/../controller/mail.php');
    // Carga el usuarios.php para administrar los usuarios
    require_once(__DIR__ . '/../controller/usuarios.php');
    // Carga el tareas.php para administrar las tareas
    require_once(__DIR__ . '/../controller/tareas.php');
    // Carga el presupuestos.php para administrar las presupuestos
    require_once(__DIR__ . '/../controller/presupuestos.php');
    // Carga el presupuestos.php para administrar las presupuestos
    require_once(__DIR__ . '/../controller/rolers_controller.php');
    // Carga el presupuestos.php para administrar las presupuestos
    require_once(__DIR__ . '/../librerias/app.php');

    $roldb = new RolDB;

    // Carga la clase Saludo para el saludo personalizado
    use Saludo\Saludo\Saludo;

    $saludo = new Saludo(isset($_SESSION['name']) ? $_SESSION['name'] : 'INCOGNITO');

    if ($_GET) {
        if (isset($_GET['reg']) and !empty($_GET['reg'])) {
            // Registrar un usuario
            $res = $_GET['reg'];
            // REG_APP_MAIL
            if (base64_decode($res) == 'REG_APP_MAIL') {
                if (isset($_GET['id']) and!empty($_GET['id'])) {
                    $id = $_GET['id'];
                    //$email
                    // Desencodificar el id y verificar si el usuario existe
                    $user = htmlspecialchars_decode(base64_decode($id));
                    
                    // Verificar si el usuario existe
                    $UsersClass = new Usuarios();
                    $UsersClass->VerificarUsuario($user);
                    if ($UsersClass->validar == true) {
                        // Lanzar en pantalla que el usuario se puede logear
                        $res = '<div class="alert alert-success">La cuenta <strong>'.$user.'</strong> ya esta registrada correctamente.<br>Ya la puede iniciar logearse</div>';
                        header('location:' . BASE_URL . '/oficina/index.php?res=' . urlencode($res));
                    } else {
                        $res = '<div class="alert alert-danger">La cuenta '.$user.' no acaba de registrar correctamente</div>';
                        header('location:' . BASE_URL . '/oficina/index.php?res='. urlencode($res));
                    }
                }
            }
        }
        // CERRAR
        if (isset($_GET['action']) &&!empty($_GET['action'])) {
            if ($_GET['action'] == 'cerrar') {
                // Cerrar la sesión
                //session_start();
                unset($_SESSION);
                session_destroy();
            }
        }
    }

    if ($_POST) {
        if (isset($_POST['action']) and !empty($_POST['action'])) {
            echo '<pre>';
                print_r($datos);
            echo '</pre>';
            // FORM_REG_LOGIN
            if (htmlspecialchars($_POST['action']) == 'FORM_REG_LOGIN') {
                $db = new UsuariosDB();
                $res_sql = $db->GuardarUsuarioDB($_POST);

                if ($res_sql) {
                    // Enviar email
                    $mail = new Mail(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['user']));
                    if ($mail) {
                        $res = '<div class="alert alert-success">El usuario <strong>'.$_POST['email'].'</strong> ya ha pasado la primera parte de la registración<br>Revisa el correo y finaliza la registración pulsando en enlace dentro del correo que has recibodo</div>';
                    } else {
                        $res = '<div class="alert alert-danger">Error de enviar el correo</div>';
                    }
                } else {
                    $res = '<div classs="alert alert-danger">Error NO almacenado correctamente</div>';
                }
                header('location:' . BASE_URL . '/oficina/index.php?res=' . urlencode($res));
            }
            // FORM_LOGIN
            if ($_POST['action'] == 'FORM_LOGIN') {
                // Logear un usuario
                $datos['email'] = trim(htmlspecialchars_decode($_POST['user']));
                $datos['pass'] = trim(htmlspecialchars_decode($_POST['pass']));
                echo '<pre>';
                    print_r($datos);
                echo '</pre>';
                // buscamos datos en la BD
                $db = new UsuariosDB();
                $datos_bd = $db->BuscarUsuarioDB($datos);
                $userExiste = 0;
                foreach($datos_bd as $datos_user) {
                    // Verificar si el usuario y la contraseña se compare con uno de los usuarios existentes
                    if ($datos_user['email'] == $datos['email'] && $datos_user['pass'] == MD5($datos['pass'])) {
                        $userExiste = 1;
                        session_start();
                        $_SESSION['email'] = $datos_user['email'];
                        $_SESSION['name'] = $datos_user['name'];
                        $_SESSION['rowid'] = $datos_user['rowid'];

                        $rol = $roldb->ConsultarRolDB($datos_user['rowid']);
                        $_SESSION['rol'] = $rol['idrol'];
                        $_SESSION['rol_nombre'] = $rol['nombre'];
                    }
                }
                // Verificamos el resultado de comparacion de useario y contraseña
                if ($userExiste == 1) {
                    // Lanzar en pantalla que el usuario se puede logear
                    $res = '<div class="alert alert-success">El usuario <strong>'.$_SESSION['email'].'</strong> ya ha logeado con exito</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?res=' . urlencode($res));
                } else {   
                    $res = '<div class="alert alert-danger">El usuario <strong>'.$datos['email'].'</strong> NO ha logeado con exito<br>La contraeña o el correo no es correto</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?res=' . urlencode($res));
                }
            }
        }
    }

    class FiltrarDatos {
        public function Filtrar($datos) {
            // Sanitizamos los datos y evitamos algunos problemas de seguridad como Cross-Site Scripting (XSS)

            $passwordKeys = ['pass', 'contraseña']; // Array con nombres de claves que podrían contener contraseñas
    
            if (is_array($datos)) {
                foreach ($datos as $key => $value) {
                    if (in_array($key, $passwordKeys)) {
                        // No aplicamos htmlspecialchars ni otras limpiezas a las contraseñas
                        $datos[$key] = $this->ProcesarContrasena($value);
                    } else {
                        $datos[$key] = $this->LimpiarDatos($value);
                    }
                }
            } else {
                $datos = $this->LimpiarDatos($datos);
            }
            return $datos;
        }
    
        private function LimpiarDatos($datos) {
            // Verificar si $datos es un array
            if (is_array($datos)) {
                // Aplicar la función recursivamente a cada elemento del array
                $datos = array_map([$this, 'LimpiarDatos'], $datos);
            } elseif (is_string($datos)) {
                // Si $datos es una cadena, aplicar las funciones de limpieza
                $datos = trim($datos); // Eliminar espacios en blanco al inicio y final
                $datos = stripslashes($datos); // Eliminar barras invertidas
                $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8'); // Convertir caracteres especiales
            }
            return $datos;
        }
    
        private function ProcesarContrasena($pass) {
            // Almacenar las contraseñas usando password_hash() en lugar de MD5
            return password_hash($pass, PASSWORD_DEFAULT);
        }
    }
    
    class AppIdioma {
        public $charsets = [
            'latin1-spanish',
            'utf8',
            'iso-639'
        ];

        public $idiomas;

        function __construct() {
            $this->idiomas = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        }

        function setAppIdioma() {
            $idiomas = $this->idiomas;
            if ($idiomas[0] == 'es' or $idiomas[0] == 'es-ES') {
                $lang = 'es';
                $charset = $this->charsets[0];
            }
            if ($idiomas[0] == 'en' or $idiomas[0] == 'en-EN') {
                $lang = 'en';
                $charset = $this->charsets[1];
            }
            if ($idiomas[0] == 'uk' or $idiomas[0] == 'uk-UA') {
                $lang = 'uk';
                $charset = $this->charsets[2];
            }
            if ($idiomas[0] == 'ca' or $idiomas[0] == 'ca-ES') {
                $lang = 'ca';
                $charset = $this->charsets[1];
            }
            $res = [
                'lang' => $lang,
                'charset' => $charset
            ];
            return $res;
        }
    }
?>