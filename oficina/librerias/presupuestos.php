<?php
    use Dompdf\Dompdf;
    use Dompdf\Options;

    Class Presupuestos extends Dompdf {
        private $html;
        private $presu;
        private $presudte;
        private $empresa;
        private $cliente;
        private $dompdf;
        private $options;
        private $fuente;
        private $filename;
        private $download;
        private $empleado;
        private $path_pdf = '/uploads/presu-pdf/';

        public function __construct($presu = null, $presudte = null, $empresa = null, $empleado = null, $cliente = null, $filename = 'documento.pdf', $download = false) {
            $this->setFuente('Courier');
            $this->options = new Options();
            $this->options->set('isRemoteEnabled', true);                   // Permite cargar imágenes desde una URL
            $this->options->set('defaultFont', $this->fuente);              // Cambia el fuente
            // $this->setOptions($this->options);                           // Aplica las opciones a la instancia de Dompdf
            $this->dompdf = new Dompdf($this->options);

            $this->presu = $presu;
            $this->presudte = $presudte;
            $this->empresa = $empresa;
            $this->cliente = $cliente;
            $this->filename = $filename;
            $this->download = $download;
            $this->empleado = $empleado;

            $this->setHtml();
        }

        public function setFuente($fuente = "Werdana") {
            $this->fuente = $fuente;
        }

        public function crearPdf($html, $papel = 'A4', $orientacion = 'portrait') {
            // Crear el PDF
            try {
                // Habilitar la carga de imágenes remotas
                if (!$html) {
                    throw new Exception("No se ha establecido el HTML");
                }

                // Prevenir cualquier salida previa
                //ob_start(); // Iniciar el buffer de salida
                
                $this->dompdf->loadHtml($html);               // Carga el contenido en HTML + CSS + (Bootstrap5 ?)
                $this->dompdf->setPaper($papel, $orientacion);
                $this->dompdf->render();

                // Guardar en un fichero en el servidor
                $output = $this->dompdf->output();
                $path = '/uploads/presu-pdf/';
                $path_file = $this->path_pdf . $this->filename;

                if (!is_dir($this->path_pdf)) {
                    mkdir($path, 0777, true);
                }

                file_put_contents($path_file, $output);

                // Limpiar el buffer de salida
                //ob_end_clean();
            }
            catch(Exception $e) {
                echo "Error al crear el PDF: ". $e->getMessage();
            }
        }

        public function mostrarPDF() {
            // Mostrar el PDF en el navegador o descargarlo según el parámetro $download
            if ($this->download) {
                $this->dompdf->stream($this->filename, ['Attachment' => true]);  // Descargar el archivo
            } else {
                $this->dompdf->stream($this->filename, ['Attachment' => false]); // Mostrar en el navegador
            }
        }

        public function setHtml () {
            // Crear el contenido del PDF
            //$this->html = file_get_contents("plantilla_presupuesto.html");
            // Establecer variables de plantilla
            $utils = new Utils();
            $logo = "https://ochoa.test/assects/img/logo.jpg";

            $this->html = '
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Presupuesto - ' . $this->presu['numero'] . '</title>
                    <script src="/assects/js/script_presup.js"></script>
                </head>
                <body>
                    <div class="container">
                    <div class="header">
                        <div class="logo">
                            <img src="' . $logo . '" alt="Logo Empresa">
                        </div>
                        <div class="details">
                            <p><b>Presupuesto</b><br>Ref.: ' . $this->presu['numero'] . '<br>
                            Fecha presupuesto: ' . $utils->convertirFecha($this->presu['fecha']) . '<br>
                            Fecha fin de validez: ' . $utils->convertirFecha($this->presu['fecha_entrega']) . '</p>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="company-info">
                        <strong>' . $this->empresa['razon'] . '</strong><br>
                        ' . $this->empresa['direccion'] . '<br>
                        ' . $this->empresa['cp'] . ' - ' . $this->empresa['pobla'] . '<br>
                        ' . $this->empresa['email'] . ' | ' . $this->empresa['tel'] . '<br>
                        CIF/NIF: ' . $this->empresa['cif'] . '
                    </div>';

                    $this->html .= '<div class="receptor-info">
                        <strong>' . $this->cliente['name'] . '</strong><br>
                        ' . $this->cliente['email'] . '
                    </div>

                    <div class="clear"></div>

                    <h3>Detalle del presupuesto</h3>
                    <table clase="table-presup">
                        <thead>
                            <tr>
                                <th>Unidades</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Precio Uni.</th>
                                <th>Impuesto</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>;
            ';

            // Detalles de los productos/servicios del presupuesto
            if (isset($this->presudte) && !empty($this->presudte)) {
                $total = 0;
                foreach ($this->presudte as $detalle) {
                    $tipo = ($detalle['tipo'] == 1) ? 'Producto' : 'Servicio';
                    $this->html .= '
                    <tr>
                        <td>' . $detalle['unidades'] . '</td>
                        <td>' . $tipo . '</td>
                        <td>' . $detalle['descripcion'] . '</td>
                        <td>' . $detalle['precio_uni'] . ' €</td>
                        <td>' . $detalle['impuesto'] . ' %</td>
                        <td>' . $detalle['total'] . ' €</td>
                    </tr>';
                    $total += $detalle['total'];
                }
                // Fila de total
                $this->html .= '
                <tr class="total-row">
                    <td colspan="5" align="right">Total:</td>
                    <td>' . number_format($total, 2) . ' €</td>
                </tr>';
            }

            // Cerrar tabla y añadir pie de página
            $this->html .= '
                        </tbody>
                    </table>

                    <div class="footer">
                        Empleado: ' . $this->empleado . '<br>
                        Cliente: ' . $this->cliente['name'] . '
                    </div>
                </div>
            </body>
            </html>';

            /*
            // Presupuestos
            if (isset($this->presu) && !empty($this->presu)) {
                foreach ($this->presu as $key => $value) {
                    $this->html.= '<b>'. $key.': '. $value. '</b><br>';
                }
                $this->html.= '<br><b>Items:</b><br>';
            }
            // Detalles de Presupuesto
            // La tabla
            $this->html .= '
            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Unidades</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Uni.</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
            ';
            // El cuerpo de la tabla de los detalles del Presupuesto
            if (isset($this->presudte) &&!empty($this->presudte)) {
                $total = 0;
                foreach ($this->presudte as $key => $value) {
                    $tipo = (($value['tipo'] == 1) ? 'Producto' : 'Servicio');
                    $this->html.= '
                        <tr>
                            <td>'. $value['unidades'] . '</td>
                            <td>'. $tipo . '</td>
                            <td>'. $value['descripcion'] . '</td>
                            <td>'. $value['precio_uni'] . '</td>
                            <td>'. $value['impuesto'] . '</td>
                            <td>'. $value['total'] . '</td>
                        </tr>
                    ';
                    $total += $value['total'];
                }
                $this->html.= '
                    <tr>
                        <td colspan="5" align="right">Total:</td>
                        <td>'. $total. '</td>
                    </tr>
                ';
            }
            // Cerramos la tabla
            $this->html .= '
                </table>
            ';
            // Cerramos el documento
            $this->html .= '
                    </div>
                </body>
            </html>
            ';
            */
        }

        public function crearPresupuesto() {
            // Crear PDF de forma personalizada
            $this->setFuente('Courier');
            $this->crearPdf($this->html, 'A4', 'portrait', 'presupuestos.pdf', false);
        }

        public function validarPdf () {
            // Validar el PDF
            
            // Ruta completa del archivo PDF
            $path_file = $this->path_pdf . $this->filename;

             // Verificar si el directorio existe
            if (!is_dir($this->path_pdf)) {
                return false;   // El directorio no existe
            }

            // Verificar si el archivo PDF existe
            if (!file_exists($path_file)) {
                return false;   // El archivo PDF no existe
            }

            // Si el directorio y el archivo existen, la validación es exitosa
            return true;
        }
    }