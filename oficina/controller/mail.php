<?php
    // Configuraciones de namespace del email
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mail {
        public $user;
        public $to;
        public $subject;
        public $message;
        public $from = 'griaserhii@gmail.com';
        public $cco;
        public $cc;
        private $pass = "xqji cyxt onqv srsd"; // password de google.
        private $mail;
        private $attachment;

        public function __construct($to, $user, $template = '1')
        {
            $this->to = $to;
            $this->user = $user;
            $this->mail = new PHPMailer(true);
            if ($template == '1') {
                $this->ConstruirMail();
                $this->ConfigurarMail();
                $this->EnviarMail();
            } else {
                switch ($template) {
                    case 'Presu':
                        $this->ConfigurarMail();
                        break;
                    default:
                        $this->ConstruirMail();
                        $this->ConfigurarMail();
                        $this->EnviarMail();
                        break;
                }
            }
        }

        public function ConstruirMailPresu($num, $fecha, $user) {
            $this->subject = "Registro en aplicacion MVC";
            $this->mail->Subject = $this->subject;

            ob_start();
            include(__DIR__ . '/../views/presupuesto/mail_templates.php');
            $this->message = ob_get_clean();

            $this->mail->Body = $this->message;
            $this->attachment = __DIR__ . '/../../uploade/presu-pdf/' . $num . '.pdf';

            $this->mail->addAttachment($this->attachment);
            $this->EnviarMail();

        }

        private function ConstruirMail()
        {
            $this->subject = "Registro en aplicacion MVC";
            $this->message = '
            <html>
                <head>
                    <title>Bienvenido a nuestra App!!!</title>
                    <p>Gracias por registarse, para seguir con el proceso clicke el siguiente enlace</p>
                </head>
                <body style="background-color:blue; color:white">
                    <p>Su nombre de usuario es: ' . $this->user . '</p>
                    <a href="' . BASE_URL . '/index.php?id=' . base64_encode($this->user) . '&reg='.base64_encode('REG_APP_MAIL').'">REGISTRARSE</a>
                    <p>Atentamente, el equipo de MVC Aplication.</p>
                </body>
            </html>';
        }

        private function ConfigurarMail()
        {
            try {
                // Configuración del servidor SMTP
                $this->mail->isSMTP();
                $this->mail->Host = 'smtp.gmail.com'; // Especifica el servidor SMTP
                $this->mail->SMTPAuth = true;
                $this->mail->Username = 'griaserhii@gmail.com'; // Tu correo Gmail
                $this->mail->Password = $this->pass; // Tu contraseña de Gmail o App Password
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $this->mail->Port = 587;

                // Remitente y destinatario
                $this->mail->setFrom('griaserhii@gmail.com', 'Direccion');
                $this->mail->addAddress($this->to);

                // Contenido del correo
                $this->mail->isHTML(true);
                $this->mail->Subject = $this->subject;
                $this->mail->Body = $this->message;
            } catch (Exception $e) {
                echo "Error al configurar el correo: {$this->mail->ErrorInfo}";
            }
        }

        private function ConfigurarMailPresu()
        {
            try {
                // Configuración del servidor SMTP
                $this->mail->isSMTP();
                $this->mail->Host = 'smtp.gmail.com'; // Especifica el servidor SMTP
                $this->mail->SMTPAuth = true;
                $this->mail->Username = 'griaserhii@gmail.com'; // Tu correo Gmail
                $this->mail->Password = $this->pass; // Tu contraseña de Gmail o App Password
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $this->mail->Port = 587;

                // Remitente y destinatario
                $this->mail->setFrom('griaserhii@gmail.com', 'Direccion');
                $this->mail->addAddress($this->to);

                // Contenido del correo
                $this->mail->isHTML(true);

                // Enviamos una copia a nosotros mismos
                $this->mail->addCC('griaserhii@gmail.com');
                /*
                $this->mail->Subject = $this->subject;
                $this->mail->Body = $this->message;
                */
            } catch (Exception $e) {
                echo "Error al configurar el correo: {$this->mail->ErrorInfo}";
            }
        }

        private function EnviarMail()
        {
            try {
                $this->mail->send();
                return true;
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$this->mail->ErrorInfo}";
                return false;
            }
        }

        public function RecibirMail()
        {
            // Implementar método si es necesario
        }

        public function ResponderMail()
        {
            // Implementar método si es necesario
        }

        private function FirmarMail()
        {
            // Implementar método si es necesario
        }
    }
?>