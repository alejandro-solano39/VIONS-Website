<?php
include_once(__DIR__ . '/../config/config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$artistas = [];
$sql = "SELECT portfolios.nombre, portfolios.miniatura, portfolios.categoria_id, category.nombre AS categoria
        FROM portfolios
        INNER JOIN category ON portfolios.categoria_id = category.id
        LIMIT 4";
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
?>
