<section class="container-fluid">
    <?php

    ?>
    <!-- Zona superior -->
    <nav class="d-flex justify-content-between align-items-center p-3 bg-primary text-white border rounded">
        <!-- Zona izquierda de Logo y Menu -->
        <div class="d-flex align-items-center gap-3">
            <!-- Logo -->
            <img src="https://w7.pngwing.com/pngs/662/750/png-transparent-file-manager-computer-icons-file-explorer-android-android-blue-rectangle-electric-blue.png" alt="Logo" style="height: 50px;">
            <!-- Menu -->
            <nav class="d-flex gap-3">
                <a href="#" class="text-white">Productos</a>
                <a href="<?php echo BASE_URL . '/oficina/index.php'; ?>" class="text-white">Oficina</a>
            </nav>
        </div>
        <div>
            <?php
                echo $saludo->getSaludo();
            ?>
        </div>
    </nav>
</section>