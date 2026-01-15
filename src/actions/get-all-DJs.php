<?php
include_once(__DIR__ . '/../../config/config.php');

// Habilitar reportes de errores para MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Función para obtener conexión segura a la base de datos
function obtenerConexion()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset("utf8mb4"); // Soporte para caracteres especiales
    return $conn;
}

// Función para obtener todos los DJs con sus categorías
function obtenerDJs($soloActivos = true)
{
    try {
        $conn = obtenerConexion();
        $djs = [];

        $sql = "SELECT 
                    d.id, d.dj_name, d.post_title, d.info, 
                    d.imagen_perfil, d.miniatura, d.slider_images,
                    d.social_links, d.music_release, d.latest_tracks, d.activo, 
                    COALESCE(GROUP_CONCAT(DISTINCT c.id SEPARATOR ','), '') AS categoria_ids,
                    COALESCE(GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', '), '') AS categoria_nombres
                FROM djs_portfolios d
                LEFT JOIN dj_categories dc ON d.id = dc.dj_id
                LEFT JOIN category c ON dc.category_id = c.id";

        // Agregar condición si solo se quieren los DJs activos
        if ($soloActivos) {
            $sql .= " WHERE d.activo = 1";
        }

        $sql .= " GROUP BY d.id";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $row['categoria_ids'] = explode(',', $row['categoria_ids']);
            $row['categoria_nombres'] = explode(', ', $row['categoria_nombres']);
            $djs[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $djs;
    } catch (mysqli_sql_exception $e) {
        error_log("Error en obtenerDJs: " . $e->getMessage());
        return [];
    }
}

// Función para obtener todas las categorías
function obtenerCategorias()
{
    try {
        $conn = obtenerConexion();
        $categorias = [];

        $sql = "SELECT id, nombre FROM category";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $categorias[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $categorias;
    } catch (mysqli_sql_exception $e) {
        // Manejar el error
        error_log("Error en obtenerCategorias: " . $e->getMessage());
        return []; // Devuelve un array vacío en caso de error
    }
}

// Obtener datos y retornarlos
return [
    'obtenerDJs' => obtenerDJs(), // Devuelve los datos de los DJs
    'obtenerCategorias' => obtenerCategorias(), // Devuelve las categorías
];
?>