<?php 
include_once('../actions/portfolio-upload-action.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Formulario de Artista</h1>

                    <div class="card mb-4">
                        <div id="artist-page">
                            <form id="artist-form" method="POST" enctype="multipart/form-data" action="../actions/portfolio-upload-action.php">

                                <div class="profile-image-container">
                                    <label for="profile_image">Imagen de Perfil</label>
                                    <input type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event, 'profilePreview')">
                                    <img id="profilePreview" src="#" alt="Previsualización de Imagen de Perfil" style="display: none;">
                                </div>

                                <!-- Nombre y Rol -->
                                <label for="name">Nombre</label>
                                <input type="text" id="name" name="name" placeholder="Ej: Sergio" required>

                                <label for="role">Rol</label>
                                <input type="text" id="role" name="role" placeholder="Ej: Digital Artist" required>

                                <!-- Año de Experiencia y Especialidad -->
                                <label for="experience_year">Año de Experiencia</label>
                                <input type="text" id="experience_year" name="experience_year" placeholder="Ej: Desde 2021" required>

                                <label for="specialty">Especialidad</label>
                                <input type="text" id="specialty" name="specialty" placeholder="Ej: 2D Illustration" required>

                                <!-- Menú Desplegable para Categoría -->
                                <label for="category">Categoría</label>
                                <select id="category" name="category" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= htmlspecialchars($categoria['id']) ?>">
                                            <?= htmlspecialchars($categoria['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Descripción -->
                                <label for="description" class="full-width">Descripción</label>
                                <textarea id="description" name="description" placeholder="Escribe una descripción sobre ti..." rows="3" required></textarea>

                                <!-- Contacto y Ubicación -->
                                <label for="contact">Contacto</label>
                                <input type="email" id="contact" name="contact" placeholder="Ej: sergio@vions.com.mx" required>

                                <label for="location">Ubicación</label>
                                <input type="text" id="location" name="location" placeholder="Ej: León, Gto, MX" required>

                                <!-- Miniatura -->
                                <label for="thumbnail" class="full-width">Miniatura</label>
                                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(event, 'thumbnailPreview')">
                                <div class="preview-container">
                                    <img id="thumbnailPreview" src="#" alt="Previsualización de Miniatura" style="display: none;">
                                </div>

                                <!-- Imágenes/Videos para el Slider -->
                                <label for="slider_images" class="full-width">Imágenes para el Slider</label>
                                <input type="file" id="slider_images" name="slider_images[]" accept="image/*,video/*" multiple onchange="previewMultipleImages(event)">
                                <div class="preview-container" id="sliderPreviewContainer"></div>

                                <!-- Botón de Envío -->
                                <button type="submit">Enviar Formulario</button>
                            </form>
                        </div>
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

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('preview-item');

                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('preview-img');

                    const deleteButton = document.createElement('button');
                    deleteButton.innerHTML = '&times;'; // Usa un símbolo de cruz
                    deleteButton.classList.add('delete-button');
                    deleteButton.onclick = function() {
                        imgContainer.remove(); // Quita la imagen de la previsualización
                    };

                    imgContainer.appendChild(imgElement);
                    imgContainer.appendChild(deleteButton);
                    container.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>