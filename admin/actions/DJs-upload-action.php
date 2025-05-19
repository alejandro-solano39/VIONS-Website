<?php
include('../../config/config.php');

// Establecer conexión a la base de datos al inicio
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = isset($_POST['id']) ? intval($_POST['id']) : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar datos del formulario
    $dj_name = $_POST['dj_name'];
    $post_title = $_POST['post_title'];
    $info = $_POST['info'];
    $custom_text = $_POST['custom_text'] ?? ''; // Nuevo campo agregado
    $social_links = isset($_POST['social_links']) ? array_filter($_POST['social_links']) : [];
    $social_links_json = json_encode($social_links);
    $music_release = isset($_POST['music_release']) ? array_filter($_POST['music_release']) : [];
    $music_release_json = json_encode($music_release);
    $categoria_ids = isset($_POST['category']) ? $_POST['category'] : [];
    $latest_tracks = isset($_POST['latest_tracks']) ? array_filter($_POST['latest_tracks']) : [];
    $latest_tracks_json = json_encode($latest_tracks);

    // Recuperar datos existentes si es una edición
    $existingData = [];
    if ($id) {
        $stmt = $conn->prepare("SELECT imagen_perfil, miniatura, cover_image, slider_images FROM djs_portfolios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $existingData = $result->fetch_assoc();
        }
        $stmt->close();
    }

    // Función para crear la carpeta del DJ
    function crearCarpeta($nombre) {
        $nombreCarpeta = preg_replace('/[^A-Za-z0-9_-]/', '_', $nombre);
        $ruta = __DIR__ . '/../uploads/' . $nombreCarpeta . '/';
        if (!is_dir($ruta)) {
            mkdir($ruta, 0755, true);
        }
        return $ruta;
    }

    // Crear carpeta si no existe
    $targetDir = crearCarpeta($dj_name);

    // Imagen de perfil
    $imagenPerfil = $existingData['imagen_perfil'] ?? null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $profileFileName = basename($_FILES['profile_image']['name']);
        $profileTargetPath = $targetDir . $profileFileName;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $profileTargetPath)) {
            $imagenPerfil = 'uploads/' . basename($targetDir) . '/' . $profileFileName;
        }
    }

    // Miniatura
    $miniatura = $existingData['miniatura'] ?? null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $thumbnailFileName = basename($_FILES['thumbnail']['name']);
        $thumbnailTargetPath = $targetDir . $thumbnailFileName;
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailTargetPath)) {
            $miniatura = 'uploads/' . basename($targetDir) . '/' . $thumbnailFileName;
        }
    }

    // Imagen de portada
    $coverImage = $existingData['cover_image'] ?? null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $coverFileName = basename($_FILES['cover_image']['name']);
        $coverTargetPath = $targetDir . $coverFileName;
        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $coverTargetPath)) {
            $coverImage = 'uploads/' . basename($targetDir) . '/' . $coverFileName;
        }
    }

    // Imágenes del slider existentes
    $existingSliderImages = [];
    if ($id) {
        $stmt = $conn->prepare("SELECT slider_images FROM djs_portfolios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $sliderImagesFromDb = $result->fetch_assoc()['slider_images'];
            
            if (is_string($sliderImagesFromDb)) {
                $existingSliderImages = json_decode($sliderImagesFromDb, true) ?? [];
            } elseif (is_array($sliderImagesFromDb)) {
                $existingSliderImages = $sliderImagesFromDb;
            }
        }
        $stmt->close();
    }

    // Imágenes eliminadas enviadas desde el formulario
    $sliderImagesFromForm = [];
    if (isset($_POST['existing_slider_images'])) {
        if (is_string($_POST['existing_slider_images'])) {
            $sliderImagesFromForm = json_decode($_POST['existing_slider_images'], true) ?? [];
        } elseif (is_array($_POST['existing_slider_images'])) {
            $sliderImagesFromForm = $_POST['existing_slider_images'];
        }
    }

    // Determinar imágenes a eliminar
    $imagesToDelete = array_diff($existingSliderImages, $sliderImagesFromForm);
    foreach ($imagesToDelete as $image) {
        $imagePath = __DIR__ . '/../' . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Procesar nuevas imágenes del slider
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

    // Actualizar lista final de imágenes del slider
    $finalSliderImages = array_merge($sliderImagesFromForm, $newSliderImages);
    $sliderImagesJson = json_encode(array_values($finalSliderImages));

    // Insertar o actualizar en la base de datos
    if ($id) {
        $stmt = $conn->prepare("UPDATE djs_portfolios 
            SET dj_name=?, post_title=?, info=?, custom_text=?, social_links=?, music_release=?, latest_tracks=?, slider_images=?, imagen_perfil=?, miniatura=?, cover_image=? 
            WHERE id=?");
        $stmt->bind_param("sssssssssssi", $dj_name, $post_title, $info, $custom_text, $social_links_json, $music_release_json, $latest_tracks_json, $sliderImagesJson, $imagenPerfil, $miniatura, $coverImage, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO djs_portfolios 
            (dj_name, post_title, info, custom_text, social_links, music_release, latest_tracks, slider_images, imagen_perfil, miniatura, cover_image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $dj_name, $post_title, $info, $custom_text, $social_links_json, $music_release_json, $latest_tracks_json, $sliderImagesJson, $imagenPerfil, $miniatura, $coverImage);
    }

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $dj_id = $id ? $id : $stmt->insert_id;

        // Eliminar categorías antiguas del DJ
        $deleteStmt = $conn->prepare("DELETE FROM dj_categories WHERE dj_id = ?");
        $deleteStmt->bind_param("i", $dj_id);
        $deleteStmt->execute();
        $deleteStmt->close();

        // Insertar nuevas categorías
        foreach ($categoria_ids as $category_id) {
            $insertStmt = $conn->prepare("INSERT INTO dj_categories (dj_id, category_id) VALUES (?, ?)");
            $insertStmt->bind_param("ii", $dj_id, $category_id);
            $insertStmt->execute();
            $insertStmt->close();
        }

        // Redireccionar con éxito
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'El DJ se ha guardado correctamente',
                confirmButtonText: 'Ir a la lista'
            }).then(() => {
                window.location.href = '../dashboard/list-djs.php';
            });
        </script>";
        exit();
        
    } else {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    // Cerrar conexiones
    $stmt->close();
}

// Cerrar conexión principal
$conn->close();
?>