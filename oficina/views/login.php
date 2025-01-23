<header class="container-fluid" style="height:150px;">
    <!-- div respuestas -->
    <div id="res">
        <?php
            if (isset($_GET['res']) && !empty($_GET['res'])) {
                echo $_GET['res'];
            }
        ?>
    </div>
</header>

<section class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Formuliario de Acceso</h5>
            <form class="form-control" method="post" action="<?php echo BASE_URL . '/oficina/index.php' ?>">
                <input class="form-control" type="email" name="user" placeholder="Nombre de usuario:" minlength="5" maxlength="150" required />
                <br>
                <input class="form-control" type="password" name="pass" placeholder="Contraseña" minlength="5" maxlength="30" required />
                <br>
                <input type="hidden" name="action" value="FORM_LOGIN" />
                <br>
                <input class="btn btn-primary" type="submit" value="LOGIN" />
                <input class="btn btn-danger" type="reset" value="RESET" />
            </form>
        </div>
    </div>
</section>

<!-- <script src="../assects/js/login.js"></script> -->
