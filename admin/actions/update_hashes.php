<?php
include('../../config/config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Reemplaza el ID del usuario y la nueva contraseña
$userId = 2;
$newPassword = '123$Vions';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param('si', $hashedPassword, $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Contraseña actualizada correctamente.";
} else {
    echo "Error al actualizar la contraseña.";
}

$stmt->close();
$conn->close();
?>
