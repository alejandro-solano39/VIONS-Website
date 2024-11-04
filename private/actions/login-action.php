<?php
// Incluir la configuración de la base de datos
include('./config/config.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para verificar el email y la contraseña usando la función PASSWORD() de MySQL
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = PASSWORD(?)");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificar si se encontró el usuario
    if ($user) {
        echo "Login exitoso";
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../private/dashboard/index.php");
    } else {
        echo "Credenciales incorrectas";
    }

    $stmt->close();
    $conn->close();
}
?>
