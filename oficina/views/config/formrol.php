​<?php
echo print_r($_SESSION);

?>
<section>
    <h3>Roles de Usuarios</h3>
    <?php
   
    //$permiso = $roles->VerificarPermiso('crear_usuario',$_SESSION['user']);
    //if($permiso == 1){
        if(isset($modal_add)) {
            print($modal_add->getBtn());
          }

    //}
    ?>
    <table class="table  table-hover table-striped" id="TablaRol">
        <thead>
            <th>Num</th>   
            <th>Nombre Rol</th>
            <th></th>
        </thead>
        <tbody>
            <?php
                $i=0;
             
                if(isset($roles->roles) and !empty($roles->roles)){
                    foreach($roles->roles as $rol){
                        
                        echo '<tr id="tr-rol-'.$rol['rowid'].'">';
                        echo '<td>'.$i.'</td>';
                        echo '<td><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#userRolModal" onclick="ConfigRol('.$rol['rowid'].','.$_SESSION['rol'].')" href="#">'.$rol['nombre'].'</a></td>';
                        echo '<td><a class="btn-danger" onclick="BorrarRol('.$rol['rowid'].')" href="#"><i class="fa-solid fa-trash"></i></a></td>';
                        echo '</tr>';
                        $i++;
                    }
                }
            ?>
        </tbody>
        <tfoot></tfoot> 
    </table>
</section>
<script src="http://mvc.test/assets/js/rol.js"></script>
<?php
      if(isset($modal_add)) {
        print($modal_add->getModal());
      }
?>