<?php
include_once('../../config/config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Obtener la ID del portafolio

    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Buscar el portafolio de DJ
    $sql = "SELECT dj_name FROM djs_portfolios WHERE id = ?"; // Cambiar 'nombre' por 'dj_name'
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta falló
    if ($stmt === false) {
        die("Error al preparar la consulta SQL: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $djPortfolio = $result->fetch_assoc();

    if ($djPortfolio) {
        // Ruta de la carpeta de archivos del portafolio de DJ
        $portfolioFolder = __DIR__ . '/../uploads/' . preg_replace('/[^A-Za-z0-9_-]/', '_', $djPortfolio['dj_name']) . '/'; // Cambiar 'nombre' por 'dj_name'

        // Eliminar todos los archivos en la carpeta
        if (is_dir($portfolioFolder)) {
            $files = glob($portfolioFolder . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Eliminar archivo
                }
            }
            rmdir($portfolioFolder); // Eliminar carpeta
        }

        // Eliminar el registro de la base de datos
        $deleteSql = "DELETE FROM djs_portfolios WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);

        // Verificar si la preparación de la consulta falló
        if ($deleteStmt === false) {
            die("Error al preparar la consulta SQL para eliminar: " . $conn->error);
        }

        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Portafolio de DJ y archivos eliminados exitosamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el portafolio de DJ de la base de datos."]);
        }

        $deleteStmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Portafolio de DJ no encontrado."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "ID no proporcionado o método incorrecto."]);
}

