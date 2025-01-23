<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <!-- IMAGEN -->
        <a class="navbar-brand" href="#">
            <img src="https://png.pngtree.com/png-clipart/20210801/original/pngtree-tree-logo-png-png-image_6595324.jpg" alt="logo" style="width: 100px;">
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent_log">
            <!-- MAYOR MENU -->
            <?php
                $objMenu = new Menu();
                echo $objMenu->menu;
            ?>
            <!-- REQUISITOS DEL USUARIO
            <div class="navbar-text me-3">
                <h2 class="card-title text-primary">Usuario:</h2>
                <p class="card-text">
                    <span class="fw-bold text-info"><?php echo $_SESSION['name']; ?></span>
                </p>
            </div>
             -->
            <!-- REQUISITOS DEL USUARIO y BOTON CERRAR LA SESSION -->
            <div class="d-flex align-items-center">
                <!-- REQUISITOS DEL USUARIO -->
                <div class="navbar-text me-3">
                    <?php
                        $saludo->getSaludo();
                    ?>
                </div>
                <!-- BOTON CERRAR LA SESSION -->
                <a class="btn btn-danger" href="<?php echo BASE_URL . '/oficina/index.php' ?>?accion=cerrar" style="margin-left:1rem;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
            <!-- BOTON CERRAR LA SESSION
            <form class="d-flex ms-auto" role="search">
                <a class="btn btn-danger" href="' . BASE_URL . '/oficina/index.php?accion=cerrar" style="margin-left:1rem;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </form>
             -->
        </div>
    </div>
</nav>