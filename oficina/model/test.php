<?php
if($_POST['action'] == 'ADD_PRODUCTO'){
    Foreach($_POST as $key=>$valor){
        if(!($key == 'action') && !($key == 'rowid')){
            $datos[$key] = $valor;
        }
    }

    $res = $ProductosDB->GuardarDatosDB($datos);
    if($res == 1){
        $msn = '<div class="alert alert-success">Datos actualizados correctamente</div>';
        header('location:index.php?views=producto&res='.$msn);
    }
    else
    {
        $msn = '<div class="alert alert-danger">No se han podido actualizar los datos correctamente</div>';
        header('location:index.php?views=producto&res='.$msn);
    }
}
