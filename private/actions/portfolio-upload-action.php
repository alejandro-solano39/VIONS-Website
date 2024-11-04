<?php
include('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['name'];
    $rol = $_POST['role'];
    $anio_experiencia = $_POST['experience_year'];
    $especialidad = $_POST['specialty'];
    $descripcion = $_POST['description'];
    $contacto = $_POST['contact'];
    $ubicacion = $_POST['location'];
    $categoria_id = $_POST['category'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Crear carpeta del portafolio
    $portfolioFolderName = preg_replace('/[^A-Za-z0-9_-]/', '_', $nombre);
    $targetDir = __DIR__ . '/../uploads/' . $portfolioFolderName . '/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    function subirArchivo($inputName, $targetDir) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $fileName = basename($_FILES[$inputName]["name"]);
            $targetFilePath = $targetDir . $fileName;
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                return 'uploads/' . basename($targetDir) . '/' . $fileName;
            }
        }
        return null;
    }

    $imagen_perfil = subirArchivo('profile_image', $targetDir);
    $miniatura = subirArchivo('thumbnail', $targetDir);

    // Procesar imágenes del slider
    $sliderItems = [];
    if (isset($_FILES['slider_images'])) {
        foreach ($_FILES['slider_images']['tmp_name'] as $key => $tmp_name) {
            $fileName = basename($_FILES['slider_images']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;
            if (move_uploaded_file($tmp_name, $targetFilePath)) {
                $sliderItems[] = 'uploads/' . basename($targetDir) . '/' . $fileName;
            }
        }
    }

    // Procesar enlaces de video
    if (!empty($_POST['slider_videos'])) {
        foreach ($_POST['slider_videos'] as $videoUrl) {
            if (!empty($videoUrl)) {
                $sliderItems[] = $videoUrl;  // Añadir enlace de video directamente al array de slider
            }
        }
    }

    $sliderItemsJson = json_encode($sliderItems);

    // Guardar información en la base de datos
    $stmt = $conn->prepare("INSERT INTO portfolios 
                            (categoria_id, nombre, rol, anio_experiencia, especialidad, descripcion, contacto, ubicacion, imagen_perfil, miniatura, slider_images) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssss", $categoria_id, $nombre, $rol, $anio_experiencia, $especialidad, $descripcion, $contacto, $ubicacion, $imagen_perfil, $miniatura, $sliderItemsJson);

    ob_start();

    if ($stmt->execute()) {
        ob_end_clean();
        header("Location: success.php");
        exit();
    } else {
        echo "Error al guardar los datos: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>
