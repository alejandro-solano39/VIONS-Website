<?php
include_once(__DIR__ . '/../../config/config.php');

if (isset($_GET['id'])) {
    // Validar y sanitizar el parámetro 'id'
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        echo "ID de portafolio inválido.";
        exit();
    }

    try {
        // Configuración de conexión PDO
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
        ];
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, $options);
        $stmt = $conn->prepare("SELECT * FROM portfolios WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $portafolio = $stmt->fetch();

        if (!$portafolio) {
            echo "Portafolio no encontrado.";
            exit();
        }

        $stmt = null;
        $conn = null;
    } catch (PDOException $e) {
        error_log("Error en la base de datos: " . $e->getMessage());
        echo "Error al cargar el portafolio.";
        exit();
    }
} else {
    echo "ID de portafolio no proporcionado.";
    exit();
}