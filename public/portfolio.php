<?php
function truncateWords($text, $maxWords = 40) {
    $text = trim($text);
    $words = explode(' ', $text);
    if (count($words) > $maxWords) {
        $text = implode(' ', array_slice($words, 0, $maxWords)) . '...';
    }
    return $text;
}

$categorias = include('../actions/get-category.php');
$artistas = include('../actions/get-all-portfolios.php');

// Verificación de que $artistas es un array antes de continuar
if (!is_array($artistas)) {
    die("Error: No se pudo cargar la lista de portafolios.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta y títulos -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Intera - Interior HTML Template</title>
	<meta name="description" content="Intera - Interior HTML Template">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />
	
	<!-- CSS de Swiper -->
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<!-- Estilos personalizados -->
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link rel="stylesheet" type="text/css" href="css/split-slider.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
	<!-- Estilos adicionales para la paginación (opcional) -->
	<style>
		.swiper-pagination-bullet {
			background: #000;
			opacity: 0.5;
		}

		.swiper-pagination-bullet-active {
			opacity: 1;
		}
	</style>
</head>

<body id="bg">
	<div class="page-wraper">
		<!-- Cargando área -->
		<div id="loading-area"></div>

		<div class="page-content bg-white">

			<!-- Header -->
			<header class="site-header">
				<!-- main header -->
				<?php include('includes/navbar.php'); ?>
				<!-- main header END -->
			</header>
			<!-- Header END -->

			<!-- Contenido -->
			<div class="page-content bg-white">
				<div class="content-block">
					<div class="section-full">
						<div id="home-slider">
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<?php
									$alternate = true;
									foreach ($artistas as $artista): ?>
										<div class="swiper-slide">
											<?php if ($alternate): ?>
												<!-- Imagen a la izquierda, contenido a la derecha -->
												<div class="swiper-image swiper-bg" style="background-image:url('/<?= htmlspecialchars($artista['miniatura']) ?>')"></div>
												<div class="swiper-image">
													<div class="swiper-content">
														<h2 class="title"><?= htmlspecialchars($artista['nombre']) ?></h2>
														<p><?= isset($artista['descripcion']) ? htmlspecialchars(truncateWords($artista['descripcion'], 40)) : 'Descripción no disponible.' ?></p>
														<a href="artist-details.php?id=<?= urlencode($artista['id']) ?>" class="btn outline black button-lg radius-xl btn-aware">View Project<span></span></a>
													</div>
												</div>
											<?php else: ?>
												<!-- Contenido a la izquierda, imagen a la derecha -->
												<div class="swiper-image">
													<div class="swiper-content">
														<h2 class="title"><?= htmlspecialchars($artista['nombre']) ?></h2>
														<p><?= isset($artista['descripcion']) ? htmlspecialchars(truncateWords($artista['descripcion'], 20)) : 'Descripción no disponible.' ?></p>
														<a href="artist-details.php?id=<?= urlencode($artista['id']) ?>" class="btn outline black button-lg radius-xl btn-aware">View Project<span></span></a>
													</div>
												</div>
												<div class="swiper-image swiper-bg" style="background-image:url('/<?= htmlspecialchars($artista['miniatura']) ?>')"></div>
											<?php endif; ?>
										</div>
									<?php
										$alternate = !$alternate;
									endforeach; ?>
								</div>
								<!-- Paginación -->
								<div class="swiper-pagination"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- Área de contacto END -->
			</div>
		</div>
		<!-- Contenido END -->
	</div>

	<!-- Archivos JavaScript -->
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Swiper JS -->
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<!-- Scripts adicionales -->
	<script src="plugins/wow/wow.js"></script>
	<script src="plugins/bootstrap/js/popper.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
	<script src="plugins/magnific-popup/magnific-popup.js"></script>
	<script src="plugins/counter/waypoints-min.js"></script>
	<script src="plugins/counter/counterup.min.js"></script>
	<script src="plugins/imagesloaded/imagesloaded.js"></script>
	<script src="plugins/masonry/masonry-3.1.4.js"></script>
	<script src="plugins/masonry/masonry.filter.js"></script>
	<script src="plugins/owl-carousel/owl.carousel.js"></script>
	<script src="plugins/scroll/scrollbar.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/dz.carousel.js"></script>
	<script src="js/dz.ajax.js"></script>
	<script src="plugins/loading/anime.js"></script>
	<script src="plugins/loading/anime-app.js"></script>
	<script src="plugins/rangeslider/rangeslider.js"></script>
	<!-- Inicialización de Swiper -->
	<script>
		$(document).ready(function() {
			var swiper = new Swiper('.swiper-container', {
				direction: 'vertical',
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				speed: 1000,
				parallax: true,
				autoplay: false,
				effect: 'slide',
				mousewheel: true,
			});
		});
	</script>
</body>

</html>
