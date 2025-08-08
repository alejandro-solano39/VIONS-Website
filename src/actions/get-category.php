<?php
include_once(__DIR__ . '/../../config/config.php');

function connectDatabase() {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli("p:" . DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    }
    return $conn;
}

// Función única para obtener categorías por grupo
function getCategoriesByGroup($categoryGroup) {
    $conn = connectDatabase();
    $query = "SELECT id, nombre FROM category WHERE category_group = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $categoryGroup);
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    $stmt->close();
    return $categories;
}

// Retornar las funciones directamente
return [
    'getDesignCategories' => function() {
        return getCategoriesByGroup('design');
    },
    'getMusicCategories' => function() {
        return getCategoriesByGroup('music');
    }
];
?>