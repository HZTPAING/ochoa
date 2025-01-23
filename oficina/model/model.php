<?php
    Class ConectorBD{
        private $host;
        private $user;
        private $pass;
        private $db;
        private $port;
        public $con;

        public function __construct() {
            $this->host = HOST;
            $this->user = USER;
            $this->pass = PASS;
            $this->db = DB;
            $this->port = "3306";
            $this->ConectarBD();
        }

        public function ExecSQL($sql) {
            $this->ConectarBD();
            $datos = mysqli_query($this->con, $sql);
            $this->DesconectarBD();
            return $datos;
        }

        public function ConsultaSeguras($sql, $user) {
            $this->ConectarBD();
            // Preparar la consulta
            $stmt = $this->con->prepare($sql);
            // Verificar si la preparación de la consulta fue exitosa
            if ($stmt === false) {
                die("Error en la preparación de la consulta: ".$this->con->error);
            }
            // Vincular parámetros y valores
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

        private function ConectarBD() {
            $this->con = mysqli_connect($this->host,$this->user,$this->pass,$this->db,$this->port);
        }

        private function DesconectarBD() {
            $res = mysqli_close($this->con);
            return $res;
        }
    }

    class DatosDB extends ConectorBD
    {
        public $tabla;

        public function __construct($tabla)
        {
            parent::__construct();
            $this->tabla = $tabla;
        }

        // Contar datos de SQL Result
        public function CountBadges()
        {
            $sql = "SELECT * FROM `{$this->tabla}`";
            $dbdatos = $this->ExecSQL($sql);
            $total = mysqli_num_rows($dbdatos);
            return $total;
        }

        // Consultar datos de SQL Result
        public function ConsultarDatosDB()
        {
            $sql = "SELECT * FROM `{$this->tabla}` ";

            $dbdatos = $this->ExecSQL($sql);
            $total = mysqli_num_rows($dbdatos);
            if ($total > 0) {
                  return $dbdatos;
            } else {
                return false;
            }
        }

        // Consultar datos de Array Result
        public function ConsultarDatos()
        {
            $sql = "SELECT * FROM `{$this->tabla}` ";
            $dbdatos = $this->ExecSQL($sql);

            // Inicializamos el array de respuesta
            $datosRes = [];

            // Si hay datos, los procesamos en el array
            if ($dbdatos) {
                foreach ($dbdatos as $dato) {
                    $datosRes[] = $dato;  // Llenamos el array correctamente
                }
            }
            return $datosRes;
        }

        // Consultar datos de SQL Result por un campo
        public function ConsultarDatosCampo($campo, $valor)
        {
            $sql = "SELECT * FROM `{$this->tabla}` WHERE `{$campo}` ='" . $valor . "'";

            $dbdatos = $this->ExecSQL($sql);
            $total = mysqli_num_rows($dbdatos);

            // Inicializamos el array de respuesta
            $datosCmpoRes = [];
            
            if ($dbdatos) {
                foreach ($dbdatos as $dato) {
                    $datosCmpoRes[] = $dato;  // Llenamos el array correctamente
                }
            }

            return $datosCmpoRes;
        }   

        public function ConsultarDatosPresup($numero) {
            $sql = "SELECT * FROM app_presupuestos WHERE numero = '" . $numero . "'";
            $datos = $this->ExecSQL($sql);
            
            // Inicializamos el array de respuesta
            $datosPresupRes = [];

            // Si hay datos, los procesamos en el array
            if ($datos) {
                foreach ($datos as $dato) {
                    $datosPresupRes[] = $dato;  // Llenamos el array correctamente
                }
            }
            return $datosPresupRes;
        }

        public function ConsultarDatosPresupDet($rowId) {
            $sql = "SELECT * FROM app_presupuesto_detalles WHERE rowid = " . $rowId;
            $datos = $this->ExecSQL($sql);

            // Inicializamos el array de respuesta
            $datosPresupDetRes = [];

            // Si hay datos, los procesamos en el array
            if ($datos) {
                foreach ($datos as $dato) {
                    $datosPresupDetRes[] = $dato;  // Llenamos el array correctamente
                }
            }
            return $datosPresupDetRes;
        }

        // Consultar datos de la lista de los Presupuestos de Array Result
        public function ConsultarDatosPresupUser()
        {
            $sql = "SELECT 
                a.rowid, numero, nombre, fecha, fecha_entrega, empleado, idUser, b.name AS user 
                FROM app_presupuestos a, app_users b WHERE a.idUser = b.rowid";
            $dbdatos = $this->ExecSQL($sql);

            // Inicializamos el array de respuesta
            $datosRes = [];

            // Si hay datos, los procesamos en el array
            if ($dbdatos) {
                foreach ($dbdatos as $dato) {
                    $datosRes[] = $dato;  // Llenamos el array correctamente
                }
            }
            return $datosRes;
        }
    
        public function GuardarDatosDB(array $datos, $id = null)
        {
            if (empty($datos)) {
                return false;
            }
    
            $columns = "";
            $values = "";
            $sets = "";
            $i = 0;
            $count = count($datos);

            foreach ($datos as $key => $value) {
    
                if ($i < $count - 1) {
                    $columns .= "`$key`, ";
                    $values .= "'$value', ";
                    $sets .= "`$key` = '" . addslashes($value) . "', ";
                } else {
                    $columns .= "`$key`";
                    $values .= "'$value'";
                    $sets .= "`$key` = '" . addslashes($value) . "'";
                }
    
                $i++;
            }

            if ($id === null) {
                $sql = "INSERT INTO `" . $this->tabla . "` ($columns) VALUES ($values)";
            } else {
                $sql = "UPDATE `" . $this->tabla . "` SET $sets WHERE `id` = '" . addslashes($id) . "'";
            }

            return $this->ExecSQL($sql);
        }

        public function GuardarDatosIntDB(array $data, Int $id = null)
        {
            echo $sql = "INSERT INTO `" . $this->tabla . "` (`id`,`idUsuario`,`idLocal`) value (null," . $data['idUsuario'] . "," . $data['idLocal'] . ")";
            if ($this->ExecSQL($sql)) {
                return true;
            } else {
                return false;
            }
        }
    
        public function DeleteDatosId($rowid)
        {
            $sql = "DELETE FROM `{$this->tabla}` WHERE rowid = " . $rowid;

            if ($this->ExecSQL($sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    class UsuariosDB extends ConectorBD {
        public function CambiarEstadoUsuariosDB($user) {
            // Prevenir el SQL Inject
            $user = trim($user); // Eliminar espacios en blanco innecesarios
            $user = htmlspecialchars($user, ENT_QUOTES, 'UTF-8'); // Convertir caracteres especiales en entidades HTML

            // Consultar si el usuario existe sin seguridad
            $sql = "SELECT `rowid` FROM `app_users` WHERE `name` = '".$user."'";
            $datos = $this->ExecSQL($sql);
            if (mysqli_num_rows($datos) == 0) {
                return false;
            }
            // El usuario existe sin seguridad
            foreach ($datos as $dato);
            $sql = "UPDATE `app_users` SET `status` = '2' WHERE `rowid` = ".$dato['rowid'];
            $res = $this->ExecSQL($sql);
            if ($res != 1) {
                return false;
            }
            return true;
        }

        public function CambiarEstadoDB($id) {
            // Consultar el valor de estatus del usuario
            $sql = "SELECT `status` FROM `app_users` WHERE `rowid` = '".$id."'";
            $datos = $this->ExecSQL($sql);
            // Pasamos el resultado a un array
            foreach ($datos as $dato);
            // Si el estatus actual es 1, cambiamos a 2, y viceversa
            if ($dato['status'] == 2) {
                $sql = "UPDATE `app_users` SET `status` = '1' WHERE `rowid` = ".$id;
            } else {
                $sql = "UPDATE `app_users` SET `status` = '2' WHERE `rowid` = ".$id;
            }
            $res = $this->ExecSQL($sql);
            if ($res != 1) {
                return false;
            }
            return true;
        }

        public function GuardarUsuarioDB($datos) {
            if (isset($datos['status'])) {
                $status = $datos['status'];
            } else {
                $status = 1;
            }

            $sql = "INSERT INTO `app_users` 
            (`name`, `pass`, `email`, `status`)
            VALUES 
            ('". $datos['user']. "', '". MD5($datos['pass']). "', '". $datos['email']. "', ". $status .")
            ";

            $res_sql = $this->ExecSQL($sql);
            return $res_sql;
        }

        public function BuscarUsuarioDB() {
            $sql = "SELECT rowid, name, pass, email, status FROM `app_users` WHERE `status` = 2";
            $datos = $this->ExecSQL($sql);
            if (mysqli_num_rows($datos) == 0) {
                return false;
            }
            // El usuario existe sin seguridad
            $i = 0;
            foreach ($datos as $dato) {
                $datosUsers[$i] = $dato;
                $i = $i + 1;
            }
            return $datosUsers;
        }

        public function BuscarUsuarioDB_id($rowid) {
            $sql = "SELECT rowid, name, pass, email, status FROM `app_users` WHERE `rowid` = " .$rowid;
            try {
                $datos = $this->ExecSQL($sql);
                if (mysqli_num_rows($datos) == 0) {
                    return false;
                }
                // El usuario existe sin seguridad
                $i = 0;
                foreach ($datos as $dato);
                return $dato;
            } catch (Exception $e) {
                return $e;
            }

        }

        public function ListaUsuarioDB() {
            $sql = "SELECT rowid, name, pass, email, status FROM `app_users`";
            $datos = $this->ExecSQL($sql);
            if (mysqli_num_rows($datos) == 0) {
                return false;
            }
            // El usuario existe sin seguridad
            $i = 0;
            foreach ($datos as $dato) {
                $datosUsers[$i] = $dato;
                $i = $i + 1;
            }
            return $datosUsers;
        }

        public function UpdateUsuarioDB ($datos) {
            $sql = "UPDATE app_users SET 
                name = '". $datos['user']. "',
                email = '". $datos['email']. "',
                status = ". $datos['status']. "
                ";
            if (isset($datos['pass']) && !empty($datos['pass'])) {
                $sql.= ", pass = '". MD5($datos['pass']). "'";
            }
            $sql.= " WHERE rowid = ". $datos['rowid'];
            $res = $this->ExecSQL($sql);
            return $res;
        }

        public function BorrarUsuarioDB_id ($rowid) {
            $sql = "DELETE FROM app_users WHERE rowid = ". $rowid;
            $res = $this->ExecSQL($sql);
            return $res;
        }
    }

    class TareasDB extends ConectorBD {
        public function InstallTareas() {
            $sql = "CREATE TABLE IF NOT EXISTS app_tareas (
                    rowid INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    idUser INT NOT NULL,
                    nombre VARCHAR(75),
                    descripcion VARCHAR(245),
                    horaProgramada DATETIME,
                    inicio DATE,
                    final DATE,
                    estadoID INT,
                    estado ENUM('activa', 'pendiente', 'finalizada', 'en curso', 'cancelada', 'fallada')
                );
                ALTER TABLE app_tareas 
                ADD CONSTRAINT appUsers_appTareas
                FOREIGN KEY (idUser) REFERENCES app_users(rowid)
                ON UPDATE CASCADE ON DELETE CASCADE;
                ";
            $res = $this->ExecSQL($sql);
            return $res;

        }

        public function GuardarTareaDB($datos) {
            $sql = "INSERT INTO `app_tareas`
                (`idUser`, `nombre`, `descripcion`, `horaProgramada`,
                `inicio`, `final`,  `estadoID`, `estado`)
                VALUES
                (
                " . $datos['idUser'] . ",
                '" . $datos['nombre'] . "',
                '" . $datos['descripcion'] . "',
                '" . $datos['horaProgram'] . "',
                '" . $datos['fechaInicio'] . "',
                '" . $datos['fechaFinal'] . "',
                0,
                '" . $datos['estado'] . "'
                )";
            $res_sql = $this->ExecSQL($sql);
            return $res_sql;
        }

        public function ListaTareasDB_usuario($idUser) {
            $sql = "SELECT 
                a.`rowid`,
                `idUser`,
                b.name AS name_user,
                `nombre`,
                `descripcion`,
                `horaProgramada`,
                `inicio`,
                `final`,
                `estadoID`,
                `estado`
	        FROM `app_tareas` a
                JOIN app_users b ON b.rowid = a.idUser
                WHERE idUser = " . $idUser . " 
            ORDER BY a.rowid";
            $datos = $this->ExecSQL($sql);
            if (mysqli_num_rows($datos) == 0) {
                return [];
            }
            // Las tareas del usuario existen
            $datosTareas_user = []; // Inicializar la variable
            foreach ($datos as $dato) {
                $datosTareas_user[] = $dato;
            }
            return $datosTareas_user;
        }

        public function BuscarTareaDB_id($idTarea) {
            $sql = "SELECT
                `rowid`,
                `idUser`,
                `nombre`,
                `descripcion`,
                `horaProgramada`,
                `inicio`,
                `final`,
                `estadoID`,
                `estado`
            FROM `app_tareas`
                WHERE rowid = " . $idTarea;
            try {
                $datos = $this->ExecSQL($sql);
                if (mysqli_num_rows($datos) == 0) {
                    return [];
                }
                // La tarea existe
                foreach ($datos as $dato);
                return $dato;
            } catch (\Exception $e) {
                return $e;
            }
        }

        public function UpdateTareaDB($datos) {
            $sql = "UPDATE app_tareas SET
                nombre = '". $datos['nombre']. "',
                descripcion = '". $datos['descripcion']. "',
                horaProgramada = '". $datos['horaProgram']. "',
                inicio = '". $datos['fechaInicio']. "',
                final = '". $datos['fechaFinal']. "',
                estadoID = ". $datos['estadoID']. ",
                estado = '". $datos['estado']. "'
                WHERE rowid = ". $datos['rowid'];
            $res = $this->ExecSQL($sql);
            return $res;
        }

        public function BorrarTareaDB_id($idTarea) {
            $sql = "DELETE FROM app_tareas WHERE rowid = ". $idTarea;
            $res = $this->ExecSQL($sql);
            return $res;
        }
    }

    class MenuDB extends ConectorBD {

        public function SelectItems_all() {
            $sql = "SELECT
                a.rowid,
                a.name,
                icon,
                is_target,
                a.href,
                (SELECT DISTINCT
                    item_id FROM app_sub_items b
                    WHERE b.item_id = a.rowid) AS subitem_id
                FROM app_items a";
            $datos = $this->ExecSQL($sql);
            $datosItems = [];
            $i = 0;
            foreach ($datos as $dato) {
                $datosItems[$i] = $dato;
                $i = $i + 1;
            }
            return $datosItems;
        }

        public function SelectItems_id($rowid) {
            $sql = "SELECT rowid, name, href, icon, is_target FROM app_items WHERE rowid = " . $rowid;
            $datos = $this->ExecSQL($sql);
    
            foreach ($datos as $datosItems);
            /*
            $i = 0;
            foreach ($datos as $dato) {
                $datosItems[$i] = $dato;
                $i++;
            }
            */
            return $datosItems;
        }

        public function SelectItems_name($name, $rowid = null) {
            if ($rowid)
                $sql = "SELECT rowid, name, href, icon, is_target FROM app_items WHERE rowid != " . $rowid . " AND name = '" . $name . "'";
            else
                $sql = "SELECT rowid, name, href, icon, is_target FROM app_items WHERE name = '" . $name . "'";
            $datos = $this->ExecSQL($sql);

            $datosItems = [];
            $i = 0;
            foreach ($datos as $dato) {
                $datosItems[$i] = $dato;
                $i = $i + 1;
            }
            return $datosItems;
        }
    
        public function SelectSubItems_name($idItem_id, $subName, $rowid = null) {
            if ($rowid)
                $sql = "SELECT rowid, name, href, icon, is_target FROM app_sub_items WHERE rowid != " . $rowid . " AND item_id = " . $idItem_id . " AND name = '" . $subName . "'";
            else
                $sql = "SELECT rowid, name, href, icon, is_target FROM app_sub_items WHERE item_id = " . $idItem_id . " AND name = '" . $subName . "'";
            $datos = $this->ExecSQL($sql);
            
            $datosSubItems = [];
            $i = 0;
            foreach ($datos as $dato) {
                $datosSubItems[$i] = $dato;
                $i = $i + 1;
            }
            return $datosSubItems;
        }
    
        public function AddItems($datos) {
            $sql = "
                INSERT INTO app_items (name, href, icon)
                    VALUES ('"
                        . $datos['nameItem'] . "', '"
                        . $datos['hrefItem'] . "', '"
                        . $datos['icon'] . "')";
            return $this->ExecSQL($sql);
        }

        public function EdtItems($datos) {
            $sql = "
                UPDATE app_items SET
                    name = '" . $datos['nameItem'] . "',
                    href = '" . $datos['hrefItem'] . "',
                    icon = '" . $datos['icon'] . "',
                    is_target = " . $datos['is_target'] . "
                    WHERE rowid = ". $datos['idItem'];
            return $this->ExecSQL($sql);
        }
        
        public function AddSubItems($datos) {
            $sql = "
                INSERT INTO app_sub_items (name, href, item_id, icon) 
                    VALUES ('"
                        . $datos['nameSubItem']. "', '" 
                        . $datos['hrefSubItem'] . "', " 
                        . $datos['idItem_id'] . ", '" 
                        . $datos['icon'] . "')";
            return $this->ExecSQL($sql);
        }
    
        public function EdtSubItems($datos) {
            $sql = "
                UPDATE app_sub_items SET
                    item_id = " . $datos['idItem_id'] . ",
                    name = '" . $datos['nameSubItem'] . "',
                    href = '" . $datos['hrefSubItem'] . "',
                    icon = '" . $datos['icon'] . "',
                    is_target = " . $datos['is_target'] . "
                    WHERE rowid = ". $datos['rowid'];
            return $this->ExecSQL($sql);
        }

        public function BorrarItemDB_id($idItem) {
            $sql = "DELETE FROM app_items WHERE rowid = ". $idItem;
            return $this->ExecSQL($sql);
        }

        public function BorrarSubItemDB_id($idItem) {
            $sql = "DELETE FROM app_sub_items WHERE rowid = ". $idItem;
            try {
                $sql_res = $this->ExecSQL($sql);
            }
            catch (\Exception $e) {
                echo $e;
                return false;
            }
            return $sql_res;
        }

        public function SelectSubItems_itemId($idItem) {
            $sql = "SELECT rowid, name, href, item_id, icon, is_target FROM app_sub_items WHERE item_id = " . $idItem;
            $datos = $this->ExecSQL($sql);
    
            $datosItems = [];
            $i = 0;
            foreach ($datos as $dato) {
                $datosItems[$i] = $dato;
                $i++;
            }
            return $datosItems;
        }
        
        public function SelectSubItems_id($rowid) {
            $sql = "SELECT rowid, name, href, item_id, icon, is_target FROM app_sub_items WHERE rowid = " . $rowid;
            $datos = $this->ExecSQL($sql);
    
            foreach ($datos as $datosItems);
            /*
            foreach ($datos as $dato) {
                $datosItems[$i] = $dato;
                $i++;
            }
            */
            return $datosItems;
        }
    
        public function SelectSubItems_all($datos) {
            // La consulta para recoger los subitems de los items del menu principal
            $sql = "SELECT rowid, name, href, item_id FROM app_sub_items";
            $sub_datos = $this->ExecSQL($sql);
            //
            $i = 0;
            foreach ($sub_datos as $dato) {
                $datosItems[$i] = $dato;
                $i = $i + 1;
            }
            return $datosItems;
        }
    }

    class RolDB extends ConectorBD
    {
    
        public function CargarRoles()
        {
            $sql = "SELECT * FROM `app_rol`";
            $datos = $this->ExecSQL($sql);
            $total = mysqli_num_rows($datos);
            if ($total != 0) {
                $i = 1;
                foreach ($datos as $dato) {
                    $datos_rol[$i] = $dato;
                    $i++;
                }
                return $datos_rol;
            } else {
                return false;
            }
        }
        public function GuardarRol($datos)
        {
            $total = count($datos['dkeys']['key']);
            $sql = "";
            $sql .= "INSERT INTO `app_rol`";
            $sql .= '(`rowid`,`nombre`,';
            for ($i = 2; $i < $total; $i++) {
                if ($i != 17) {
                    $sql .= "`" . $datos['dkeys']['key'][$i] . "`,";
                } else {
                    $sql .= "`" . $datos['dkeys']['key'][$i] . "`";
                }
            }
            $sql .= ")VALUES(NULL,'" . $datos['nombre'] . "',";
            for ($i = 2; $i < $total; $i++) {
                if (!empty($datos['dkeys']['valor'][$i])) {
                    $valor = 1;
                } else {
                    $valor = 0;
                }
                if ($i != 17) {
    
                    $sql .= $valor . ",";
                } else {
                    $sql .= $valor;
                }
            }
            $sql .= ")";
            if ($this->ExecSQL($sql)) {
                return true;
            } else {
                return false;
            }
        }
        public function UpdateDatosRol(array $datos)
        {
    
            $sql = "UPDATE `app_rol` SET `{$datos['key']}`=" . $datos['valor'] . "  WHERE `rowid`=" . $datos['rowid'];
            if ($this->ExecSQL($sql)) {
                return true;
            } else {
                return false;
            }
        }
        public function ConsultarValorActual(int $rowid, string $key)
        {
            $sql = "SELECT `{$key}` FROM `app_rol` WHERE `rowid`=" . $rowid;
            $datos = $this->ExecSQL($sql);;
            foreach ($datos as $dato);
            return $dato[$key];
        }
        public function DeleteRol(int $rowid)
        {
            $sql = "DELETE FROM `app_rol` WHERE `rowid`=" . $rowid;
            if ($this->ExecSQL($sql)) {
                return true;
            } else {
                return false;
            }
        }

        public function RelacionUserRol($iduser)
        {
            $sql = "SELECT * FROM `app_users_rol` WHERE `iduser`=" . $iduser;
            $datos = $this->ExecSQL($sql);
            $total = mysqli_num_rows($datos);
            if ($total != 0) {
                $i = 1;
                foreach ($datos as $dato) {
                    $datos_rol[$i] = $dato;
                    $i++;
                }
                return $datos_rol;
            } else {
                return false;
            }
        }
        public function GuardarRolDB(array $datos)
        {
            if (!empty($datos['rowid'])) {
                echo $sql = "UPDATE `app_users_rol` SET `iduser`=" . $datos['iduser'] . ",`idrol`=" . $datos['idrol'] . " WHERE `rowid` = '" . addslashes($datos['rowid']) . "'";
            } else {
                echo $sql = "INSERT INTO `app_users_rol` (`iduser`,`idrol`) VALUES (" . $datos['iduser'] . "," . $datos['idrol'] . ")";
            }


            $res = $this->ExecSQL($sql);
            return ($res !== false);
        }
        public function ConsultarRolDB($iduser)
        {
            $sql = "SELECT a.idrol, b.nombre FROM app_users_rol a, app_rol b WHERE a.idrol = b.rowid AND a.iduser = " . $iduser;
            $datos = $this->ExecSQL($sql);
            $total = mysqli_num_rows($datos);
            if ($total > 0) {
                foreach ($datos as $dato);
                return $dato;
            } else {
                return false;
            }
        }
    }
    
?>