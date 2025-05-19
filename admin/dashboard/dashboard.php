<?php 
include('../../actions/get-category.php');
include('../auth/session_check.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto - Sergio</title>
    <link rel="stylesheet" href="../../public/css/style.css"> <!-- Incluye el CSS del formulario aquí -->
</head>

<body>
    <div id="artist-page">
        <form id="artist-form" method="POST" enctype="multipart/form-data" action="../../actions/portfolio-upload-action.php">
            <h1>Formulario de Artista</h1>

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
</body>

</html>

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
</body>

</html>