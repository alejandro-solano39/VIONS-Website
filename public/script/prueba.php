<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Zoho Mail
    $mail->isSMTP();
    $mail->Host = 'smtp.zoho.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@vions.com.mx'; // Tu correo en Zoho
    $mail->Password = 'UiL.a39DccW2hp5'; // Contraseña o clave de aplicación de Zoho
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Validar datos del formulario
    $nombre = $_POST['dzName'] ?? 'Nombre no especificado';
    $categoria = $_POST['formCategory'] ?? 'Other';
    $mensaje = $_POST['dzMessage'] ?? 'No se proporcionó mensaje';
    $correo_usuario = $_POST['dzEmail'] ?? 'correo@ejemplo.com';

    // Configuración de mensajes automáticos por categoría
    $mensajesPorCategoria = [
        'Collaborations' => [
            'subject' => 'Thank you for contacting VIONS - Collaborations',
            'body' => "We are reviewing your request under Collaborations. Our team will contact you soon."
        ],
        'Press' => [
            'subject' => 'Thank you for contacting VIONS - Press',
            'body' => "We’ve received your message under Press and will be in touch soon."
        ],
        'Visual Marketing' => [
            'subject' => 'Thank you for contacting VIONS - Visual Marketing',
            'body' => "Our team is reviewing your request for Visual Marketing and will contact you shortly."
        ],
        'Other' => [
            'subject' => 'Thank you for contacting VIONS',
            'body' => "We’ve received your message and will review it as soon as possible."
        ]
    ];

    $emailSubjectUsuario = $mensajesPorCategoria[$categoria]['subject'] ?? 'Thank you for contacting VIONS';
    $emailBodyUsuario = $mensajesPorCategoria[$categoria]['body'] ?? "Thank you for reaching out.";

    // Plantilla HTML para el usuario
    $templateUsuario = "<html><body><h1>VIONS</h1><p>Hello, <strong>$nombre</strong>,</p><p>$emailBodyUsuario</p></body></html>";

    // Plantilla HTML para el administrador de VIONS
    $templateVions = "<html><body><h2>New Contact Request</h2><p><strong>Name:</strong> $nombre</p><p><strong>Email:</strong> $correo_usuario</p><p><strong>Category:</strong> $categoria</p><p><strong>Message:</strong> $mensaje</p></body></html>";

    // Enviar correo al usuario
    $mail->setFrom('info@vions.com.mx', 'VIONS');
    $mail->addAddress($correo_usuario, $nombre);
    $mail->isHTML(true);
    $mail->Subject = $emailSubjectUsuario;
    $mail->Body = $templateUsuario;
    $mail->send();

    // Enviar correo a VIONS
    $mail->clearAddresses();
    $mail->addAddress('info@vions.com.mx', 'VIONS');
    $mail->Subject = "New contact request from $nombre";
    $mail->Body = $templateVions;
    $mail->send();

    // Redirigir con éxito
    header("Location: ../contact-us.php?status=success");
    exit();
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}";
}
?>
