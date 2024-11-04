<?php 
include_once('../actions/get-portfolio-details.php');

$id = $_GET['id'] ?? null;
if (!$id) {
	die("ID de portafolio no proporcionado.");
}

$portafolio = getPortfolioDetails($id);

if (!$portafolio) {
	die("No se encontró el portafolio solicitado.");
}

// Verifica si slider_images está definido y contiene datos válidos
$slider_images = !empty($portafolio['slider_images']) ? json_decode($portafolio['slider_images'], true) : [];
$slider_images[] = 'https://www.youtube.com/watch?v=I2p9gtsSqHk'; // Añade el enlace de YouTube manualmente

function obtenerRutaMedia($ruta)
{
	return strpos($ruta, 'uploads/') === 0 ? '/' . $ruta : '/uploads/' . $ruta;
}

function esVideo($ruta)
{
	$extensionesVideo = ['mp4', 'webm', 'ogg'];
	$extension = pathinfo($ruta, PATHINFO_EXTENSION);
	return in_array(strtolower($extension), $extensionesVideo) || strpos($ruta, 'youtube.com') !== false;
}

function esYouTube($url)
{
	return strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($portafolio['nombre']) ?> - Portfolio Details</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/magnific-popup.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>
<body>
	<div class="tabs">
		<div class="tab active" data-tab="tab-mixed">Galería Mixta</div>
		<div class="tab" data-tab="tab-images">Imágenes</div>
		<div class="tab" data-tab="tab-videos">Videos</div>
	</div>

	<div class="content-wrapper">
		<div id="tab-mixed" class="tab-content active">
			<div class="owl-carousel">
				<?php foreach ($slider_images as $media): ?>
					<div class="item">
						<?php if (esYouTube($media)): ?>
							<a href="<?= $media ?>" class="mfp-iframe">
								<img src="https://img.youtube.com/vi/<?= explode('v=', $media)[1] ?>/hqdefault.jpg" alt="Video de YouTube">
								<div class="zoom-icon">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.71 20.29l-3.4-3.39A9.53 9.53 0 0019 10.5 9.5 9.5 0 109.5 20a9.53 9.53 0 006.4-1.29l3.39 3.4a1 1 0 001.42-1.42zM4 10.5a5.5 5.5 0 115.5 5.5A5.5 5.5 0 014 10.5z"/></svg>
								</div>
							</a>
						<?php elseif (esVideo($media)): ?>
							<a href="<?= obtenerRutaMedia($media) ?>" class="mfp-video">
								<video muted loop playsinline>
									<source src="<?= obtenerRutaMedia($media) ?>" type="video/mp4">
								</video>
								<div class="zoom-icon">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.71 20.29l-3.4-3.39A9.53 9.53 0 0019 10.5 9.5 9.5 0 109.5 20a9.53 9.53 0 006.4-1.29l3.39 3.4a1 1 0 001.42-1.42zM4 10.5a5.5 5.5 0 115.5 5.5A5.5 5.5 0 014 10.5z"/></svg>
								</div>
							</a>
						<?php else: ?>
							<a href="<?= obtenerRutaMedia($media) ?>" class="mfp-image">
								<img src="<?= obtenerRutaMedia($media) ?>" alt="Imagen del Portafolio">
								<div class="zoom-icon">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.71 20.29l-3.4-3.39A9.53 9.53 0 0019 10.5 9.5 9.5 0 109.5 20a9.53 9.53 0 006.4-1.29l3.39 3.4a1 1 0 001.42-1.42zM4 10.5a5.5 5.5 0 115.5 5.5A5.5 5.5 0 014 10.5z"/></svg>
								</div>
							</a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/jquery.magnific-popup.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.tab').click(function() {
				var tabId = $(this).data('tab');
				$('.tab').removeClass('active');
				$(this).addClass('active');
				$('.tab-content').removeClass('active');
				$('#' + tabId).addClass('active');
			});

			$('.owl-carousel').owlCarousel({
				items: 3,
				loop: true,
				nav: true,
				dots: false,
				margin: 0,
				center: true,
				autoplay: true,
				autoplayTimeout: 4000,
				slideBy: 1
			});

			$('.mfp-iframe').magnificPopup({
				type: 'iframe'
			});

			$('.mfp-video').magnificPopup({
				type: 'iframe',
				iframe: {
					patterns: {
						youtube: {
							index: 'youtube.com/', 
							id: 'v=', 
							src: 'https://www.youtube.com/embed/%id%?autoplay=1'
						}
					}
				}
			});

			$('.mfp-image').magnificPopup({
				type: 'image',
				gallery: {
					enabled: true
				}
			});
		});
	</script>
</body>
</html>
