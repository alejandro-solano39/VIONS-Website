
<?php
include_once('../actions/portfolio-upload-action.php');
$categoryFunctions = include('../../src/actions/get-category.php');

// Obtener categorías de "design"
$categorias = call_user_func($categoryFunctions['getDesignCategories']);

include_once('../../config/config.php');
include('../auth/session_check.php');


$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$registro = null;

if ($id) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM portfolios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $registro = $result->fetch_assoc();
    } else {
        echo "Registro no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Formulario de Artista - VIONS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <style>
        body {
            background-color: #f3f0ff;
        }

        .container-fluid {
            max-width: auto;
            margin: auto;
        }

        h1 {
            font-weight: 700;
            color: #5a3d99;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-label {
            color: #5a3d99;
            font-weight: 500;
            margin-right: 10px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(90, 61, 153, 0.2);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #d1c4e9;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #7e57c2;
            box-shadow: 0 4px 8px rgba(126, 87, 194, 0.2);
        }

        .btn-custom {
            background-color: #7e57c2;
            color: #fff;
            border-radius: 25px;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #5a3d99;
        }

        .slider-preview-container img {
            width: 100px;
            height: 75px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .slider-image-item {
            position: relative;
            display: inline-block;
            margin: 5px;
        }

        .btn-danger-custom {
            background-color: #b39ddb;
            color: #fff;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            position: absolute;
            top: 5px;
            right: 5px;
        }
    </style>
</head>

<body>
    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1>Formulario de Artista</h1>

                    <div class="card p-4 mb-4">
                        <form id="artist-form" method="POST" enctype="multipart/form-data" action="../actions/portfolio-upload-action.php">
                            <input type="hidden" name="id" value="<?php echo $registro ? $registro['id'] : ''; ?>">

                            <div class="form-row">
                                <label for="profile_image" class="form-label">Imagen de Perfil</label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event, 'profilePreview')">
                                <div class="profile-image-container">
                                    <?php if (isset($registro['imagen_perfil']) && !empty($registro['imagen_perfil'])): ?>
                                        <img id="profilePreview" src="/admin/<?php echo htmlspecialchars($registro['imagen_perfil']); ?>" alt="Previsualización de Imagen de Perfil" style="display: block;">
                                    <?php else: ?>
                                        <img id="profilePreview" src="#" alt="Previsualización de Imagen de Perfil" style="display: none;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="thumbnail" class="form-label">Miniatura</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(event, 'thumbnailPreview')">
                                <div class="preview-container">
                                    <?php if (isset($registro['miniatura']) && !empty($registro['miniatura'])): ?>
                                        <img id="thumbnailPreview" src="/admin/<?php echo htmlspecialchars($registro['miniatura']); ?>" alt="Previsualización de Miniatura" style="display: block;">
                                    <?php else: ?>
                                        <img id="thumbnailPreview" src="#" alt="Previsualización de Miniatura" style="display: none;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Ej: Sergio" required value="<?php echo $registro ? htmlspecialchars($registro['nombre']) : ''; ?>">
                            </div>

                            <div class="form-row">
                                <label for="role" class="form-label">Rol</label>
                                <input type="text" id="role" name="role" class="form-control" placeholder="Ej: Digital Artist" required value="<?php echo $registro ? htmlspecialchars($registro['rol']) : ''; ?>">
                            </div>

                            <div class="form-row">
                                <label for="experience_year" class="form-label">Año de Experiencia</label>
                                <input type="text" id="experience_year" name="experience_year" class="form-control" placeholder="Ej: Desde 2021" required value="<?php echo $registro ? htmlspecialchars($registro['anio_experiencia']) : ''; ?>">
                            </div>

                            <div class="form-row">
                                <label for="specialty" class="form-label">Especialidad</label>
                                <input type="text" id="specialty" name="specialty" class="form-control" placeholder="Ej: 2D Illustration" required value="<?php echo $registro ? htmlspecialchars($registro['especialidad']) : ''; ?>">
                            </div>

                            <div class="form-row">
                                <label for="category" class="form-label">Categoría</label>
                                <select id="category" name="category" class="form-select" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= htmlspecialchars($categoria['id']) ?>" <?php echo ($registro && $registro['categoria_id'] == $categoria['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($categoria['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-row">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Escribe una descripción sobre ti..." rows="3" required><?php echo $registro ? htmlspecialchars($registro['descripcion']) : ''; ?></textarea>
                            </div>

                            <div class="form-row">
                                <label for="contact" class="form-label">Contacto</label>
                                <input type="email" id="contact" name="contact" class="form-control" placeholder="Ej: sergio@vions.com.mx" required value="<?php echo $registro ? htmlspecialchars($registro['contacto']) : ''; ?>">
                            </div>

                            <div class="form-row">
                                <label for="location" class="form-label">Ubicación</label>
                                <input type="text" id="location" name="location" class="form-control" placeholder="Ej: León, Gto, MX" required value="<?php echo $registro ? htmlspecialchars($registro['ubicacion']) : ''; ?>">
                            </div>

                            <div class="form-row">
                                <label for="slider_images" class="form-label">Imágenes para el Slider</label>
                                <input type="file" class="form-control" id="slider_images" name="slider_images[]" accept="image/*" multiple onchange="previewMultipleImages(event)">
                                <div class="slider-preview-container mt-2" id="sliderPreviewContainer">
                                    <?php
                                    if (isset($registro['slider_images']) && !empty($registro['slider_images'])):
                                        $sliderImages = json_decode($registro['slider_images'], true);
                                        foreach ($sliderImages as $image):
                                    ?>
                                            <div class="slider-image-item" data-image="<?php echo htmlspecialchars($image); ?>">
                                                <img src="/admin/<?php echo htmlspecialchars($image); ?>" alt="Imagen de Slider">
                                                <button type="button" class="btn btn-danger-custom" onclick="removeSliderImage(this)">×</button>
                                                <input type="hidden" name="existing_slider_images[]" value="<?php echo htmlspecialchars($image); ?>">
                                            </div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>

                                <div class="form-row">
    <label for="youtube_videos" class="form-label">Enlaces de Videos de YouTube</label>

    <?php
    if (isset($registro['youtube_videos']) && !empty($registro['youtube_videos'])):
        $youtubeVideos = json_decode($registro['youtube_videos'], true);
        foreach ($youtubeVideos as $videoUrl):
    ?>
        <input type="url" class="form-control mb-2" name="youtube_videos[]" placeholder="Ingrese un enlace de YouTube" value="<?php echo htmlspecialchars($videoUrl); ?>">
    <?php
        endforeach;
    else:
    ?>
        <input type="url" class="form-control mb-2" name="youtube_videos[]" placeholder="Ingrese un enlace de YouTube">
    <?php endif; ?>

    <div id="video-fields"></div>

    <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addVideoField()">Agregar otro enlace</button>
</div>


                                <div class="form-row">
                                    <button type="submit" class="btn btn-custom mt-3">Enviar Formulario</button>
                                </div>
                        </form>
                    </div>
                </div>
            </main>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewMultipleImages(event) {
            const files = event.target.files;
            const container = document.getElementById('sliderPreviewContainer');
            container.innerHTML = "";

            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('slider-image-item');
                    imgContainer.innerHTML = `<img src="${e.target.result}"><button type="button" class="btn btn-danger-custom" onclick="removeSliderImage(this)">×</button>`;
                    container.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }

      function addVideoField() {
    const container = document.getElementById('video-fields');
    const input = document.createElement('input');
    input.type = 'url';
    input.name = 'youtube_videos[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Ingrese un enlace de YouTube';
    container.appendChild(input);
}

        function removeSliderImage(button) {
            const container = button.closest('.slider-image-item');
            container.remove();
        }


    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>