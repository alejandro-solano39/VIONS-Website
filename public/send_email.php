<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'info@vions.com.mx';
    $mail->Password = '123$Vions'; // Escapar caracteres especiales si es necesario
    $mail->setFrom('info@vions.com.mx', 'VIONS');
    $mail->addReplyTo('info@vions.com.mx', 'VIONS');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['name'], $_POST['message'])) {
        $recipientEmail = $_POST['email'];
        $recipientName = $_POST['name'];
        $message = nl2br(htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8'));

        // Validar el correo electrónico
        if (filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($recipientEmail, $recipientName); // Correo del usuario que llena el formulario
        } else {
            throw new Exception('Invalid recipient email address.');
        }

        // Agregar el correo de VIONS como destinatario también
        $mail->addAddress('info@vions.com.mx', 'VIONS');

        // Configuración para evitar spam
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for contacting VIONS!';
        $mail->CharSet = 'UTF-8';

        // Plantilla HTML para el correo
        $mail->Body = "
            <html>
            <head>
                <title>Contact Form Submission</title>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
                    .container { background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
                    h2 { color: #333; }
                    p { font-size: 16px; color: #555; }
                    .footer { margin-top: 20px; font-size: 14px; color: #888; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Thank you for contacting VIONS!</h2>
                    <p><strong>Name:</strong> {$recipientName}</p>
                    <p><strong>Email:</strong> {$recipientEmail}</p>
                    <p><strong>Message:</strong><br> {$message}</p>
                    <p class='footer'>We will get back to you as soon as possible.</p>
                </div>
            </body>
            </html>
        ";

        if ($mail->send()) {
            echo 'Message sent successfully!';
        } else {
            echo 'Error: Message could not be sent.';
        }
    } else {
        throw new Exception('Please fill out all required fields.');
    }
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}";
}

$artistas = include('../actions/get-artists.php');

// Filtrar artistas activos
$artistas = array_filter($artistas, function ($artista) {
    return isset($artista['activo']) && $artista['activo'] == 1;
});
?>
