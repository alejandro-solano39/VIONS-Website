<?php
include_once(__DIR__ . '/../config/config.php');

function obtenerConexion()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

// Función para obtener todos los DJs
function obtenerDJs()
{
    $conn = obtenerConexion();
    $djs = [];
    
    $sql = "SELECT djs_portfolios.id, djs_portfolios.dj_name, djs_portfolios.post_title, djs_portfolios.info, 
            djs_portfolios.imagen_perfil, djs_portfolios.miniatura, djs_portfolios.slider_images, 
            djs_portfolios.social_links, djs_portfolios.music_release, djs_portfolios.latest_tracks, 
            djs_portfolios.categoria_id, djs_portfolios.activo, category.nombre AS categoria_nombre
            FROM djs_portfolios
            INNER JOIN category ON djs_portfolios.categoria_id = category.id";
    
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $djs[] = $row;
        }
        $result->free();
    } else {
        die("Error en la consulta: " . $conn->error);
    }

    $conn->close();
    return $djs;
}

// Función para obtener los DJs con sus categorías
function obtenerDJsConCategorias()
{
    $conn = obtenerConexion();
    $djs = [];
    
    $sql = "SELECT djs_portfolios.*, category.nombre AS categoria_nombre 
            FROM djs_portfolios 
            INNER JOIN category ON djs_portfolios.categoria_id = category.id";

    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $djs[] = $row;
        }
        $result->free();
    } else {
        die("Error en la consulta: " . $conn->error);
    }

    $conn->close();
    return $djs;
}

// Función para obtener el nombre del último DJ basado en 'created_at'
function obtenerUltimoDJ()
{
    $conn = obtenerConexion();

    $sql = "SELECT dj_name, created_at FROM djs_portfolios ORDER BY created_at DESC LIMIT 1";
    if ($result = $conn->query($sql)) {
        $ultimoDJ = $result->fetch_assoc();
        $conn->close();
        return $ultimoDJ ? $ultimoDJ['dj_name'] : null;
    } else {
        die("Error en la consulta: " . $conn->error);
    }
}

// Función para cambiar el estado de un DJ (activo/inactivo)
function cambiarEstadoDJ($id)
{
    $conn = obtenerConexion();

    $sql = "SELECT activo FROM djs_portfolios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $estadoActual = $row['activo'];

        $nuevoEstado = $estadoActual ? 0 : 1;

        // Actualizar el estado
        $sqlUpdate = "UPDATE djs_portfolios SET activo = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('ii', $nuevoEstado, $id);

        if ($stmtUpdate->execute()) {
            $stmtUpdate->close();
            $conn->close();
            return [
                'success' => true,
                'message' => 'El estado del DJ ha sido actualizado correctamente.',
                'new_status' => $nuevoEstado
            ];
        } else {
            $stmtUpdate->close();
            $conn->close();
            return [
                'success' => false,
                'message' => 'No se pudo actualizar el estado del DJ.'
            ];
        }
    } else {
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'No se encontró el DJ especificado.'
        ];
    }
}

// Obtener datos y retornarlos
$djs = obtenerDJs();
$nombreUltimoDJ = obtenerUltimoDJ();

return $djs;
?>