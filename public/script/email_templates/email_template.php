<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #5A31F4; /* VIONS main purple */
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .body {
            padding: 20px;
            color: #333333;
        }
        .body p {
            margin: 0 0 15px;
            line-height: 1.6;
        }
        .body strong {
            color: #5A31F4; /* Accent color */
        }
        .cta-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #5A31F4; /* Button color */
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
        }
        .footer {
            background-color: #f4f4f4;
            color: #777777;
            text-align: center;
            padding: 15px;
            font-size: 14px;
        }
        .footer a {
            color: #5A31F4;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>VIONS</h1>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Hola, <strong>{Nombre}</strong>,</p>
            <p>
                Hemos recibido tu mensaje en la categoría <strong>{Categoría}</strong>.
                Gracias por confiar en nosotros para llevar tu visión al siguiente nivel.
            </p>
            <p>Tu mensaje:</p>
            <blockquote style="border-left: 4px solid #5A31F4; padding-left: 10px; margin: 10px 0;">
                {Mensaje}
            </blockquote>
            <p>
                Nos pondremos en contacto contigo lo antes posible. Mientras tanto, no dudes en visitar nuestro sitio web.
            </p>
            <a href="https://www.vions.com.mx" class="cta-button">Visitar nuestro sitio</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 VIONS. Todos los derechos reservados.</p>
            <p>
                ¿Necesitas ayuda? Escríbenos a 
                <a href="mailto:info@vions.com.mx">info@vions.com.mx</a>
            </p>
        </div>
    </div>
</body>
</html>
