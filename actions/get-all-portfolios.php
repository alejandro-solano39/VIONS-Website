<?php
include_once(__DIR__ . '/../config/config.php');

function obtenerArtistas() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $artistas = [];
    $sql = "SELECT portfolios.id, portfolios.nombre, portfolios.rol, portfolios.descripcion, portfolios.contacto, portfolios.miniatura, portfolios.categoria_id, category.nombre AS categoria
            FROM portfolios
            INNER JOIN category ON portfolios.categoria_id = category.id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $artistas[] = $row;
        }
    } else {
        echo "No se encontraron portafolios.";
    }

    $conn->close();
    return $artistas;
}

return obtenerArtistas(); // Esta línea asegura que el archivo devuelva el array de artistas
