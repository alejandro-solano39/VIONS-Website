<?php
include('../../config/config.php');

$id = isset($_POST['id']) ? intval($_POST['id']) : null;

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

    // Recuperar datos existentes si es una edición
    $existingData = [];
    if ($id) {
        $result = $conn->query("SELECT * FROM portfolios WHERE id = $id");
        if ($result && $result->num_rows > 0) {
            $existingData = $result->fetch_assoc();
        }
    }

    // Crear carpeta si no existe
    function crearCarpeta($nombre)
    {
        $nombreCarpeta = preg_replace('/[^A-Za-z0-9_-]/', '_', $nombre);
        $ruta = __DIR__ . '/../uploads/' . $nombreCarpeta . '/';
        if (!is_dir($ruta)) {
            mkdir($ruta, 0755, true);
        }
        return $ruta;
    }

    $targetDir = crearCarpeta($nombre);

    // Procesar imagen de perfil
    $imagenPerfil = $existingData['imagen_perfil'] ?? null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $profileFileName = basename($_FILES['profile_image']['name']);
        $profileTargetPath = $targetDir . $profileFileName;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $profileTargetPath)) {
            $imagenPerfil = 'uploads/' . basename($targetDir) . '/' . $profileFileName;
        }
    }

    // Procesar miniatura
    $miniatura = $existingData['miniatura'] ?? null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $thumbnailFileName = basename($_FILES['thumbnail']['name']);
        $thumbnailTargetPath = $targetDir . $thumbnailFileName;
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailTargetPath)) {
            $miniatura = 'uploads/' . basename($targetDir) . '/' . $thumbnailFileName;
        }
    }

    // Procesar imágenes del slider
    $existingSliderImages = json_decode($existingData['slider_images'] ?? '[]', true);
    $newSliderImages = [];
    if (isset($_FILES['slider_images'])) {
        foreach ($_FILES['slider_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['slider_images']['error'][$key] == 0) {
                $fileName = basename($_FILES['slider_images']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    $newSliderImages[] = 'uploads/' . basename($targetDir) . '/' . $fileName;
                }
            }
        }
    }

    $sliderImagesFromForm = isset($_POST['existing_slider_images']) 
        ? (is_array($_POST['existing_slider_images']) 
            ? $_POST['existing_slider_images'] 
            : json_decode($_POST['existing_slider_images'], true)) 
        : [];

    $sliderImagesFinal = array_merge($sliderImagesFromForm, $newSliderImages);
    $imagesToDelete = array_diff($existingSliderImages, $sliderImagesFromForm);
    foreach ($imagesToDelete as $image) {
        $imagePath = __DIR__ . '/../' . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $key = array_search($image, $sliderImagesFinal);
        if ($key !== false) {
            unset($sliderImagesFinal[$key]);
        }
    }

    $sliderItemsJson = json_encode(array_values($sliderImagesFinal));

    // Insertar o actualizar en la base de datos
    if ($id) {
        $stmt = $conn->prepare("UPDATE portfolios SET categoria_id=?, nombre=?, rol=?, anio_experiencia=?, especialidad=?, descripcion=?, contacto=?, ubicacion=?, imagen_perfil=?, miniatura=?, slider_images=? WHERE id=?");
        $stmt->bind_param("issssssssssi", $categoria_id, $nombre, $rol, $anio_experiencia, $especialidad, $descripcion, $contacto, $ubicacion, $imagenPerfil, $miniatura, $sliderItemsJson, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO portfolios (categoria_id, nombre, rol, anio_experiencia, especialidad, descripcion, contacto, ubicacion, imagen_perfil, miniatura, slider_images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssss", $categoria_id, $nombre, $rol, $anio_experiencia, $especialidad, $descripcion, $contacto, $ubicacion, $imagenPerfil, $miniatura, $sliderItemsJson);
    }

    if ($stmt->execute()) {
        echo "Datos guardados exitosamente.";
        header("Location: ../dashboard/index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
