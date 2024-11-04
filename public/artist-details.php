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

function obtenerRutaMedia($ruta)
{
	return strpos($ruta, 'uploads/') === 0 ? '/' . $ruta : '/uploads/' . $ruta;
}

function esVideo($ruta)
{
	$extensionesVideo = ['mp4', 'webm', 'ogg'];
	$extension = pathinfo($ruta, PATHINFO_EXTENSION);
	return in_array(strtolower($extension), $extensionesVideo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="Intera - Interior HTML Template" />
	<meta property="og:title" content="Intera - Interior HTML Template" />
	<meta property="og:description" content="Intera - Interior HTML Template" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON -->
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />

	<!-- PAGE TITLE HERE -->
	<title><?= htmlspecialchars($portafolio['nombre']) ?> - Portfolio Details</title>

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--[if lt IE 9]>
	<script src="js/html5shiv.min.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	<!-- link del font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100..900;1,100..900&family=Martian+Mono:wght@100..800&family=New+Amsterdam&family=SUSE:wght@100..800&display=swap" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" href="css/style.css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/magnific-popup.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<link rel="stylesheet" type="text/css" href="css/home-section.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
</head>

<body id="bg">

	<div class="page-wraper">
		<div id="loading-area"></div>
		<!-- header -->
		<header class="site-header header-transparent mo-left">
			<!-- main header -->
			<?php include('includes/navbar.php'); ?>
			<!-- main header END -->
		</header>
		<!-- header END -->
		<!-- Content -->
		<div class="page-content">
			<section class="home">
				<div class="home-img">
					<img src="/<?= htmlspecialchars($portafolio['imagen_perfil']) ?>" alt="<?= htmlspecialchars($portafolio['nombre']) ?>">
				</div>
				<div class="home-content">
					<h1>Hi, It's <span><?= htmlspecialchars($portafolio['nombre']) ?></span></h1>
					<h3 class="typing-text">I'm a <span class="dynamic-text"><?= htmlspecialchars($portafolio['rol']) ?></span></h3>
					<p class="pre-title m-b10">Since <?= htmlspecialchars($portafolio['anio_experiencia']) ?></p>
					<a href="#information" class="btn purple radius-xl"><span class="text-white">Hire me</span></a>
				</div>
			</section>

			<div id="information" class="combined-section">
				<div class="designer-section">
					<h1 class="title"> <?= htmlspecialchars($portafolio['rol']) ?>; <?= htmlspecialchars($portafolio['nombre']) ?>
					</h1>
					<p class="description"><?= nl2br(htmlspecialchars($portafolio['descripcion'])) ?></p>
				</div>

				<div class="info-cards">
					<div class="info-item">
						<div class="icon-circle"><i class="ti ti-user"></i></div>
						<div class="text-content">
							<strong>Contact</strong>
							<p><?= htmlspecialchars($portafolio['contacto']) ?></p>
						</div>
					</div>
					<div class="info-item">
						<div class="icon-circle"><i class="ti ti-location-pin"></i></div>
						<div class="text-content">
							<strong>Location</strong>
							<p><?= htmlspecialchars($portafolio['ubicacion']) ?></p>
						</div>
					</div>
					<div class="info-item">
						<div class="icon-circle"><i class="ti ti-ruler-alt-2"></i></div>
						<div class="text-content">
							<strong>Specialty</strong>
							<p><?= htmlspecialchars($portafolio['especialidad']) ?></p>
						</div>
					</div>
				</div>
			</div>

			<!-- Galería del portafolio -->
			<!-- Galería del portafolio -->
			<div class="section-full">
				<!-- Tabs de la galería -->
				<div class="tabs">
					<div class="tab active" data-tab="tab-mixed">All</div>
					<div class="tab" data-tab="tab-images">Images</div>
					<div class="tab" data-tab="tab-videos">Videos</div>
				</div>

				<!-- Contenido de los tabs -->
				<div class="content-wrapper">
					<!-- Tab Mixta -->
					<div id="tab-mixed" class="tab-content active">
						<div class="owl-carousel">
							<?php foreach ($slider_images as $media): ?>
								<div class="item">
									<?php if (esVideo($media)): ?>
										<a href="<?= obtenerRutaMedia($media) ?>" class="mfp-video">
											<video muted loop playsinline>
												<source src="<?= obtenerRutaMedia($media) ?>" type="video/mp4">
											</video>
											<div class="zoom-icon"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
													<path d="M21.71 20.29l-3.4-3.39A9.53 9.53 0 0019 10.5 9.5 9.5 0 109.5 20a9.53 9.53 0 006.4-1.29l3.39 3.4a1 1 0 001.42-1.42zM4 10.5a5.5 5.5 0 115.5 5.5A5.5 5.5 0 014 10.5z" />
												</svg>
											</div>
										</a>
									<?php else: ?>
										<a href="<?= obtenerRutaMedia($media) ?>" class="mfp-image">
											<img src="<?= obtenerRutaMedia($media) ?>" alt="Imagen del Portafolio">
											<div class="zoom-icon"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
													<path d="M21.71 20.29l-3.4-3.39A9.53 9.53 0 0019 10.5 9.5 9.5 0 109.5 20a9.53 9.53 0 006.4-1.29l3.39 3.4a1 1 0 001.42-1.42zM4 10.5a5.5 5.5 0 115.5 5.5A5.5 5.5 0 014 10.5z" />
												</svg>
											</div>
										</a>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Tab de Solo Imágenes -->
					<div id="tab-images" class="tab-content">
						<div class="owl-carousel">
							<?php foreach ($slider_images as $media): ?>
								<?php if (!esVideo($media)): ?>
									<div class="item">
										<a href="<?= obtenerRutaMedia($media) ?>" class="mfp-image">
											<img src="<?= obtenerRutaMedia($media) ?>" alt="Imagen del Portafolio">
											<div class="zoom-icon">
												<path d="M21.71 20.29l-3.4-3.39A9.53 9.53 0 0019 10.5 9.5 9.5 0 109.5 20a9.53 9.53 0 006.4-1.29l3.39 3.4a1 1 0 001.42-1.42zM4 10.5a5.5 5.5 0 115.5 5.5A5.5 5.5 0 014 10.5z" />
											</div>
										</a>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Tab de Solo Videos -->
					<div id="tab-videos" class="tab-content">
						<div class="owl-carousel">
							<?php foreach ($slider_images as $media): ?>
								<?php if (esVideo($media)): ?>
									<div class="item">
										<a href="<?= obtenerRutaMedia($media) ?>" class="mfp-video">
											<video muted loop playsinline>
												<source src="<?= obtenerRutaMedia($media) ?>" type="video/mp4">
											</video>
											<div class="zoom-icon">
												<path d="M21.71 20.29l-3.4-3.39A9.53 9.53 0 0019 10.5 9.5 9.5 0 109.5 20a9.53 9.53 0 006.4-1.29l3.39 3.4a1 1 0 001.42-1.42zM4 10.5a5.5 5.5 0 115.5 5.5A5.5 5.5 0 014 10.5z" />
											</div>
										</a>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>



		</div>
	</div>
	<div class="section-head text-center">
		<p></p>
		<span class="description">Inspired by what you see? Your project deserves the VIONS touch. Connect with us now and let's create something extraordinary!</span>
		<a href="#information" class="btn purple radius-xl"><span class="text-white">Hire me</span></a>

	</div>
	<!-- contact area END -->
	</div>
	</div>
	<!-- Content END-->
	<!-- Footer -->
	<?php include('includes/footer.php'); ?>
	<!-- Footer END -->
	<!-- JAVASCRIPT FILES ========================================= -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/jquery.magnific-popup.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	<script>
		$(document).ready(function() {
			// Cambiar de tab
			$('.tab').click(function() {
				var tabId = $(this).data('tab');
				$('.tab').removeClass('active');
				$(this).addClass('active');
				$('.tab-content').removeClass('active');
				$('#' + tabId).addClass('active');
			});

			// Configuración de Owl Carousel para el slider de imágenes
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

			// Configuración de Magnific Popup para Videos e Imágenes
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


		document.addEventListener("DOMContentLoaded", function() {
			const imgElement = document.querySelector('.home-img img');

			imgElement.onload = function() {
				Vibrant.from(imgElement).getPalette().then(palette => {
					const vibrantColor = palette.Vibrant ? palette.Vibrant.hex : '#5651B1'; // Color de respaldo

					// Aplica el degradado dinámico desde el color dominante hasta blanco
					document.querySelector('.home').style.background = `
                    linear-gradient(to bottom, ${vibrantColor}, #FFFFFF)
                `;
				});
			};

			// La URL de la imagen ya está en el atributo `src` desde PHP, así que solo necesitamos que la imagen se cargue
			if (imgElement.complete) {
				imgElement.onload(); // Llama a onload directamente si la imagen ya está cargada en caché
			}
			
		});
	</script>
	<script src="https://cdn.jsdelivr.net/npm/node-vibrant@3.1.6/dist/vibrant.min.js"></script>

	<script src="plugins/wow/wow.js"></script><!-- WOW JS -->
	<script src="plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script><!-- FORM JS -->
	<script src="plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script><!-- FORM JS -->
	<script src="plugins/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
	<script src="plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
	<script src="plugins/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
	<script src="plugins/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
	<script src="plugins/masonry/masonry-3.1.4.js"></script><!-- MASONRY -->
	<script src="plugins/masonry/masonry.filter.js"></script><!-- MASONRY -->
	<script src="js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
	<script src="js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS -->
	<script src="js/dz.ajax.js"></script><!-- CONTACT JS  -->

</body>

</html>