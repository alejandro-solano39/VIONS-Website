<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

$mail = new PHPMailer(true);

try {

    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@vions.com.mx';
    $mail->Password = '123$Vions';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Validar datos del formulario
    $nombre = $_POST['dzName'] ?? 'Nombre no especificado';
    $categoria = $_POST['formCategory'] ?? 'Other';
    $mensaje = $_POST['dzMessage'] ?? 'No se proporcionó mensaje';
    $correo_usuario = $_POST['dzEmail'] ?? 'correo@ejemplo.com';

    // Obtener el nombre del artista seleccionado
    $artistaSeleccionado = 'No artist selected';
    if (isset($_POST['formCategory']) && is_numeric($_POST['formCategory'])) {
        $artistas = include_once('../../src/actions/get-artists.php');
        foreach ($artistas as $artista) {
            if ($artista['id'] == $_POST['formCategory']) {
                $artistaSeleccionado = $artista['nombre'];
                $categoria = $artista['nombre']; // Sobrescribir la categoría con el nombre del artista
                break;
            }
        }
    }

    // Configuración de mensajes automáticos
    $mensajesPorCategoria = [
        'Collaborations' => [
            'subject' => 'Thank you for contacting VIONS - Collaborations',
            'body' => "Thank you for your interest in collaborating with us! We are reviewing your request submitted under the Collaborations category. Our team will reach out to you soon to discuss how we can work together to create something amazing.\n\nAt VIONS, we believe in the power of partnerships to drive innovative ideas. If you’d like to add more information or details to your request, feel free to email us."
        ],
        'Press' => [
            'subject' => 'Thank you for contacting VIONS - Press',
            'body' => "Thank you for your interest in VIONS. We’ve received your message under the Press category, and we’re excited to explore how we can collaborate with you to share our vision and projects.\n\nOur team will get in touch with you as soon as possible. In the meantime, we invite you to visit our website or social media platforms to learn more about VIONS."
        ],
        'Visual Marketing' => [
            'subject' => 'Thank you for contacting VIONS - Visual Marketing',
            'body' => "Thank you for reaching out to us in the Visual Marketing category. Our team of designers and creatives is reviewing your message and will contact you soon to discuss how we can assist you with your visual needs.\n\nAt VIONS, we specialize in 3D graphic design and branding for events and global businesses. We’re excited to work with you!"
        ],

        'Other' => [
            'subject' => 'Thank you for contacting VIONS',
            'body' => "Thank you for reaching out. We’ve received your message under the Other category, and our team will get in touch with you soon to review how we can assist you with your specific needs.\n\nAt VIONS, we are committed to providing innovative and tailored solutions for each client. If you’d like to add more details to your request, feel free to reply to this email."
        ]
    ];

    $emailSubjectUsuario = $mensajesPorCategoria[$categoria]['subject'] ?? 'Thank you for contacting VIONS';

    $emailBodyUsuario = $mensajesPorCategoria[$categoria]['body'] ?? "We’ve received your message. Thank you for reaching out.";
    $emailBodyUsuario .= "\n\nCategory selected: $categoria.";

    if ($artistaSeleccionado !== 'No artist selected') {
        $emailBodyUsuario .= "\n\nYou mentioned interest in the artist: $artistaSeleccionado.";
    }

    // Plantilla HTML para el usuario
    $templateUsuario = "
    <html lang='en'>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .email-container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); overflow: hidden; }
            .header { background-color: #00002D; color: #ffffff; text-align: center; padding: 20px; }
            .header h1 { margin: 0; font-size: 24px; }
            .body { padding: 20px; color: #333333; }
            .body p { margin: 0 0 15px; line-height: 1.6; }
            .body strong { color: #00002D; }
            .cta-button { display: inline-block; margin: 20px 0; padding: 10px 20px; background-color: #00002D; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 4px; }
            .footer { background-color: #f4f4f4; color: #777777; text-align: center; padding: 15px; font-size: 14px; }
            .footer a { color: #00002D; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header'>
                <h1>VIONS</h1>
            </div>
            <div class='body'> 
                <p>Hello, <strong>$nombre</strong>,</p>
                <p>$emailBodyUsuario</p>
                <p>Your message:</p>
                <blockquote style='border-left: 4px solid #00002D; padding-left: 10px;'>$mensaje</blockquote>
                <p>We will get in touch with you as soon as possible. In the meantime, feel free to visit our website.</p>
                <a href='https://www.vions.com.mx' class='cta-button'>Visit our website</a>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " VIONS. All rights reserved.</p>
                <p>Need assistance? Write to us at <a href='mailto:info@vions.com.mx'>info@vions.com.mx</a></p>
            </div>
        </div>
    </body>
    </html>";

    // Plantilla HTML para el administrador de VIONS
    $templateVions = "
    <html lang='en'>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 20px auto; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; }
            .container h2 { color: #00002D; }
            .container p { margin: 10px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>New Contact Request</h2>
            <p><strong>Name:</strong> $nombre</p>
            <p><strong>Email:</strong> $correo_usuario</p>
            <p><strong>Category:</strong> $categoria</p>
            <p><strong>Artist:</strong> $artistaSeleccionado</p>
            <p><strong>Message:</strong></p>
            <blockquote>$mensaje</blockquote>
        </div>
    </body>
    </html>";

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