<?php
// Configuración de la base de datos para Laragon
if (!defined('DB_HOST')) {
    define('DB_HOST', '127.0.0.1'); // Evita problemas de socket
}

if (!defined('DB_USER')) {
    define('DB_USER', 'root'); // Por defecto en Laragon
}

if (!defined('DB_PASS')) {
    define('DB_PASS', ''); // Sin contraseña por defecto
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'vions_db');
}

// Crear una conexión PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=3306;dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a MySQL desde Laragon";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
