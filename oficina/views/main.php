<section class="container">
    <?php
        if (isset($_GET['views']) && !empty($_GET['views'])) {
            // USUARIOS
            if ($_GET['views'] == 'usuarios') {
                if (isset($_GET['action']) && !empty($_GET['action'])) {
                    // Añadir o editar el usuario
                    if ($_GET['action'] == 'add_user' || $_GET['action'] == 'edt_user') {
                        include (__DIR__ . '/usuarios/formulario.php');
                    }
                    // Borrar el usuario

                } else {
                    //require('views/usuarios/listado.php');
                    include (__DIR__ . '/usuarios/listado.php');
                }
            }
            // TAREAS
            if ($_GET['views'] == 'tareas_user') {
                if (isset($_GET['action']) && !empty($_GET['action'])) {
                    // Añadir o editar la tarea
                    if ($_GET['action'] == 'add_tarea_user' || $_GET['action'] == 'edt_tarea_user') {
                        include (__DIR__ . '/tareas/formulario.php');
                    }
                    // Borrar el usuario

                } else {
                    //require('views/usuarios/listado.php');
                    include (__DIR__ . '/tareas/listado.php');
                }
            }
            // HOME
            if ($_GET['views'] == 'home') {
                // Abrimos la ventana Home
                include (__DIR__ . '/home.php');
            }
            // CONFIG
            if ($_GET['views'] == 'config') {
                // Añadir o editar el usuario
                include (__DIR__ . '/config/config.php');
            }
            // PRESUPUESTOS
            if ($_GET['views'] == 'presup') {
                // Abrir la pagina principal del presupuestos
                include (__DIR__ . '/presupuesto/presupuestos.php');
            }
            // PRESUPUESTOS FORMULARIO
            if ($_GET['views'] == 'presup_form') {
                // Añadir o editar los presupuestos
                include (__DIR__ . '/presupuesto/formulario.php');
            }
        } else
            include (__DIR__ . '/home.php');
    ?>
</section>

<header class="container-fluid" style="height:150px;">
    <!-- div respuestas -->
    <div id="mensajeStatus" class="mt-3"></div>
    <div id="res">
        <?php
            if (isset($_GET['res']) && !empty($_GET['res'])) {
                echo urldecode($_GET['res']);
            }
        ?>
    </div>
</header>