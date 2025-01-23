<?php

    class Utils {
        /**
         * Convierte una fecha a un formato específico.
         * @param string $fecha La fecha en formato original.
         * @param string $formato El formato de salida deseado, compatible con el formato de PHP date().
         * @return string Fecha formateada.
         */
        public static function convertirFecha($fecha, $formato = 'd/m/Y') {
            $fechaUnix = strtotime($fecha);
            if (!$fechaUnix) {
                return 'Formato de fecha inválido';
            }
            return date($formato, $fechaUnix);

            /*
            $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
            return $fechaObj->format($formato);
            */
        }
    }
?>