<?php
    session_start();

    // Incluir las dependencias y cargar variables del entorno
    require_once(__DIR__ . '/../vendor/autoload.php');

    // Utilizamos la biblioteca phpDotenv
    use Dotenv\Dotenv;

    // Detectamos el entorno actual
    $envFile = getenv('APP_ENV') ?: 'desarrollo';

    // Validamos el entorno
    $validEnvs = ['desarrollo', 'produccion'];
    if (!in_array($envFile, $validEnvs)) {
        die("Entorno no válido: $envFile");
    }

    // Cargamos el archivo.env segun el entorno
    try {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../', ".env.$envFile");
        $dotenv->load();
    } catch (Exception $e) {
        die('Error cargando el archivo .env: ' . $e->getMessage());
    }

    // Difinimos la URL base de la app
    define('BASE_URL', $_ENV['BASE_URL']);

    // Difinimos las variables de acceso a la BD
    define('HOST', $_ENV['DB_HOST']);
    define('DB', $_ENV['DB_NAME']);
    define('USER', $_ENV['DB_USER']);
    define('PASS', $_ENV['DB_PASS']);
    define('PORT', $_ENV['DB_PORT']);

    require_once(__DIR__ . '/../views/header.php');
    require_once(__DIR__ . '/controller/controller.php');
    require_once(__DIR__ . '/controller/navi_controller.php');
    require_once(__DIR__ . '/controller/empresa_controller.php');

    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        // Entramos en la session privada
        require(__DIR__ . '/views/navi.php');
        require_once(__DIR__ . '/views/main.php');
    } elseif (isset($_GET['action']) && $_GET['action'] == 'registro') {
        // Mostrar la vista de registro
        require(__DIR__ . '/views/navi_reg.php');
        require_once(__DIR__ . '/views/register.php');
    } else {
        // Mostrar la vista de login
        require(__DIR__ . '/views/navi_log.php');
        require_once(__DIR__ . '/views/login.php');
    }

    require_once(__DIR__ . '/../views/footer.php');
?>