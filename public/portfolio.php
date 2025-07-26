<?php
$categorias = require('../actions/get-category.php');
$artistas = require('../actions/get-all-portfolios.php');
$truncateWords = include_once('../actions/truncateWords.php');

if (!is_array($artistas) || empty($artistas)) {
	die("Error: No se pudo cargar la lista de portafolios.");
}
$artistas = array_filter($artistas, callback: fn($artista) => $artista['activo'] ?? false);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>VIONS - Portfolios</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Explore the VIONS Portfolio: A showcase of innovative marketing, unique designs, and sonic experiences that redefine creativity. Discover how we bring brands to life." />
	<meta name="keywords" content="VIONS, portfolio, innovative marketing, sonic experiences, creative design, visual identity, futuristic design, sound art" />
	<meta name="author" content="VIONS" />
	<meta name="robots" content="index, follow" />
	<link rel="canonical" href="https://www.vions.com.mx/">
	<meta property="og:title" content="VIONS - Portfolios" />
	<meta property="og:description" content="Discover the VIONS Portfolio: A collection of innovative projects that blend visual creativity and sound experiences, redefining marketing and design." />
	<meta property="og:image" content="https://www.vions.com.mx/images/Vionslg.png" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://www.vions.com.mx/portfolio" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:site_name" content="VIONS" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="VIONS - Portfolios" />
	<meta name="twitter:description" content="Explore the VIONS Portfolio: A collection of innovative projects blending visual creativity and sound experiences to redefine marketing and design." />
	<meta name="twitter:image" content="https://www.vions.com.mx/images/Vionslg.png" />
	<meta name="twitter:site" content="@VIONSOfficial" />
	<meta name="twitter:creator" content="@VIONSOfficial" />
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link rel="stylesheet" type="text/css" href="css/split-slider.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
	<style>
		.swiper-pagination-bullet {
			background: #000;
			opacity: 0.5;
		}

		.swiper-pagination-bullet-active {
			opacity: 1;
		}
	</style>
	<!-- Meta Pixel Code -->
	<script>
		! function(f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function() {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement(e);
			t.async = !0;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '3895056304074539');
		fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=3895056304074539&ev=PageView&noscript=1" /></noscript>
	<!-- End Meta Pixel Code -->
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-area"></div>
		<div class="page-content bg-dark">		<header class="site-header mo-left">
				<?php require_once('includes/navbar.php'); ?>
			</header>
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
												<div class="swiper-image swiper-bg" style="background-image:url('/admin/<?= htmlspecialchars($artista['imagen_perfil']) ?>')" loading="lazy"></div>
												<div class="swiper-image">
													<div class="swiper-content">
														<h2 class="title"><?= htmlspecialchars($artista['nombre']) ?></h2>
														<p><?= isset($artista['descripcion']) ? htmlspecialchars(truncateWords($artista['descripcion'], maxWords: 40)) : 'Descripción no disponible.' ?></p>
														<a href="artist-details.php?id=<?= urlencode($artista['id']) ?>" class="btn outline black button-lg radius-xl btn-aware">COLLABORATE NOW<span></span></a>
													</div>
												</div>
											<?php else: ?>
												<div class="swiper-image">
													<div class="swiper-content">
														<h2 class="title"><?= htmlspecialchars($artista['nombre']) ?></h2>
														<p><?= isset($artista['descripcion']) ? htmlspecialchars(truncateWords($artista['descripcion'], 40)) : 'Descripción no disponible.' ?></p>
														<a href="artist-details.php?id=<?= urlencode(string: $artista['id']) ?>" class="btn outline black button-lg radius-xl btn-aware">COLLABORATE NOW<span></span></a>
													</div>
												</div>
												<div class="swiper-image swiper-bg" style="background-image:url('/admin/<?= htmlspecialchars($artista['imagen_perfil']) ?>')"></div>
											<?php endif; ?>
										</div>
									<?php
										$alternate = !$alternate;
									endforeach; ?>
								</div>
								<div class="swiper-pagination"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<script src="js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
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
	<script src="plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
	<script src="js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
	<script src="js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS -->
	<script>
		$(document).ready(function() {
			if ($('.swiper-container .swiper-slide').length > 0) {
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
			}
		});
	</script>
</body>

</html>