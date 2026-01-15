<?php
include_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    $sql = "SELECT nombre FROM portfolios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $portfolio = $result->fetch_assoc();

    if ($portfolio) {
        $portfolioFolder = __DIR__ . '/../uploads/' . preg_replace('/[^A-Za-z0-9_-]/', '_', $portfolio['nombre']) . '/';

        // Eliminar todos los archivos en la carpeta
        if (is_dir($portfolioFolder)) {
            $files = glob($portfolioFolder . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($portfolioFolder);
        }

        // Eliminar el registro de la base de datos
        $deleteSql = "DELETE FROM portfolios WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Portafolio y archivos eliminados exitosamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el portafolio de la base de datos."]);
        }

        $deleteStmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Portafolio no encontrado."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "ID no proporcionado o método incorrecto."]);
}
