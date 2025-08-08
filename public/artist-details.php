<?php
include_once('../src/actions/get-portfolio-details.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
	die("ID no especificado o inválido.");
}

$id = intval($_GET['id']);

if ($id <= 0) {
	die("ID no válido.");
}

$portafolio = getPortfolioDetails($id);

if (!$portafolio) {
	die("No se encontró el portafolio solicitado.");
}

$slider_images = json_decode($portafolio['slider_images'] ?? '[]', true) ?: [];
$youtube_videos = json_decode($portafolio['youtube_videos'] ?? '[]', true) ?: [];

function obtenerRutaMedia($ruta)
{
	return '/admin/' . $ruta;
}
function obtenerIdVideoYoutube($url)
{
	if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?(.*&)?v=|embed\/|v\/|shorts\/))([A-Za-z0-9_-]{11})/', $url, $matches)) {
		return $matches[2];
	}
	return false;
}
function esVideoYoutube($url)
{
	return preg_match('/(youtube\.com|youtu\.be)/', $url);
}
function esVideo($ruta)
{
	static $extensionesVideo = ['mp4', 'webm', 'ogg'];
	return in_array(strtolower(pathinfo($ruta, PATHINFO_EXTENSION)), $extensionesVideo, true);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?= htmlspecialchars($portafolio['descripcion']) ?>" />
	<meta name="keywords" content="<?= htmlspecialchars($portafolio['especialidad']) ?>" />
	<meta name="author" content="<?= htmlspecialchars($portafolio['nombre']) ?>" />
	<meta name="robots" content="index, follow" />
	<link rel="canonical" href="https://www.vions.com.mx/">
	<meta property="og:title" content="<?= htmlspecialchars($portafolio['nombre']) ?> - Portfolio Details" />
	<meta property="og:description" content="<?= htmlspecialchars($portafolio['descripcion']) ?>" />
	<meta property="og:image" content="https://www.vions.com.mx/images/portafolio/<?= htmlspecialchars($portafolio['miniatura']) ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="https://www.vions.com.mx/portafolio/<?= htmlspecialchars($portafolio['id']) ?>" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:site_name" content="VIONS Portfolio" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="<?= htmlspecialchars($portafolio['nombre']) ?> - Portfolio Details" />
	<meta name="twitter:description" content="<?= htmlspecialchars($portafolio['descripcion']) ?>" />
	<meta name="twitter:image" content="https://www.vions.com.mx/images/portafolio/<?= htmlspecialchars($portafolio['miniatura']) ?>" />
	<meta name="twitter:site" content="@VIONSOfficial" />
	<meta name="twitter:creator" content="@VIONSOfficial" />
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />
	<title><?= htmlspecialchars($portafolio['nombre']) ?> - Portfolio Details</title>
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/magnific-popup.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<link rel="stylesheet" type="text/css" href="css/home-section.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
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
		<header class="site-header header-transparent mo-left">
			<?php require_once('includes/navbar.php'); ?>
		</header>
		<div class="page-content">
			<section class="home">
				<div class="home-img">
					<img src="/admin/<?= htmlspecialchars($portafolio['imagen_perfil']) ?>" alt="<?= htmlspecialchars($portafolio['nombre']) ?>" alt="Lazy loading image" loading="lazy">
				</div>
				<div class="home-content">
					<h1>Hi, It's <span><?= htmlspecialchars($portafolio['nombre']) ?></span></h1>
					<h3 class="typing-text">I'm a <span class="dynamic-text"><?= htmlspecialchars($portafolio['rol']) ?></span></h3>
					<p class="pre-title m-b10">Since <?= htmlspecialchars($portafolio['anio_experiencia']) ?></p>
					<div class="button-container">
						<a href="contact-us.php?id=<?= urlencode(string: $portafolio['id']) ?>" class="btn purple radius-xl"><span class="text-white">START PROJECT</span></a>
					</div>
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
			<div class="section-full">
				<div class="owl-carousel">
					<?php foreach ($slider_images as $image): ?>
						<div class="item">
							<a href="<?= obtenerRutaMedia($image) ?>" data-fancybox="gallery">
								<img src="<?= obtenerRutaMedia($image) ?>" alt="Portfolio Image" loading="lazy">
								<div class="zoom-icon">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
										<path fill="white" d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.48-5.34c-.6-2.89-3.1-5.15-6.08-5.34A6.5 6.5 0 1 0 14 14.43l.27.28v.79l5 4.99L20.49 19l-5-4.99zM10.5 14a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"></path>
									</svg>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
					<?php foreach ($youtube_videos as $videoUrl): ?>
						<?php
						$videoId = obtenerIdVideoYoutube($videoUrl);
						if (!$videoId) continue; // si no se puede extraer el ID, lo salta
						?>
						<div class="item">
							<a href="https://www.youtube.com/embed/<?= htmlspecialchars($videoId) ?>" data-fancybox="gallery" data-type="iframe">
								<img src="https://img.youtube.com/vi/<?= htmlspecialchars($videoId) ?>/maxresdefault.jpg" alt="Portfolio Video" loading="lazy">
								<div class="zoom-icon">...</div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<div class="section-head text-center">
		<p></p>
		<h2 class="text-center head-title">Inspired by what you see? Your project deserves the VIONS touch. <br> Connect with us now and let's create something extraordinary!</h2>
	</div>
	</div>
	</div>
	<?php require_once('includes/footer.php'); ?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/jquery.magnific-popup.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.owl-carousel').owlCarousel({
				items: 1,
				loop: true,
				nav: true,
				dots: true,
				autoplay: true,
				autoplayTimeout: 4000,
				navText: [
					"<span class='minimal-nav'>&#10094;</span>",
					"<span class='minimal-nav'>&#10095;</span>"
				],
			});
			Fancybox.bind("[data-fancybox='gallery']", {
				Toolbar: false,
				smallBtn: true,
				iframe: {
					preload: false
				}
			});
		});
		document.addEventListener("DOMContentLoaded", function() {
			const imgElement = document.querySelector('.home-img img');
			imgElement.onload = function() {
				Vibrant.from(imgElement).getPalette().then(palette => {
					const vibrantColor = palette.Vibrant ? palette.Vibrant.hex : '#5651B1';
					document.querySelector('.home').style.background = `
                    linear-gradient(to bottom, ${vibrantColor}, #FFFFFF)
                `;
				});
			};
			if (imgElement.complete) {
				imgElement.onload();
			}
		});
	</script>
	<script src="https://cdn.jsdelivr.net/npm/node-vibrant@3.1.6/dist/vibrant.min.js"></script>
	<script src="plugins/wow/wow.js"></script><!-- WOW JS -->
	<script src="plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
	<script src="plugins/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
	<script src="plugins/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
	<script src="plugins/masonry/masonry-3.1.4.js"></script><!-- MASONRY -->
	<script src="plugins/masonry/masonry.filter.js"></script><!-- MASONRY -->
	<script src="js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
	<script src="js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS -->

</body>

</html>