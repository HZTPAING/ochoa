<?php
    $htmlBodyMail = '<html>

        <head>
            <title>Envío de Presupuesto</title>
        </head>

        <body style="font-family: Arial, sans-serif; color: #333;">
            <h2 style="color: #007BFF;">¡Hola, ' . $user . '!</h2>
            <p>Te enviamos el presupuesto solicitado con el número <strong>' . $num . '</strong> de la fecha <strong>' . $fecha . '.</p>
            <p>Adjunto encontrarás el PDF con todos los detalles del presupuesto. Si tienes alguna duda o necesitas más información, no dudes en contactarnos.</p>
            <p style="margin-top: 20px;">Atentamente,</p>
            <p>El equipo de <strong>Tu Empresa</strong></p>
            <hr />
            <p style="font-size: 12px; color: #666;">Este correo fue generado automáticamente. Por favor, no respondas directamente a este mensaje.</p>
        </body>

    </html>';
    echo $htmlBodyMail;
?>