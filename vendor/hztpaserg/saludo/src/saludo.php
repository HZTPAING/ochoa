<?php
    namespace Saludo\Saludo;

    Class Saludo {
        private $msg;
        private $usuario;

        public function __construct($usuario) {
            $this->usuario = $usuario;
            $this->setSaludo();
        }

        private function setSaludo() {
            $this->msg = '
                <h2 class="card-title text-primary">Usuario:</h2>
                <p class="card-text">
                    <span class="me2">Usuario:</span>
                    <span class="fw-bold text-info">
                        ' . $this->usuario . ' 
                    </span>
                    <i class="fa-solid fa-bell"></i>
                </p>
            ';
        }

        public function getSaludo() {
            echo $this->msg;
        }
    }