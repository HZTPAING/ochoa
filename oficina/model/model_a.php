<?php
Class ConectorDB{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $port;
    public $con;
    public function __construct(){
            $this->host = HOST;
            $this->user = USER;
            $this->pass = PASS;
            $this->db = DB;
            $this->port = PORT;
            $this->ConectarBD();
    }
    public function ConsultarDB(String $sql){
        $this->ConectarBD();
        $datos = mysqli_query($this->con,$sql);
        $this->DesconectarBD();
        return $datos;
    }
    /*
    public function ConsultaSeguras($sql,$user){
        $this->ConectarBD();
        // Preparar la consulta
        $stmt = $this->con->prepare($sql);
        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $this->con->error);
        }

        // Vincular el parámetro a la consulta preparada
        $stmt->bind_param("s", $user);
        // Ejecutar la consulta
        $stmt->execute();

        // Almacenar el resultado
        $stmt->store_result();

        // Verificar si el usuario existe
        if ($stmt->num_rows > 0) {
            echo "El usuario existe con seguridad.";
        } else {
            echo "El usuario no existe con seguridad.";
        }
    }
    */
    private function ConectarBD(){
        $this->con = mysqli_connect($this->host,$this->user,$this->pass,$this->db,$this->port);

    }
    private function DesconectarBD(){
        $res = mysqli_close($this->con);
        return $res;
    }

    
}

