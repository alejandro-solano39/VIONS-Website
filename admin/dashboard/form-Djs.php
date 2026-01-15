<?php
$selected_categories = [];

include_once('../actions/portfolio-upload-action.php');
$categoryFunctions = include('../../src/actions/get-category.php');

// Obtener categorías de "design"
$categorias = call_user_func($categoryFunctions['getMusicCategories']);

include_once('../../config/config.php');
include('../auth/session_check.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$registro = null;

if ($id) {
    // Crear la conexión a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener las categorías asociadas al DJ
    $stmt = $conn->prepare("SELECT category_id FROM dj_categories WHERE dj_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $selected_categories = is_array($selected_categories) ? $selected_categories : [];
    while ($row = $result->fetch_assoc()) {
        $selected_categories[] = $row['category_id'];
    }
    $stmt->close();

    // Obtener los datos del DJ
    $sql = "SELECT * FROM djs_portfolios WHERE id = ?";
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

$trackLinks = [];
if (!empty($registro['latest_tracks'])) {
    $decodedTracks = json_decode($registro['latest_tracks'], true);
    $trackLinks = is_array($decodedTracks) ? $decodedTracks : [];
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
            background-color: #f8f9fa;
            color: #2c3e50;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: #2c3e50;
            color: #fff;
            font-weight: 600;
            text-align: center;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 15px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.2);
        }

        .btn {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-success {
            background-color: #2ecc71;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-secondary {
            background-color: #95a5a6;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .btn i {
            font-size: 14px;
        }

        .text-muted {
            color: #95a5a6 !important;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #95a5a6;
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

        .cover-image-container img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .btn-danger-custom {
            background-color: #e74c3c;
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

    <body class="sb-nav-fixed">
        <?php include('includes/navbar.php'); ?>

        <div id="layoutSidenav">
            <?php include('includes/sidenav.php'); ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1>Formulario de DJ</h1>
                        <div class="card p-4 mb-4">
                            <form id="dj-form" method="POST" enctype="multipart/form-data" action="../actions/DJs-upload-action.php">
                                <input type="hidden" name="id" value="<?php echo isset($registro['id']) ? $registro['id'] : ''; ?>">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="profile_image" class="form-label">Imagen de Perfil</label>
                                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event, 'profilePreview')">
                                            <div class="profile-image-container mt-2">
                                                <?php if (isset($registro['imagen_perfil']) && !empty($registro['imagen_perfil'])): ?>
                                                    <img id="profilePreview" src="/admin/<?php echo htmlspecialchars($registro['imagen_perfil']); ?>" alt="Previsualización de Imagen de Perfil" style="display: block; width: 100px; height: 100px; border-radius: 8px;">
                                                <?php else: ?>
                                                    <img id="profilePreview" src="#" alt="Previsualización de Imagen de Perfil" style="display: none; width: 100px; height: 100px; border-radius: 8px;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cover_image" class="form-label">Imagen de Portada</label>
                                            <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*" onchange="previewImage(event, 'coverPreview')">
                                            <div class="cover-image-container mt-2">
                                                <?php if (isset($registro['cover_image']) && !empty($registro['cover_image'])): ?>
                                                    <img id="coverPreview" src="/admin/<?php echo htmlspecialchars($registro['cover_image']); ?>" alt="Previsualización de Imagen de Portada" style="display: block; width: 100px; height: 100px; border-radius: 8px;">
                                                <?php else: ?>
                                                    <img id="coverPreview" src="#" alt="Previsualización de Imagen de Portada" style="display: none; width: 100px; height: 100px; border-radius: 8px;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="thumbnail" class="form-label">Miniatura</label>
                                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(event, 'thumbnailPreview')">
                                            <div class="preview-container mt-2">
                                                <?php if (isset($registro['miniatura']) && !empty($registro['miniatura'])): ?>
                                                    <img id="thumbnailPreview" src="/admin/<?php echo htmlspecialchars($registro['miniatura']); ?>" alt="Previsualización de Miniatura" style="display: block; width: 100px; height: 100px; border-radius: 8px;">
                                                <?php else: ?>
                                                    <img id="thumbnailPreview" src="#" alt="Previsualización de Miniatura" style="display: none; width: 100px; height: 100px; border-radius: 8px;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dj_name" class="form-label">Nombre Artista</label>
                                            <input type="text" id="dj_name" name="dj_name" class="form-control" value="<?php echo isset($registro['dj_name']) ? htmlspecialchars($registro['dj_name']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="post_title" class="form-label">Título Publicación</label>
                                            <input type="text" id="post_title" name="post_title" class="form-control" value="<?php echo isset($registro['post_title']) ? htmlspecialchars($registro['post_title']) : ''; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="info" class="form-label">Texto o Información</label>
                                    <textarea id="info" name="info" class="form-control" rows="3" required><?php echo isset($registro['info']) ? htmlspecialchars($registro['info']) : ''; ?></textarea>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="custom_text" class="form-label">Texto Personalizado</label>
                                    <textarea id="custom_text" name="custom_text" class="form-control" rows="3" placeholder="Escribe aquí el texto que quieres mostrar en tu perfil público"><?php echo isset($registro['custom_text']) ? htmlspecialchars($registro['custom_text']) : ''; ?></textarea>
                                    <small class="text-muted">Este texto aparecerá en la sección pública del perfil.</small>
                                </div>

                                <div class="form-group mt-3">
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
                                </div>

                                <div class="form-group mt-3">
                                    <label for="social_links" class="form-label">Redes Sociales</label>
                                    <div id="socialLinksContainer">
                                        <?php
                                        $social_links = isset($registro['social_links']) ? json_decode($registro['social_links'], true) : [];
                                        if (!empty($social_links)) {
                                            foreach ($social_links as $index => $link) {
                                                echo '<div class="input-group mb-2">
                        <input type="text" name="social_links[]" class="form-control" value="' . htmlspecialchars($link) . '" required>
                        <button type="button" class="btn btn-danger remove-link">X</button>
                      </div>';
                                            }
                                        } else {
                                            echo '<div class="input-group mb-2">
                    <input type="text" name="social_links[]" class="form-control" placeholder="Añadir enlace de red social" required>
                    <button type="button" class="btn btn-danger remove-link">X</button>
                  </div>';
                                        }
                                        ?>
                                    </div>
                                    <button type="button" id="addSocialLink" class="btn btn-primary mt-2">Agregar otro enlace</button>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="music_release" class="form-label">Álbumes / Presentaciones Importantes</label>
                                    <div id="music_release_container">
                                        <?php
                                        $musicReleases = isset($registro['music_release']) ? json_decode($registro['music_release'], true) : [];
                                        if (!empty($musicReleases)) {
                                            foreach ($musicReleases as $release) {
                                                echo '<div class="input-group mb-2">
                        <input type="url" name="music_release[]" class="form-control" value="' . htmlspecialchars($release) . '" placeholder="https://tusitio.com">
                        <button type="button" class="btn btn-danger remove-release">X</button>
                      </div>';
                                            }
                                        } else {
                                            echo '<div class="input-group mb-2">
                    <input type="url" name="music_release[]" class="form-control" placeholder="https://tusitio.com">
                    <button type="button" class="btn btn-danger remove-release">X</button>
                  </div>';
                                        }
                                        ?>
                                    </div>
                                    <button type="button" id="add_music_release" class="btn btn-primary">Agregar Álbum</button>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="latest_tracks" class="form-label">Últimas Pistas</label>
                                    <div id="latestTracksContainer">
                                        <?php foreach ($trackLinks as $link): ?>
                                            <div class="track-link-item d-flex">
                                                <input type="text" name="latest_tracks[]" class="form-control mb-2" value="<?= htmlspecialchars($link) ?>" placeholder="Enlace de Spotify/SoundCloud">
                                                <button type="button" class="btn btn-danger ms-2" onclick="removeTrackLink(this)">×</button>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="track-link-item d-flex">
                                            <input type="text" name="latest_tracks[]" class="form-control mb-2" placeholder="Enlace de Spotify/SoundCloud">
                                            <button type="button" class="btn btn-danger ms-2" onclick="removeTrackLink(this)">×</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success mt-2" onclick="addTrackLink()">Agregar otro enlace</button>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label">Géneros del Artista</label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="category-list">
                                                <?php foreach ($categorias as $categoria): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input category-checkbox" type="checkbox"
                                                            name="category[]" id="cat_<?= $categoria['id'] ?>"
                                                            value="<?= $categoria['id'] ?>"
                                                            <?= in_array($categoria['id'], $selected_categories) ? 'checked' : '' ?>
                                                            onclick="updateSelectedCategories()">
                                                        <label class="form-check-label" for="cat_<?= $categoria['id'] ?>">
                                                            <?= htmlspecialchars($categoria['nombre']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Categorías Seleccionadas (<span id="selectedCount"><?= count($selected_categories) ?></span>)</h5>
                                            <ul id="selectedCategoriesList" class="list-group">
                                                <?php foreach ($categorias as $categoria): ?>
                                                    <?php if (in_array($categoria['id'], $selected_categories)): ?>
                                                        <li class="list-group-item" id="selected_<?= $categoria['id'] ?>">
                                                            <?= htmlspecialchars($categoria['nombre']) ?>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-custom">Enviar Formulario</button>
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
                        imgContainer.innerHTML = `<img src="${e.target.result}">
                    <button type="button" class="btn btn-danger-custom" onclick="removeSliderImage(this)">×</button>`;
                        container.appendChild(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });
            }

            function removeSliderImage(button) {
                button.closest('.slider-image-item').remove();
            }

            function addTrackLink() {
                let container = document.getElementById('latestTracksContainer');
                let div = document.createElement('div');
                div.classList.add('track-link-item', 'd-flex');
                div.innerHTML = `
            <input type="text" name="latest_tracks[]" class="form-control mb-2" placeholder="Enlace de Spotify/SoundCloud">
            <button type="button" class="btn btn-danger ms-2" onclick="removeTrackLink(this)">×</button>
        `;
                container.appendChild(div);
            }

            function removeTrackLink(button) {
                button.parentElement.remove();
            }

            document.addEventListener("DOMContentLoaded", function() {
                const musicContainer = document.getElementById("music_release_container");
                const addMusicBtn = document.getElementById("add_music_release");

                if (addMusicBtn) {
                    addMusicBtn.addEventListener("click", function() {
                        const newField = document.createElement("div");
                        newField.classList.add("input-group", "mb-2");
                        newField.innerHTML = `
                    <input type="text" name="music_release[]" class="form-control" placeholder="Ejemplo: Nuevo álbum">
                    <button type="button" class="btn btn-danger remove-release">X</button>
                `;
                        musicContainer.appendChild(newField);
                    });

                    musicContainer.addEventListener("click", function(e) {
                        if (e.target.classList.contains("remove-release")) {
                            e.target.parentElement.remove();
                        }
                    });
                }

                const socialContainer = document.getElementById("socialLinksContainer");
                const addSocialBtn = document.getElementById("addSocialLink");

                if (addSocialBtn) {
                    addSocialBtn.addEventListener("click", function() {
                        const newField = document.createElement("div");
                        newField.classList.add("input-group", "mb-2");
                        newField.innerHTML = `
                    <input type="text" name="social_links[]" class="form-control" placeholder="Añadir enlace de red social" required>
                    <button type="button" class="btn btn-danger remove-link">X</button>
                `;
                        socialContainer.appendChild(newField);
                    });

                    socialContainer.addEventListener("click", function(e) {
                        if (e.target.classList.contains("remove-link")) {
                            e.target.parentElement.remove();
                        }
                    });
                }
            });

            function updateSelectedCategories() {
                const checkboxes = document.querySelectorAll('.category-checkbox');
                const selectedList = document.getElementById('selectedCategoriesList');
                const selectedCount = document.getElementById('selectedCount');
                selectedList.innerHTML = "";

                let count = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        count++;
                        const listItem = document.createElement("li");
                        listItem.classList.add("list-group-item");
                        listItem.textContent = checkbox.nextElementSibling.textContent;
                        selectedList.appendChild(listItem);
                    }
                });

                selectedCount.textContent = count;
            }

            document.addEventListener("DOMContentLoaded", updateSelectedCategories);
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>