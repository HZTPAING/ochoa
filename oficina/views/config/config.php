<?php
// App Tareas v1.0
// create by Profe Productions
?>
<h2>Configuración de la aplicación</h2>
<ul class="nav nav-tabs" role="tablist">

    <?php

    if ($_GET) {
        if ($_GET['views'] == 'config') {
            if (isset($_GET['tab'])) {
    ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php if ($_GET['tab'] == 1) {
                                            echo "active";
                                        } else {
                                        } ?>" id="simple-tab-0" href="/oficina/index.php?views=config&tab=1" role="tab" aria-controls="simple-tabpanel-0" aria-selected="<?php if ($_GET['tab'] == 1) {
                                                                                                                                                                    echo "true";
                                                                                                                                                                } else {
                                                                                                                                                                    echo 'false';
                                                                                                                                                                } ?>">MENUS</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php if ($_GET['tab'] == 2) {
                                            echo "active";
                                        } else {
                                        } ?>" id="simple-tab-1" href="/oficina/index.php?views=config&tab=2" role="tab" aria-controls="simple-tabpanel-1" aria-selected="<?php if ($_GET['tab'] == 2) {
                                                                                                                                                                    echo "true";
                                                                                                                                                                } else {
                                                                                                                                                                    echo 'false';
                                                                                                                                                                } ?>">ROLES DE USUARIO</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php if ($_GET['tab'] == 3) {
                                            echo "active";
                                        } else {
                                        } ?>" id="simple-tab-2" href="/oficina/index.php?views=config&tab=3" role="tab" aria-controls="simple-tabpanel-2" aria-selected="<?php if ($_GET['tab'] == 3) {
                                                                                                                                                                    echo "true";
                                                                                                                                                                } else {
                                                                                                                                                                    echo 'false';
                                                                                                                                                                } ?>">EMPRESA</a>
                </li>
    <?php
            } else {
                echo '<script>location.href = "/oficina/index.php?views=config&tab=1"</script>';
            }
        }
    }

    ?>
</ul>
<div class="tab-content pt-5" id="tab-content">
    <div class="tab-pane <?php if ($_GET['tab'] == 1) {
                                echo "active";
                            } else {
                            } ?>" id="simple-tabpanel-0" role="tabpanel" aria-labelledby="simple-tab-0">
        <?php
        if ($_GET['tab'] == 1) {
            include('/oficina/views/config/formulario.php');
        }
        ?>
    </div>
    <div class="tab-pane <?php if ($_GET['tab'] == 2) {
                                echo "active";
                            } else {
                            } ?>" id="simple-tabpanel-1" role="tabpanel" aria-labelledby="simple-tab-1">
        <?php
        if ($_GET['tab'] == 2) {
            // ROLES DEL USUARIO
            include('/oficina/views/config/formrol.php');
        }
        ?>
    </div>
    <div class="tab-pane 
        <?php
        if ($_GET['tab'] == 3) {
            echo "active";
        } else {
        }
        ?>"
        id="simple-tabpanel-2" role="tabpanel" aria-labelledby="simple-tab-2">
        <?php
        if ($_GET['tab'] == 3) {
            // SECCION EMPRESA
            include('/oficina/views/config/formemp.php');
        }
        ?>

    </div>
</div>