class DatosDB extends ConectorDB
{
    public $tabla;
    public $tabla2;
    public function __construct($tabla,$tabla2='')
    {
        parent::__construct();
        $this->tabla = $tabla;
        $this->tabla2 = $tabla2;
    }
    public function RegistroSiguiente($idActual){
        $sql = "SELECT * FROM `{$this->tabla}` WHERE rowid < $idActual ORDER BY rowid DESC LIMIT 1;";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return $dbdatos;
        } else {
            return false;
        }
    }   

    public function RegistroActual($idActual){
        $sql = "SELECT * FROM `{$this->tabla}` WHERE rowid > $idActual ORDER BY rowid ASC LIMIT 1;";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return $dbdatos;
        } else {
            return false;
        }
    }

    public function CountBadges()
    {
        $sql = "SELECT * FROM `{$this->tabla}`";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        return $total;
    }
    
    public function FuturaId($key){
        // Consulta para obtener el máximo ID actual
        $sql = "SELECT MAX($key) AS max_id FROM `{$this->tabla}`";
        $dbdatos = $this->ConsultarDB($sql);
        $row = $dbdatos->fetch_assoc();

        $next_id = $row['max_id'] + 1; // La próxima ID posible
        return $next_id;        
    }

    public function ContarDatos()
    {
        $sql = "SELECT * FROM `{$this->tabla}`";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        return $total;
    }
    public function ConsultarDatosRowId($rowid)
    {
        $sql = "SELECT * FROM `{$this->tabla}` WHERE `rowid`=" . $rowid;
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return $dbdatos;
        } else {
            return false;
        }
    }
    public function ConsultarDatosDB()
    {
        // Devolución en MYSQL RESULT
        $sql = "SELECT * FROM `{$this->tabla}` ";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            
            return $dbdatos;
        } else {
            return false;
        }
    }
    public function ConsultarDatos()
    {
        // Devolución en Array de Datos
        $sql = "SELECT * FROM `{$this->tabla}` ";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            $i = 1;
            foreach ($dbdatos as $dbdato) {
                $ListaDatos[$i] = $dbdato;
                $i++;
            }
            return $ListaDatos;
        } else {
            return false;
        }
    }

    public function ConsultarDatosSQLDB($sql){
        // Devolución en Array de Datos
        //$sql = "SELECT * FROM `{$this->tabla}` ";
        $dbdatos = $this->ConsultarDB($sql);        
        return $dbdatos;
        
    }

    public function ConsultarDatosemail($email)
    {
        $sql = "SELECT * FROM `{$this->tabla}` WHERE `email` ='" . $email . "'";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return $dbdatos;
        } else {
            return false;
        }
    }  
    public function ConsultarDatosCampo($campo, $valor)
    {
        $sql = "SELECT * FROM `{$this->tabla}` WHERE `{$campo}` ='" . $valor . "'";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return $dbdatos;
        } else {
            return false;
        }
    } 

    public function ConsultarDatosCampoNull($campo)
    {
        $sql = "SELECT * FROM `{$this->tabla}` WHERE `{$campo}` IS NULL";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return $dbdatos;
        } else {
            return false;
        }
    } 
    
    public function GuardarDatosDB(array $datos, ?int $rowid = null, ?int $id = null)
    {
        if (empty($datos)) {
            return false;
        }
    
        $columns = [];
        $values = [];
        $sets = [];
    
        foreach ($datos as $key => $value) {
            $escapedValue = ($value === null || strtolower($value) === 'null') ? 'NULL' : "'" . addslashes($value) . "'";
            $columns[] = "`$key`";
            $values[] = $escapedValue;
            $sets[] = "`$key` = $escapedValue";
        }
    
        if ($id === null && $rowid === null) {
            $sql = "INSERT INTO `" . $this->tabla . "` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
        } elseif ($id !== null) {
            $sql = "UPDATE `" . $this->tabla . "` SET " . implode(", ", $sets) . " WHERE `id` = '" . addslashes($id) . "'";
        } elseif ($rowid !== null) {
            $sql = "UPDATE `" . $this->tabla . "` SET " . implode(", ", $sets) . " WHERE `rowid` = '" . addslashes($rowid) . "'";
        }
    
        return $this->ConsultarDB($sql) !== false;
    }
    public function GuardarDatosIntDB(array $data, Int $id = null)
    {
        $sql = "INSERT INTO `" . $this->tabla . "` (`id`,`idUsuario`,`idLocal`) value (null," . $data['idUsuario'] . "," . $data['idLocal'] . ")";
        if ($this->ConsultarDB($sql)) {
            return true;
        } else {
            return false;
        }
    }
    public function DeleteDatosId($key,$rowid)
    {
        $sql = "DELETE FROM `{$this->tabla}` WHERE `{$key}` = '" . $rowid."'";
        if ($this->ConsultarDB($sql)) {
            return true;
        } else {
            return false;
        }
    }
    public function ValidarDatosDB($datos)
    {
        $sql = "SELECT * FROM `{$this->tabla}`";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            foreach ($dbdatos as $dbdato) {
                if (
                    $datos['user'] == $dbdato['mail']
                    && MD5($datos['pass']) == $dbdato['pass'] && $dbdato['estado'] == 2
                ) {
                    return  true;
                } else {
                    return false;
                }
            }
        }
    }

    public function ConsultarDependientes($idCat) {
        $sql = "SELECT * FROM app_productos_categorias WHERE categoria_padre_id = ".$idCat;
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return $dbdatos;
        } else {
            return false;
        }
        
    }

    public function EliminarCategoria($idCate) {
        $sql = "DELETE FROM app_productos_categorias WHERE rowid = ".$idCate;
        $dbdatos = $this->ConsultarDB($sql);        
        if ($dbdatos) {
            return $dbdatos;
        } else {
            return false;
        }
    }

    public function VerificarUnico($campo, $valor){
        $sql = "SELECT * FROM `{$this->tabla}` WHERE `".$campo."`='".$valor."'";
        $dbdatos = $this->ConsultarDB($sql);
        $total = mysqli_num_rows($dbdatos);
        if ($total > 0) {
            return -1;
        } else {
            return 1;
        }

    }

    public function ActualizarFotoProdPortada($idProd, $foto){
        $sql = "UPDATE `" . $this->tabla . "` SET `fotos_producto`='".$foto."' WHERE `rowid` = '" . addslashes($idProd) . "'";
        $dbdatos = $this->ConsultarDB($sql);        
        if ($dbdatos) {
            return 1;
        } else {
            return -1;
        }
    }

    public function guardarAtributo($data) {
        $sql = "INSERT INTO `" . $this->tabla . "` (idprod,categoria, atributo, iva, incremento, decremento) 
                VALUES (".$data['idprod'].",'".$data['categoria']."', '".$data['atributo']."', ".$data['iva'].", ".$data['incremento'].", ".$data['decremento'].")";
        $dbdatos = $this->ConsultarDB($sql);
        if ($dbdatos) {
            return 1;
        } else {
            return -1;
        } 
        
    }

    public function ConsultarDatosExistentes($idprod, $idsup) {
        $query = "SELECT COUNT(*) AS count FROM `" . $this->tabla . "` WHERE idprod = ".$idprod." AND idsup = ".$idsup;
        $result = $this->ConsultarDB($query);        
         // Verificar si el resultado es válido y obtener el conteo
         foreach($result as $res);
         
        if (isset($res['count']) && $res['count'] > 0) {
            return true; // Existe
        } else {
            return false; // No existe
        }
    }


}