<?php

// Verificar si una sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Carga el controller.php para manejar las peticiones y redirecciones
require_once(__DIR__ . '/controller.php');
// Carga el model.php para trabajar con la base de datos
require_once(__DIR__ . '/../model/model.php');

$MenuDB = new MenuDB();
$filtro = new FiltrarDatos();

if ($_POST) {
    // limpiar los dados en la variabla GET y validarla
    $datos_post = $filtro->Filtrar($_POST);
    if (isset($datos_post['action']) && !empty($datos_post['action'])) {
        // ADD_ITEM
        if ($datos_post['action'] == 'ADD_ITEM') {
            // Accion del añadir item del menu principal
            $datos['nameItem'] = $datos_post['nameItem'];
            $datos['hrefItem'] = $datos_post['hrefItem'];
            $datos['icon'] = $datos_post['icon'];
            $datos['is_target'] = (
                $datos_post['is_target'] == 'on' ? 1 : 0
            );
            // Verificamos si el nombre del Item ya existe
            $res = $MenuDB->SelectItems_name($datos['nameItem']);
            if ($res) {
                $mensage = '<div class="alert alert-danger">El nombre del Item <strong>' . $datos['nameItem'] . '</strong> ya existe. Por favor, elige otro nombre.</div>';
                header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
            } else {
                // Añadimos el nombre del Item
                $res = $MenuDB->AddItems($datos);
                if ($res) {
                    $mensage = '<div class="alert alert-success">El Item <strong>' . $datos['nameItem'] . '</strong> añadido correctamente.</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al añadir el Item de la menu preincipal en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                }
            }
        }
        // EDT_ITEM
        if ($datos_post['action'] == 'EDT_ITEM') {
            // Accion del EDITAR item del menu principal
            $datos['idItem'] = $datos_post['idItem'];
            $datos['nameItem'] = $datos_post['nameItem'];
            $datos['hrefItem'] = $datos_post['hrefItem'];
            $datos['icon'] = $datos_post['icon'];
            $datos['is_target'] = (
                $datos_post['is_target'] == 'on' ? 1 : 0
            );
            // Verificamos si el nombre del Item ya existe
            $res = $MenuDB->SelectItems_name($datos['nameItem'], $datos['idItem']);
            if ($res) {
                $mensage = '<div class="alert alert-danger">El nombre del Item <strong>' . $datos['nameItem'] . '</strong> ya existe. Por favor, elige otro nombre.</div>';
                header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&&action=edt_item&&id=' . base64_encode($datos['idItem']) . '&&res=' . urlencode($mensage));
            } else {
                // Actualizamos los datos del Item
                $res = $MenuDB->EdtItems($datos);
                if ($res) {
                    $mensage = '<div class="alert alert-success">El Item <strong>' . $datos['nameItem'] . '</strong> actualizado correctamente.</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al actualizar el Item <strong>' . $datos['nameItem'] . '</strong> de la menu preincipal en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&&res=' . urlencode($mensage));
                }
            }
        }
        // ADD_SUB_ITEM
        if ($datos_post['action'] == 'ADD_SUB_ITEM') {
            // Accion del añadir subItem del item del menu principal
            $datos['idItem_id'] = $datos_post['nameItem_id'];
            $datos['nameSubItem'] = $datos_post['nameSubItem'];
            $datos['hrefSubItem'] = $datos_post['hrefSubItem'];
            $datos['icon'] = $datos_post['icon'];
            $datos['is_target'] = (
                $datos_post['is_target'] == 'on' ? 1 : 0
            );
            // Verificamos si el nombre del subItem ya existe
            $res = $MenuDB->SelectSubItems_name($datos['idItem_id'], $datos['nameSubItem']);
            if ($res) {
                $mensage = '<div class="alert alert-danger">El nombre del subItem <strong>' . $datos['nameSubItem'] . '</strong> ya existe en el menu principal <strong>' . $datos['idItem_id'] . '</strong>. Por favor, elige otro nombre.</div>';
                header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&&action=add_sub_item&&res=' . urlencode($mensage));
            } else {
                // Añadimos el nombre del subItem
                $res = $MenuDB->AddSubItems($datos);
                if ($res) {
                    $mensage = '<div class="alert alert-success">El subItem <strong>' . $datos['nameSubItem'] . '</strong> del menu principal <strong>' . $datos['idItem_id'] . '</strong> añadido correctamente.</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al añadir el subItem <strong>' . $datos['nameSubItem'] . '</strong> del menu preincipal en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                }
            }
        }
        // EDT_SUB_ITEM
        if ($datos_post['action'] == 'EDT_SUB_ITEM') {
            // Accion del EDITAR subItem del menu principal
            $datos['idItem_id'] = $datos_post['nameItem_id'];
            $datos['rowid'] = $datos_post['idItem'];
            $datos['nameSubItem'] = $datos_post['nameSubItem'];
            $datos['hrefSubItem'] = $datos_post['hrefSubItem'];
            $datos['icon'] = $datos_post['icon'];
            $datos['is_target'] = (
                $datos_post['is_target'] == 'on' ? 1 : 0
            );
            // Verificamos si el nombre del subItem ya existe en el menu principal
            $res = $MenuDB->SelectSubItems_name($datos['idItem_id'], $datos['nameSubItem'], $datos['rowid']);
            if ($res) {
                $mensage = '<div class="alert alert-danger">El nombre del subItem <strong>' . $datos['nameSubItem'] . '</strong> ya existe en el menu principal <strong>' . $datos['idItem_id'] . '</strong>. Por favor, elige otro nombre.</div>';
                header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&action=edt_sub_item&&id=' . base64_encode($datos['rowid']) . 'item_id=' . base64_encode($datos['idItem_id']) . '&&res=' . urlencode($mensage));
            } else {
                // Actualizamos los datos del subItem
                $res = $MenuDB->EdtSubItems($datos);
                if ($res) {
                    $mensage = '<div class="alert alert-success">El subItem <strong>' . $datos['nameSubItem'] . '</strong> del menu principal <strong>' . $datos['idItem_id'] . '</strong> actualizado correctamente.</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al actualizar el subItem <strong>' . $datos['nameSubItem'] . '</strong> del menu principal <strong>' . $datos['idItem_id'] . '</strong> en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                }
            }
        }
        // VALIDAR_ITEM
        if ($datos_post['action'] == 'VALIDAR_ITEM') {
            // Accion de validar el nombre del item del menu principal
            $name = $datos_post['nameItem'];
            $modoItem = $datos_post['modoItem'];
            $rowid = $datos_post['idItem'];
            // Verificamos si el nombre del Item ya existe
            if ($modoItem == 'ADD_ITEM')
                $res = $MenuDB->SelectItems_name($name);
            else
                $res = $MenuDB->SelectItems_name($name, $rowid);
            if ($res) {
                echo json_encode(1);
                exit();
            } else {
                echo json_encode(0);
                exit();
            }  
        }
    }
}

if ($_GET) {
    // limpiar los dados en la variabla GET y validarla
    $datos_get = $filtro->Filtrar($_GET);
    if (isset($datos_get['action']) && !empty($datos_get['action'])) {
        // DEL_ITEM
        if ($datos_get['action'] == 'DEL_ITEM') {
            // Accion del borrar item del menu principal
            $rowid = base64_decode($datos_get['id']);
            $name = base64_decode($datos_get['nombre']);
            // Verificamps si el Item contiene los subItems
            $res = $MenuDB->SelectSubItems_itemId($rowid);
            if ($res) {
                $mensage = '<div class="alert alert-danger">No se puede eliminar el Item <strong>' . $name . '</strong> debido a que tiene subitems.</div>';
                header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
            } else {
                // Eliminamos el nombre del Item
                $res = $MenuDB->BorrarItemDB_id($rowid);
                if ($res) {
                    $mensage = '<div class="alert alert-success">El Item <strong>' . $name . '</strong> eliminado correctamente.</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al eliminar el Item de la menu preincipal en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                }
            }
        }
        // DEL_SUB_ITEM
        if ($datos_get['action'] == 'DEL_SUB_ITEM') {
            // Accion del borrar subItem del Item del menu principal
            $rowid = base64_decode($datos_get['id']);
            $name = base64_decode($datos_get['nombre']);
            // Verificamps si el Item contiene los subItems
            // $res = $MenuDB->SelectSubItems_id($rowid);
            $res = false;
            if ($res) {
                $mensage = '<div class="alert alert-danger">No se puede eliminar el Item <strong>' . $name . '</strong> debido a que tiene subitems.</div>';
                header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
            } else {
                // Eliminamos el nombre del subItem
                $res = $MenuDB->BorrarSubItemDB_id($rowid);
                if ($res) {
                    $mensage = '<div class="alert alert-success">El subItem <strong>' . $name . '</strong> eliminado correctamente.</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al eliminar el subItem de la menu preincipal en la BD</div>';
                    header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                }
            }
        }
        // DEL_SUB_ITEM_AJAX
        if ($datos_get['action'] == 'DEL_SUB_ITEM_AJAX') {
            // Accion del borrar subItem del Item del menu principal
            $rowid = base64_decode($datos_get['id']);
            $name = base64_decode($datos_get['nombre']);
            // Verificamps si el Item contiene los subItems
            // $res = $MenuDB->SelectSubItems_id($rowid);
            $res = false;
            $mensage = '';
            if ($res) {
                $mensage = '<div class="alert alert-danger">No se puede eliminar el Item <strong>' . $name . '</strong> debido a que tiene subitems.</div>';
                // header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
            } else {
                // Eliminamos el nombre del subItem
                $res = $MenuDB->BorrarSubItemDB_id($rowid);
                if ($res) {
                    $mensage = '<div class="alert alert-success">El subItem <strong>' . $name . '</strong> eliminado correctamente.</div>';
                    // header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                } else {
                    $mensage = '<div class="alert alert-danger">Error al eliminar el subItem de la menu preincipal en la BD</div>';
                    // header('location:' . BASE_URL . '/oficina/index.php?views=config&tab=1&&res=' . urlencode($mensage));
                }
            }
            $respuesta['res'] = $res;
            $respuesta['msg'] = $mensage;
            echo json_encode($respuesta);
            exit();
        }
        // VALIDAR_ITEM
        if ($_GET['action'] == 'VALIDAR_ITEM') {
            $datos_post = $filtro->Filtrar($_GET);
            // Accion de validar el nombre del item del menu principal
            $name = $datos_get['nameItem'];
            // Verificamos si el nombre del Item ya existe
            echo $MenuDB->SelectItems_name($name);
            exit();
            if ($res) {
                echo json_encode(1);
                exit();
            } else {
                echo json_encode(0);
                exit();
            }
            
        }
    }
}

class Menu {
    private $items = array();
    private $subItems = array();

    public $menu;                   // Menu
    public $menuOf;
    public $form_item;              // Formulario ADD/EDT ITEMS
    public $form_subitem;           // Formulario ADD/EDT SUBITEMS
    public $lista_items;            // La lista de los items del menu principal
    public $lista_sub_items;        // La lista de los subItems del menu principal
    public $rowid = 0;              // El rowid del Item actual
    public $subRowid = 0;           // El rowid del subItem actual 
    public $action_item = '';       // La accion para el formulario de añadir/editar el item del menú principal
    public $action_sub_item = '';   // La accion para el formulario de añadir/editar el item del submenú
    public $titulo_form_item;       // El titulo del formulario de añadir/editar el item del menú principal
    public $titulo_form_sub_item;       // El titulo del formulario de añadir/editar el subItem del menú principal

    public function __construct() {
        $this->setItemsDB();                          // Rellenamos las listas de $items y $refItems
        $this->setSubItemsDB();                       // Rellenamos las listas de $items y $refItems
        $this->setMenu();                             // Construimos el menu
        $this->setMenuOf();                           // Construimos el menu
        $this->detectItemModeAndSetForm();            // La función para detectar el modo y configurar el formulario
        $this->detectSubItemModeAndSetForm();         // La función para detectar el modo y configurar el formulario del subItem
        $this->setListItems();                        // Construimos la lista de los items del menu principal
        //$this->setListSubItems();                   // Construimos la lista de los subitems de los items del menu principal
    }

    // GENERA EL MENU PRINCIPAL
    private function setMenu() {
        // ul principal
        $this->menu = '
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="' . BASE_URL . '/oficina/index.php?views=home">Home</a>
                </li>
            ';

        $i = 0;
        foreach ($this->items as $item) {
            $is_target_item = ($item['is_target'] == 1 ? 'target="_blank"' : '');
            if (!empty($this->subItems[$i])) {
                // El Menu Item que lleva sub Items
                $this->menu .= '
                    <li class="nav-item dropdown d-flex align-items-center">
                    <a 
                        class="nav-link dropdown-toggle" 
                        href="#" 
                        role="button" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false" 
                        ' . $is_target_item . '
                    >
                        ' . $item['name'] . '
                        <a class="me-2">'
                            . $item["icon"] .
                        '</a>
                    </a>
                    <ul class="dropdown-menu">
                ';

                // Recorremos la array de sub items
                $j = 0;
                foreach ($this->subItems[$i] as $subItem) {
                    $is_target_sub_item = ($subItem['is_target'] == 1 ? 'target="_blank"' : '');
                    $this->menu .= '
                            <li class="dropdown-item d-flex align-items-center>
                                <a class="me-2">'
                                    . $subItem["icon"] .
                                '</a>
                                <a 
                                    class="dropdown-item" 
                                    href="' . $subItem['href'] . '" 
                                    ' . $is_target_sub_item . '
                                >
                                ' . $subItem['name'] . '
                                </a>
                            </li>
                            ';
                    $j++;
                }

                // Cerramos el <ul> y el <li> para el menú con subítems
                $this->menu .= '
                    </ul>
                    </li>
                ';
            } else {
                // El Menu Item que no lleva sub Items
                $this->menu .= '
                    <li class="nav-item d-flex align-items-center">
                        <a 
                            class="nav-link" 
                            aria-current="page" 
                            href="' . $item['href'] . '" 
                            ' . $is_target_item . '
                        >
                            ' . $item['name'] . '
                        </a>
                        <a class="me-2">'
                            . $item["icon"] .
                        '</a>
                    </li>
                ';
            }
            $i++;
        }

        // El Item de "Configuracion"
        $this->menu .= '
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="' . BASE_URL . '/oficina/index.php?views=config&tab=1">Config</a>
                </li>
            ';

        // Cerramos <ul> principal
        $this->menu .= '
                </ul>
            ';
    }

    // GENERA EL MENU PARA LA PAGINA "CONFIG"
    private function setMenuOf() {
        // ul principal
        $this->menuOf = '
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            ';

        $i = 0;
        foreach ($this->items as $item) {
            if (!empty($this->subItems[$i])) {

                // El Menu Item que lleva sub Items
                $this->menuOf .= '
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a class="me-1">'
                            . $item["icon"] .
                        '</a>
                        <a class="btn btn-sm btn-success me-1"
                            href="' . BASE_URL . '/oficina/index.php?
                                views=config&tab=1&&
                                action=edt_item&&
                                icon=' . base64_encode($item["icon"]) . '&&
                                id=' . base64_encode($item["rowid"]) . '
                            "
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        <a/>
                        <a class="btn btn-sm btn-danger me-1" href="#" onclick=\'confirmarBorrado("' . base64_encode($item["rowid"]) . '", "' . addslashes(base64_encode($item["name"])) . '", "navi_controller", "DEL_ITEM")\'>
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        <a class="nav-link dropdown-toggle me-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ' . $item['name'] . '
                        </a>
                        <ul class="dropdown-menu">
                    ';

                // Recorremos la array de sub items
                $j = 0;
                foreach ($this->subItems[$i] as $subItem) {
                    $this->menuOf .= '
                            <li 
                                class="dropdown-item d-flex align-items-center"
                                id="li_' . base64_encode($subItem["rowid"]) . '"
                            >
                                <a class="me-2">'
                                    . $subItem["icon"] .
                                '</a>
                                <a class="btn btn-sm btn-success me-1" 
                                    href="' . BASE_URL . '/oficina/index.php?
                                        views=config&tab=1&&
                                        action=edt_sub_item&&
                                        icon=' . base64_encode($subItem["icon"]) . '&&
                                        id=' . base64_encode($subItem["rowid"]) . '&&
                                        item_id=' . base64_encode($subItem["item_id"]) . '
                                    "
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="btn btn-sm btn-danger me-1" 
                                    href="#" 
                                    onclick=\'
                                        confirmarBorrado("' 
                                            . base64_encode($subItem["rowid"]) . '", "' 
                                            . addslashes(base64_encode($subItem["name"])) . '", 
                                            "navi_controller", 
                                            "DEL_SUB_ITEM"
                                        )
                                    \'
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                                <a class="dropdown-item" href="' . $subItem['href'] . '">
                                    ' . $subItem['name'] . '
                                </a>
                            </li>
                            ';
                    $j++;
                }

                // Cerramos el <ul> y el <li> para el menú con subítems
                $this->menuOf .= '
                        </ul>
                    </li>
                    ';
            } else {
                // El Menu Item que no lleva sub Items
                $this->menuOf .= '
                    <li class="nav-item d-flex align-items-center">
                        <a class="me-1">'
                            . $item["icon"] .
                        '</a>
                        <a class="btn btn-sm btn-success me-1" 
                            href="' . BASE_URL . '/oficina/index.php?
                                views=config&tab=1&&
                                action=edt_item&&
                                icon=' . base64_encode($item["icon"]) . '&&
                                id=' . base64_encode($item["rowid"]) . '
                            "
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        <a/>
                        <a class="btn btn-sm btn-danger me-1" href="#" onclick=\'confirmarBorrado("' . base64_encode($item["rowid"]) . '", "' . addslashes(base64_encode($item["name"])) . '", "navi_controller", "DEL_ITEM")\'>
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        <a class="nav-link me-2" aria-current="page" href="' . $item['href'] . '">
                            ' . $item['name'] . '
                        </a>
                    </li>
                    ';
            }
            $i++;
        }
        // Cerramos <ul> principal
        $this->menuOf .= '
                </ul>
            ';
    }

    public function addSubItem($parent, $item) {
        $this->subItems[$parent][] = $item;
    }

    public function addItem($item) {
        $this->items[] = $item;
    }

    // DETECTAMOS EL MODO ADD/EDT PARA ITEMS
    public function detectItemModeAndSetForm() {
        $filtro = new FiltrarDatos();

        // limpiar los dados en la variabla GET y validarla
        $datos_get = $filtro->Filtrar($_GET);

        // detectamos el modo de EDICION o ADICION
        if (
            isset($datos_get['action']) &&
            $datos_get['action'] == 'edt_item' &&
            isset($datos_get['id'])
        ) {
            // EDICION
            $rowid = base64_decode($datos_get['id']);
            $MenuDB = new MenuDB();
            $datos_item = $MenuDB->SelectItems_id($rowid);   // Obtenemos datos del Item                 

            $this->setFormItem($datos_item);   // Dibujamos el formulario pasando los datos del Item
        } else {
            // ADICION
            $this->setFormItem();
        }
    }

    // DETECTAMOS EL MODO ADD/EDT PARA SUBITEMS
    public function detectSubItemModeAndSetForm() {
        $filtro = new FiltrarDatos();

        // limpiar los dados en la variabla GET y validarla
        $datos_get = $filtro->Filtrar($_GET);

        // detectamos el modo de EDICION o ADICION
        if (
            isset($datos_get['action']) &&
            $datos_get['action'] == 'edt_sub_item' &&
            isset($datos_get['id']) &&
            isset($datos_get['item_id'])
        ) {
            // EDICION
            $item_id = base64_decode($datos_get['item_id']);
            $rowid = base64_decode($datos_get['id']);
            $MenuDB = new MenuDB();
            $datos_sub_item = $MenuDB->SelectSubItems_id($rowid);

            $this->setFormSubItem($datos_sub_item);   // Dibujamos el formulario pasando los datos del subItem
        } else {
            // ADICION
            $this->setFormSubItem();
        }
    }

    // FORMULARIO DE ITEMS
    private function setFormItem($datos_item = NULL) {
        // Determinamos el modo y los valores del formulario
        $rowid = $datos_item ? $datos_item['rowid'] : '';
        $name = $datos_item ? $datos_item['name'] : '';
        $href = $datos_item ? $datos_item['href'] : '';
        $icon = $datos_item ? htmlspecialchars_decode($datos_item['icon'], ENT_QUOTES) : '';
        $is_target = $datos_item ? 
            (
                $datos_item['is_target'] == 1 ? 
                    'checked' : 
                    ''
            ) : '';
        $modo = $datos_item ? 'EDT_ITEM' : 'ADD_ITEM';  //Determinamos el modo
        $botonName = $datos_item ? 'Actualizar' : 'Agregar';    // El nombre del boton
        $this->titulo_form_item = $datos_item ?
            'Editar el item 
                    <span style="color: blue;">"'
            . $name .
            '"</span>' :
            'Añadir el item';    // El nombre del titulo

        // Generamos HTML del formulario para los ítems del menú
        $this->form_item = '
                <form class="form-control" method="post" action="">
                <label class="fw-bold">Nombre del Item: </label>
                <input name="nameItem" 
                    type="text" 
                    class="form-control" 
                    id="idNameItem"
                    onchange="validarItem_FetchAPI(this.value)" 
                    value="'
                        . $name .
                    '" 
                    required
                >
                <label class="fw-bold">Href del Item: </label>
                <input name="hrefItem" 
                    type="text" 
                    class="form-control" 
                    id="idUrlItem"
                    onchange="validarUrlItem(this.value)"
                    value="'
                        . $href .
                    '" 
                    required
                >
                <div class="form-check form-switch mt-3 mb-3">
                    <input 
                        name="is_target"
                        class="form-check-input" 
                        type="checkbox" 
                        role="switch" 
                        id="flexSwitchCheckDefault"
                        '. $is_target . '
                    >
                    <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">Abrir en una pestaña nueva</label>
                </div>
                <label class="fw-bold">Elegir un ICONO: </label>
                <div class="input-group mb-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        name="icon"
                        value="'
                            . htmlspecialchars($icon, ENT_QUOTES) .
                        '" 
                    >
                    <span 
                        class="input-group-text" 
                        id="basic-addon2"
                    >
                        <a 
                            class="btn btn-primary" 
                            href="https://fontawesome.com/search?o=r&m=free&new=yes&f=classic" 
                            target="_blank"
                        >
                            Font Awesome
                        </a> 
                    </span>
                </div>

                <input type="hidden" id="idItem" name="idItem" value="' . $rowid . '">
                <input type="hidden" id="idAction" name="action" value="' . $modo . '">
                <input 
                    id="idGuardar"
                    type="submit" 
                    class="btn btn-primary" 
                    value="'
                        . $botonName .
                    '" 
                    disabled
                >
                <input type="reset" class="btn btn-danger" value="RESET">
                </form>
            ';
    }

    // FORMULARIO DE SUBITEMS
    private function setFormSubItem($datos_sub_item = NULL) {
        // Determinamos el modo y los valores del formulario
        $item_id = $datos_sub_item ? $datos_sub_item['item_id'] : '';
        $rowid = $datos_sub_item ? $datos_sub_item['rowid'] : '';
        $name = $datos_sub_item ? $datos_sub_item['name'] : '';
        $href = $datos_sub_item ? $datos_sub_item['href'] : '';
        $icon = $datos_sub_item ? htmlspecialchars_decode($datos_sub_item['icon'], ENT_QUOTES) : '';
        $is_target = $datos_sub_item ? 
            (
                $datos_sub_item['is_target'] == 1 ? 
                    'checked' : 
                    ''
            ) : '';
        $modo = $datos_sub_item ? 'EDT_SUB_ITEM' : 'ADD_SUB_ITEM';  //Determinamos el modo
        $botonName = $datos_sub_item ? 'Actualizar' : 'Agregar';    // El nombre del boton
        $this->titulo_form_sub_item = $datos_sub_item ?
            'Editar el subItem 
                    <span style="color: blue;">"'
            . $name .
            '"</span>' :
            'Añadir el subItem';    // El nombre del titulo

        // Generamos HTML del formulario para el selector de los ítems del menú principal
        $MenuDB = new MenuDB();
        $ItemsAll = $MenuDB->SelectItems_all();
        $this->form_subitem = '
                <form class="form-control" method="post" action="' . BASE_URL . '/oficina/controller/navi_controller.php">
                <label class="fw-bold">Selectiona el Item:</label>
                <select class="form-select" name="nameItem_id" id="idItem_id" required>
                    <option value=""></option>
                ';
        foreach ($ItemsAll as $items) {
            $this->form_subitem .= '
                    <option value="'
                . $items["rowid"] .
                '"'
                . ($items['rowid'] == $item_id ? 'selected' : '') .
                '>'
                . $items["name"] .
                '</option>
                ';
        }
        // Generamos HTML del formulario para los ítems del sub menú
        $this->form_subitem .= '
                </select>
                <label class="fw-bold">Submenu</label>
                <input name="nameSubItem" 
                    class="form-control" 
                    type="text" 
                    value="'
                        . $name .
                    '" 
                    required
                >
                <label class="fw-bold">Href del sub Item</label>
                <input name="hrefSubItem" 
                    class="form-control" 
                    type="text" 
                    value="'
                        . $href .
                    '" 
                    required
                >
                <div class="form-check form-switch mt-3 mb-3">
                    <input 
                        name="is_target"
                        class="form-check-input" 
                        type="checkbox" 
                        role="switch" 
                        id="flexSwitchCheckDefault"
                        ' . $is_target . '
                    >
                    <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">Abrir en una pestaña nueva</label>
                </div>
                <label class="fw-bold">Elegir un ICONO para sub Item: </label>
                <div class="input-group mb-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        name="icon"
                        value="'
                            . htmlspecialchars($icon, ENT_QUOTES) .
                        '" 
                    >
                    <span 
                        class="input-group-text" 
                        id="basic-addon2"
                    >
                        <a 
                            class="btn btn-primary" 
                            href="https://fontawesome.com/search?o=r&m=free&new=yes&f=classic" 
                            target="_blank"
                        >
                            Font Awesome
                        </a> 
                    </span>
                </div>
                <input type="hidden" name="idItem" value="' . $rowid . '">
                <input type="hidden" name="action" value="' . $modo . '">
                <input type="submit" 
                    class="btn btn-primary" 
                    value="' . $botonName . '">
                <input type="reset" 
                    class="btn btn-danger" 
                    value="RESET"
                >
                </form>
            ';
    }

    // GENERAMOS LA LISTA DE LOS MENUS PRINCIPAL
    private function setListItems() {
        // Aquí se conectaría a la base de datos y se cargaria la lista de los items del menú desde ella
        $this->lista_items = '
                <table id="table-items" class="table table-striped table-primary table-hover">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Icono</th>
                    <th>Target</th>
                    <th>URL</th>
                    <th>SubItem</th>
                    <th></th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
            ';
        // Cargamos los datos desde la base de datos
        $MenuDB = new MenuDB();
        $datosItems = $MenuDB->SelectItems_all();
        foreach ($datosItems as $datos_item) {
            $this->lista_items .= "
                <tr>
                    <td>" . $datos_item['rowid'] . "</td>
                    <td>" . $datos_item['name'] . "</td>
                    <td>" . htmlspecialchars_decode($datos_item['icon'], ENT_QUOTES) . "</td>
                    <td>" . $datos_item['is_target'] . "</td>
                    <td>" . $datos_item['href'] . "</td>
                    <td>" . $datos_item['subitem_id'] . "</td>
                    <td><a class='btn btn-sm btn-success'
                        href='' . BASE_URL . '/oficina/index.php?
                            views=config&tab=1&&
                            action=edt_item&&
                            id=" . base64_encode($datos_item['rowid']) . "'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </td>
                    <td><a class='btn btn-sm btn-danger' href='#' onclick=\"confirmarBorrado('" . base64_encode($datos_item['rowid']) . "', '" . addslashes(base64_encode($datos_item['name'])) . "', 'navi_controller', 'DEL_ITEM')\"><i class='fa-solid fa-trash'></i></td>
                </tr>
                ";
        }
        $this->lista_items .= '
                    </tbody>
                </table>
            ';
    }

    // GENERAMOS LA LISTA DE LOS SUBITEMS DEL ITEM DEL MENU PRINCIPAL
    private function setListSubItems($item_id) {
        // Conectamos a la base de datos y cargamos la lista de los subItems del Item del menú principal
        $this->lista_sub_items = '
                <table id="table-subitems" class="table table-striped table-primary table-hover">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Icono</th>
                    <th>URL</th>
                    <th></th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
            ';
        // Cargamos los datos desde la base de datos
        $MenuDB = new MenuDB();
        $datosSubItems = $MenuDB->SelectSubItems_itemId($item_id);
        foreach ($datosSubItems as $datos_sub_item) {
            $this->lista_sub_items .= "
                <tr>
                    <td>" . $datos_sub_item['rowid'] . "</td>
                    <td>" . $datos_sub_item['name'] . "</td>
                    <td>" . $datos_sub_item['icon'] . "</td>
                    <td>" . $datos_sub_item['href'] . "</td>
                    <td><a class='btn btn-sm btn-success' href='' . BASE_URL . '/oficina/controller/navi_controller.php?action=edt_sub_item&&id=" . base64_encode($datos_sub_item['rowid']) . "'><i class='fa-solid fa-pen-to-square'></i></td>
                    <td><a class='btn btn-sm btn-success'
                        href='' . BASE_URL . '/oficina/index.php?
                            views=config&tab=1&&
                            action=edt_sub_item&&
                            id=" . base64_encode($datos_sub_item['rowid']) . "'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </td>
                    <td><a class='btn btn-sm btn-danger' href='#' onclick=\"confirmarBorrado('" . base64_encode($datos_sub_item['rowid']) . "', '" . addslashes(base64_encode($datos_sub_item['name'])) . "', 'navi_controller', 'DEL_SUB_ITEM')\"><i class='fa-solid fa-trash'></i></td>
                </tr>
                ";
        }
        $this->lista_sub_items .= '
                    </tbody>
                </table>
            ';
    }

    // CARGAMOS EL MENU DESDE BD
    private function setItemsDB() {
        // Aquí se conectaría a la base de datos y se cargaria el menú desde ella
        $MenuDB = new MenuDB();
        $itemsAll = $MenuDB->SelectItems_all();
        $i = 0;  // Indice para el arreglo de items y refItems
        $this->items = [];
        foreach ($itemsAll as $item) {
            $this->items[$i] = [
                'rowid' => $item['rowid'],
                'name' => $item['name'],
                'href' => $item['href'],
                'icon' => htmlspecialchars_decode($item['icon'], ENT_QUOTES),
                'is_target' => $item['is_target']
            ];
            $i++;
        }
    }

    // CARGAMOS EL SUBMENU DEL ITEM DEL MENU PRINCIPAL DESDE BD
    private function setSubItemsDB() {
        $MenuDB = new MenuDB();
        // Conectamos a la base de datos y se cargamos los items del menu principal
        $datos_items = $MenuDB->SelectItems_all();
        $i = 0;
        foreach ($datos_items as $item) {
            $idItem = $item['rowid'];
            // Conectamos a la base de datos y se cargamos los subítems del Item del menu principal
            $datos_sub_items = $MenuDB->SelectSubItems_itemId($idItem);
            $j = 0;
            $this->subItems[$i] = [];
            foreach ($datos_sub_items as $subItem) {
                $this->subItems[$i][$j] = [
                    'rowid' => $subItem['rowid'],
                    'name' => $subItem['name'],
                    'href' => $subItem['href'],
                    'item_id' => $subItem['item_id'],
                    'icon' => htmlspecialchars_decode($subItem['icon'], ENT_QUOTES),
                    'is_target' => $item['is_target']
                ];
                $j++;
            }
            $i++;
        }
    }
}
?>