<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent_reg">
            <form class="d-flex ms-auto" role="search">
                <a class="btn btn-primary" href="<?php echo BASE_URL . '/index.php' ?>" style="margin-left:1rem;">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>
                <a class="btn btn-primary" href="<?php echo BASE_URL . '/oficina/index.php' ?>?" style="margin-left:1rem;">
                    <i class="fa-solid fa-user-plus"></i> Logearce
                </a>
            </form>
        </div>
    </div>
    <div>
        <?php
            echo $saludo->getSaludo();
        ?>
    </div>
</nav>