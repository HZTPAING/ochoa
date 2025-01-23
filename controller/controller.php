<?php
    // Carga config.php
    require_once(__DIR__ . '/../config.php');
    
    // Carga automáticamente todas las dependencias de Composer (incluyendo PHPMailer) utilizando el autoloader generado
    require_once(__DIR__ . '/../vendor/autoload.php');
    
    // Carga el model.php para trabajar con la base de datos
    require_once(__DIR__ . '/../oficina/model/model.php');
    
    // Carga la clase Saludo para el saludo personalizado
    use Saludo\Saludo\Saludo;

    $saludo = new Saludo(isset($_SESSION['name']) ? $_SESSION['name'] : 'INCOGNITO');

    if ($_GET) {
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
            // 

        }
    }

    /*
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
    */
    
?>