<?php
include_once(__DIR__ . '/../../config/config.php');

function obtenerConexion()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

// Función para obtener todos los artistas
function obtenerArtistas()
{
    $conn = obtenerConexion();
    $artistas = [];
    
    $sql = "SELECT portfolios.id, portfolios.nombre, portfolios.rol, portfolios.descripcion, 
            portfolios.imagen_perfil, portfolios.contacto, portfolios.miniatura, 
            portfolios.categoria_id, portfolios.activo, category.nombre AS categoria_nombre
            FROM portfolios
            INNER JOIN category ON portfolios.categoria_id = category.id";
    
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $artistas[] = $row;
        }
        $result->free();
    } else {
        die("Error en la consulta: " . $conn->error);
    }

    $conn->close();
    return $artistas;
}

// Función para obtener los portafolios con sus categorías
function obtenerPortafoliosConCategorias()
{
    $conn = obtenerConexion();
    $artistas = [];
    
    $sql = "SELECT portfolios.*, categories.nombre AS categoria_nombre 
            FROM portfolios 
            INNER JOIN categories ON portfolios.categoria_id = categories.id";

    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $artistas[] = $row;
        }
        $result->free();
    } else {
        die("Error en la consulta: " . $conn->error);
    }

    $conn->close();
    return $artistas;
}

// Función para obtener el nombre del último portafolio basado en 'fecha_registro'
function obtenerUltimoPortafolio()
{
    $conn = obtenerConexion();

    $sql = "SELECT nombre, fecha_registro FROM portfolios ORDER BY fecha_registro DESC LIMIT 1";
    if ($result = $conn->query($sql)) {
        $ultimoPortafolio = $result->fetch_assoc();
        $conn->close();
        return $ultimoPortafolio ? $ultimoPortafolio['nombre'] : null;
    } else {
        die("Error en la consulta: " . $conn->error);
    }
}

// Función para cambiar el estado de un portafolio (activo/inactivo)
function cambiarEstadoPortafolio($id)
{
    $conn = obtenerConexion();

    $sql = "SELECT activo FROM portfolios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $estadoActual = $row['activo'];

        $nuevoEstado = $estadoActual ? 0 : 1;

        // Actualizar el estado
        $sqlUpdate = "UPDATE portfolios SET activo = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('ii', $nuevoEstado, $id);

        if ($stmtUpdate->execute()) {
            $stmtUpdate->close();
            $conn->close();
            return [
                'success' => true,
                'message' => 'El estado del portafolio ha sido actualizado correctamente.',
                'new_status' => $nuevoEstado
            ];
        } else {
            $stmtUpdate->close();
            $conn->close();
            return [
                'success' => false,
                'message' => 'No se pudo actualizar el estado del portafolio.'
            ];
        }
    } else {
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'No se encontró el portafolio especificado.'
        ];
    }
}

$artistas = obtenerArtistas();
$nombreUltimoPortafolio = obtenerUltimoPortafolio();

return $artistas;
?>
