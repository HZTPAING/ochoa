<?php

    /**
        * @param $nomModal
    */

    class Modal {
        private $modal;
        private $nomModal;
        private $body;
        private $title;
        private $footer;
        private $header;
        private $btn;
        private $idBtnModal;
        private $btnTitle;

        public function __construct($nomModal = 'standar', $body = '', $title = 'Título por defecto', $footer = '', $header = '', $btnTitle = 'ABRIR', $idBtnModal = '') {
            $this->nomModal = $nomModal;
            $this->body = $body;
            $this->title = $title;
            $this->footer = $footer;
            $this->header = $header;
            $this->btnTitle = $btnTitle;
            $this->idBtnModal = $idBtnModal;
        
            $this->setModal();
            $this->setBtn();
        }

        public function setModal_old() {
            $this->modal = '
                <div class="modal" tabindex="-1" id="' . $this->nomModal . '">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">'
                                    . $this->title .
                                '</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                ' . $this->header . '
                            </div>
                            <div class="modal-body">
                                '. $this->body .'
                            </div>
                            <div class="modal-footer">
                                ' . $this->footer . '
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        public function setModal() {
            $this->modal = '
                <div class="modal fade" id="' . $this->nomModal . '" tabindex="-1" aria-labelledby="' . $this->nomModal . 'Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">' . $this->title . '</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                ' . $this->header . '
                            </div>
                            <div class="modal-body" id="BodyModal">
                                ' . $this->body . '
                            </div>
                            <div class="modal-footer">
                                ' . $this->footer . '
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>';
        }
  
        public function setBtn() {
            $this->btn = '
                <button id="' . $this->idBtnModal . '" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#' . $this->nomModal . '">
                    '. $this->btnTitle. '
                </button>
            ';
        }
        
        public function getModal() {
            return $this->modal;
        }

        public function getBtn() {
            return $this->btn;
        }
    }

    class Rol{
        public $roles;
        public $permiso = 0;
    
        function __construct(){
            $this->setRol();
        }
    
        private function setRol(){
            $roldb = new RolDB;
            $this->roles = $roldb->CargarRoles();
        }
        public function VerificarPermiso($tipo,$user){
            if($this->roles[$user][$tipo] == 1){
                $this->permiso = 1;
            }
            else{
                $this->permiso = 0;
            }
            return $this->permiso;
        }
    
        public function PintarModalRol($DatosRol){
            $bodyModal = "";
            $bodyModal .='<div class="container-fluid">';
            foreach ($DatosRol as $Dato) {
                $bodyModal .= '<div class="row">';
                $bodyModal .= '<div class="col-lg-12">';
                $bodyModal .= $Dato['rowid'] . '<br>';
                $bodyModal .= 'Tipo de Rol:' . $Dato['nombre'];
                $bodyModal .= '<hr>';
                $bodyModal .= '</div>';
                $bodyModal .= '<div class="row">';
                $bodyModal .= '<div class="col-lg-6">';
                $i = 0;
                foreach ($Dato as $key => $value) {
                    if ($i >= 2 && $i < 10) {
                        if($value == 1){
                            $icon = '<i class="fa-solid fa-check" style="color:green"></i>';
                        }
                        else
                        {
                            $icon = '<i class="fa-solid fa-ban" style="color:red"></i>';
                        }
                        $bodyModal .= $key . ': ' . $icon . '<br>';
                        }
                        $i++;
                }
                $bodyModal .= '</div>';
                $bodyModal .= '<div class="col-lg-6">';
                $j = 0;
                foreach ($Dato as $key => $value) {
                        if($value == 1){
                            $icon = '<i class="fa-solid fa-check" style="color:green"></i>';
                        }
                        else
                        {
                            $icon = '<i class="fa-solid fa-ban" style="color:red"></i>';
                        }
                        if ($j >= 10 && $j < 19) {
                            $bodyModal .= $key . ': ' . $icon . '<br>';
                        }
                            $j++;
                }
                $bodyModal .= '</div>';
        
                $bodyModal .= '</div>';
                $bodyModal .= '</div>';
                }
                
            $bodyModal .='</div>';
        
            return $bodyModal;
        
        }
        
        public function PintarModalRolEdit_old($Dato){    
            $bodyModal = "";
            $bodyModal .='<div class="container-fluid">';   
                $bodyModal .= '<div class="row">';
                $bodyModal .= '<div class="col-lg-12">';
                $bodyModal .= $Dato['rowid'] . '<br>';
                $bodyModal .= 'Tipo de Rol:' . $Dato['nombre'];
                $bodyModal .= '<hr>';
                $bodyModal .= '</div>';
                $bodyModal .= '<div class="row">';
                $bodyModal .= '<div class="col-lg-6">';
                $i = 0;
                foreach ($Dato as $key => $value) {
                    if ($i >= 2 && $i < 10) {
                        if($value == 1){
                            $icon = '<span id="ico-'.$key.'"><i class="fa-solid fa-check" style="color:green"></i></span>';
                            $checked = "checked";
                        }
                        else
                        {
                            $icon = '<span id="ico-'.$key.'"><i class="fa-solid fa-ban" style="color:red"></i></span>';
                            $checked = "";
                        }
                        $bodyModal .= $key . ': ' . $icon;
                        $bodyModal .= '
                                <div class="form-check form-switch">
                                    <!-- <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onchange="CambiarPermiso('.$Dato['rowid'].',\''.$key.'\')" '.$checked.'> -->
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch-'.$key.'" onchange="CambiarIcono(this)" '.$checked.'>
                                </div>
                        ';
                        $bodyModal .= '<br>';
                        }
                        $i++;
                }
                $bodyModal .= '</div>';
                $bodyModal .= '<div class="col-lg-6">';
                $j = 0;
                foreach ($Dato as $key => $value) {
                        if($value == 1){
                            $icon = '<span id="ico-'.$key.'"><i class="fa-solid fa-check" style="color:green"></i></span>';
                            $checked = "checked";
                        }
                        else
                        {
                            $icon = '<span id="ico-'.$key.'"><i class="fa-solid fa-ban" style="color:red"></i></span>';
                            $checked = "";
                        }
                        if ($j >= 10 && $j < 19) {
                            $bodyModal .= $key . ': ' . $icon;
                            $bodyModal .= '
                                <div class="form-check form-switch">
                                    <!-- <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onchange="CambiarPermiso('.$Dato['rowid'].',\''.$key.'\','.$value.')" '.$checked.'> -->
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch-'.$key.'" onchange="CambiarIcono(this)" '.$checked.'>
                                </div>
                            ';
                            $bodyModal .= '<br>';
                        }
                            $j++;
                }
                $bodyModal .= '</div>';
        
                $bodyModal .= '</div>';
                $bodyModal .= '</div>';
              
                
            $bodyModal .='</div>';
        
            return $bodyModal;
        
        }

        public function PintarModalRolEdit($Dato) {    
            $bodyModal = '<div class="container-fluid">';   
            $bodyModal .= '<div class="row">';
            $bodyModal .= '<div class="col-lg-12">';
            $bodyModal .= $Dato['rowid'] . '<br>';
            $bodyModal .= 'Tipo de Rol: ' . $Dato['nombre'];
            $bodyModal .= '<hr>';
            $bodyModal .= '</div>';
            $bodyModal .= '<div class="row">';
        
            // Columna izquierda de permisos
            $bodyModal .= '<div class="col-lg-6">';

            $i = 0;
            foreach ($Dato as $key => $value) {
                if ($i >= 2 && $i < 10) {
                    $checked = $value == 1 ? "checked" : "";  // Marcado según el valor
                    $icon = $value == 1 ? '<i class="fa-solid fa-check" style="color:green"></i>' : '<i class="fa-solid fa-ban" style="color:red"></i>';
                    $bodyModal .= "$key: $icon";
                    $bodyModal .= '
                        <div class="form-check form-switch">
                            <!-- <input class="form-check-input" type="checkbox" role="switch" id="switch-' . $key . '" onchange="CambiarPermiso(' . $Dato['rowid'] . ',\'' . $key . '\')" ' . $checked . '> -->
                            <input class="form-check-input" type="checkbox" role="switch" id="switch-' . $key . '" onchange="CambiarIcono(this)" ' . $checked . '>
                        </div>
                    ';
                    $bodyModal .= '<br>';
                }
                $i++;
            }
            $bodyModal .= '</div>';
        
            // Columna derecha de permisos
            $bodyModal .= '<div class="col-lg-6">';
            $j = 0;
            foreach ($Dato as $key => $value) {
                if ($j >= 10 && $j < 19) {
                    $checked = $value == 1 ? "checked" : "";  // Marcado según el valor
                    $icon = $value == 1 ? '<i class="fa-solid fa-check" style="color:green"></i>' : '<i class="fa-solid fa-ban" style="color:red"></i>';
                    $bodyModal .= "$key: $icon";
                    $bodyModal .= '
                        <div class="form-check form-switch">
                            <!-- <input class="form-check-input" type="checkbox" role="switch" id="switch-' . $key . '" onchange="CambiarPermiso(' . $Dato['rowid'] . ',\'' . $key . '\')" ' . $checked . '> -->
                            <input class="form-check-input" type="checkbox" role="switch" id="switch-' . $key . '" onchange="CambiarIcono(this)" ' . $checked . '>
                        </div>
                    ';
                    $bodyModal .= '<br>';
                }
                $j++;
            }
            $bodyModal .= '</div>';
        
            $bodyModal .= '</div>';
            $bodyModal .= '</div>';
            return $bodyModal;
        }
              
        public function PintarModalRolAdd($Datos){    
            foreach($Datos as $Dato){   
        
                $bodyModal = "";
                $bodyModal .='<div class="container-fluid">';   
                        $bodyModal .= '<div class="row">';
                            $bodyModal .= '<div class="col-lg-12">';        
                            $bodyModal .= 'Tipo de Rol: <input class="form-control" id="nombre" type="text" name="nombre" />';
                            $bodyModal .= '<hr>';
                            $bodyModal .= '</div>';
                        $bodyModal .= '<div class="row">';
                            $bodyModal .= '<div class="col-lg-6">';
                                    $i = 0;
                                    foreach ($Dato as $key => $value) {
                                       
                                        if ($i >= 2 && $i < 10) {                  
                                            $dkey[$i] = $key;
                                            $bodyModal .= $key . ': ';
                                            $bodyModal .= '
                                                    <div class="form-check form-switch">
                                                        <!-- <input class="form-check-input" type="checkbox" role="switch" id="switch-'.$key.'"  > -->
                                                        <input class="form-check-input" type="checkbox" role="switch" id="switch-'.$key.'" onchange="CambiarIcono(this)" >
                                                    </div>
                                            ';
                                            $bodyModal .= '<br>';
                                            }
                                            $i++;
                                    }
                            $bodyModal .= '</div>';
                            $bodyModal .= '<div class="col-lg-6">';
                                    $j = 0;
                                    foreach ($Dato as $key => $value) {                
                                            if ($j >= 10 && $j < 19) {
                                                $dkey[$j] = $key;
                                                $bodyModal .= $key;
                                                $bodyModal .= '
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="switch-'.$key.'"  >                            
                                                    </div>
                                                ';
                                                $bodyModal .= '<br>';
                                            }
                                                $j++;
                                    }
                            $bodyModal .= '</div>';
                        $bodyModal .= '</div>';
                    $bodyModal .= '</div>';      
                    $bodyModal .= '<button class="btn btn-primary" onclick="SaveRol(\''.base64_encode(json_encode($dkey)).'\')">GUARDAR ROL</button>';
                $bodyModal .='</div>';
                break;
            }
            return $bodyModal;
        
        }
    }
?>