<?php
include_once(__DIR__ . '/../config/config.php');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT         => true, 
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    $sql = "SELECT 
                p.id, 
                p.nombre, 
                p.miniatura, 
                p.categoria_id, 
                p.activo, 
                c.nombre AS categoria
            FROM 
                portfolios p
            INNER JOIN 
                category c 
            ON 
                p.categoria_id = c.id
            WHERE 
                p.activo = 1
            ORDER BY 
                p.fecha_registro";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $artistas = $stmt->fetchAll();

    if (empty($artistas)) {
        echo "No se encontraron portafolios.";
    }

    return $artistas;
} catch (PDOException $e) {
    die("Error en la conexión o consulta: " . $e->getMessage());
}
