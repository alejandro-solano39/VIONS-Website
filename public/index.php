<?php
$categoryFunctions = include('../src/actions/get-category.php');
$djFunctions = include('../src/actions/get-all-DJs.php');

$categorias = call_user_func($categoryFunctions['getDesignCategories']);
$artistas = require_once('../src/actions/get-artists.php');

// Filtrar portafolios activos
$artistas = array_filter($artistas, function ($artista) {
	return isset($artista['activo']) && $artista['activo'] == 1;
});
$truncateWords = include_once('../src/actions/truncateWords.php');

$djs = obtenerDJs(soloActivos: true);


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="VIONS: Transforming marketing and design through unique innovations and sonic experiences. Discover how we challenge norms and inspire extraordinary connections through visual and musical creativity." />
	<meta name="keywords" content="innovative marketing, sonic experiences, unique design, digital creativity, brand identity, visual marketing, futuristic art, music talent management" />
	<meta name="robots" content="index, follow" />
	<link rel="canonical" href="https://www.vions.com.mx/">
	<meta property="og:title" content="VIONS - Innovative Marketing & Design" />
	<meta property="og:description" content="Explore VIONS' innovative approach to marketing and design through visual and sonic creativity. Create authentic and memorable connections." />
	<meta property="og:image" content="https://www.vions.com.mx/images/main-slider/slide4.webp" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://www.vions.com.mx" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:site_name" content="VIONS" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="VIONS - Innovative Marketing & Design" />
	<meta name="twitter:description" content="Explore VIONS' innovative approach to marketing and design through visual and sonic creativity. Create authentic and memorable connections." />
	<meta name="twitter:image" content="https://www.vions.com.mx/images/main-slider/slide4.webp" />
	<meta name="twitter:site" content="@VIONSOfficial" />
	<meta name="twitter:creator" content="@VIONSOfficial" />
	<title>VIONS - Innovative Marketing & Design with Sonic Experiences</title>
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
	<link rel="stylesheet" type="text/css" href="plugins/revolution/revolution/css/layers.css">
	<link rel="stylesheet" type="text/css" href="plugins/revolution/revolution/css/settings.css">
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
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

	<style>
		.containervid {
			position: relative;
			width: 640;
			height: 460px;
			background-color: black;
		}

		.videopxh {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.blog-media {
			width: 100%;
			aspect-ratio: 1 / 1;
			overflow: hidden;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.blog-media img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
	</style>
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-area"></div>
		<div class="page-content bg-white">
			<header class="site-header header-transparent mo-left">
				<?php require_once('includes/navbar.php'); ?>
			</header>
			<div class="main-slider style-two default-banner" id="home">
				<div class="tp-banner-container">
					<div class="tp-banner">
						<div id="welcome_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="reveal-add-on36" data-source="gallery" style="background:#000000;padding:0px;">
							<div id="welcome" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.4.7.2">
								<ul>
									<li data-index="rs-100" data-transition="fadethroughdark" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="" data-rotate="0" data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
										<img src="images/main-slider/dummy.png" alt="Main slide of VIONS showcasing innovative design" data-lazyload="images/main-slider/slide4.webp" data-bgposition="center center" data-kenburns="on" data-duration="4000" data-ease="Power3.easeInOut" data-scalestart="150" data-scaleend="100" data-rotatestart="0" data-rotateend="0" data-blurstart="0" data-blurend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="4" class="rev-slidebg" data-no-retina>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="content-block">
				<div class="section-full content-inner-2">
					<div class="section-full content-inner-2" style="padding: 20px;">
						<div class="container">
							<div class="text-center mx-auto" style="max-width: 800px;">
								<h2 class="fw-bold mb-4">
									Transform Your Events with Cutting-Edge <span style="color: #5651B1;">3D Visuals and Curated Electronic Soundscapes</span>
								</h2>
								<h3 class="mb-5 text-bg-primary">
								VIONS delivers high-impact creative solutions <br> <span style="font-weight: 500; color: #5651B1;">connecting you with top-tier digital artists and electronic music curators to craft immersive, world-class experiences.</span>
								</h3>
								<div class="d-flex flex-wrap justify-content-center">
									<a href="portfolio.php" class="btn purple outline outline-2 radius-xl btn-aware m-r10 m-b10">MEET DESIGNERS
										<span></span></a>
									<a href="our-services.php" class="btn purple outline outline-2 radius-xl btn-aware m-b10">OUR SERVICES
										<span></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="section-full bg-white content-inner-1">
					<div class="container">
						<div class="section-head text-center">
							<h2 class="head-title">Our Designers</h2>
							<p>Whether you’re a digital artist ready to showcase your skills or an organizer seeking a partner to elevate your event, we want to hear from you!</p>
						</div>
						<div class="row">
							<div class="col-lg-12 text-center">
								<div class="site-filters filter-style1 clearfix m-b20">
									<ul class="filters" data-toggle="buttons">
										<li data-filter="" class="btn active"><input type="radio"><a href="#"><span>All</span></a></li>
										<?php foreach ($categorias as $categoria): ?>
											<li data-filter="categoria-<?= htmlspecialchars($categoria['id']) ?>" class="btn">
												<input type="radio"><a href="#"><span><?= htmlspecialchars($categoria['nombre']) ?></span></a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
								<div class="clearfix">
									<ul id="masonry" class="dlab-gallery-listing gallery mfp-gallery text-center portfolio-bx p-l0">
										<?php echo implode('', array_map(function ($artista) { ?>
											<li class="card-container col-lg-3 col-md-4 col-sm-6 p-lr0 categoria-<?= htmlspecialchars($artista['categoria_id']) ?>">
												<div class="dlab-media dlab-img-overlay1 dlab-img-effect portbox1">
													<img rel="preload" src="/admin/<?= htmlspecialchars($artista['miniatura']) ?>" alt="Thumbnail of artist <?= htmlspecialchars($artista['nombre']) ?> in the <?= htmlspecialchars($artista['categoria']) ?> category" loading="lazy">
													<div class="overlay-bx">
														<div class="portinner">
															<span><?= htmlspecialchars($artista['categoria']) ?></span>
															<h3 class="port-title text-white"><?= htmlspecialchars($artista['nombre']) ?></h3>
															<a href="artist-details.php?id=<?= htmlspecialchars($artista['id']) ?>" class="btn outline white outline-2 radius-xl">VIEW PROJECT</a>
														</div>
													</div>
												</div>
											</li>
										<?php }, $artistas)); ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="section-full bg-white content-inner">
					<div class="container">
						<div class="section-head text-center">
							<h2 class="head-title">Join Us</h2>
							<p>At VIONS, we seamlessly blend innovative design and exceptional DJ talent, offering a unique platform that connects visionary digital artists and top-tier Mexican DJs with high-profile
								European events. Elevate your next event with our creative expertise and musical excellence.</p>
							<a href="contact-us.php" class="btn purple outline outline-2 radius-xl btn-aware m-r10 m-b10">CONTACT US<span></span></a>
						</div>
					</div>
				</div>
				<div class="section-full content-inner bg-gray">
					<div class="container">
						<div class="section-head text-center">
							<h2 class="head-title">Our Services</h2>
							<p>At VIONS, we are dedicated to promoting Mexican digital art in 3D and curating top Mexican DJs through our comprehensive services. From innovative visual designs to exclusive DJ bookings, we enhance your presence and impact at high-profile European events and parties.</p>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 m-b30">
								<div class="icon-bx-wraper sr-iconbox bg-white p-a30 text-center">
									<div class="icon-lg m-b20"></div>
									<div class="icon-content">
										<h4 class="dlab-tilte">Visual Marketing</h4>
										<p>Discover the power of visual marketing with VIONS! We merge the creativity of 3D graphic design with dynamic social media advertising strategies to create campaigns that not only capture attention, but inspire and connect with your audience.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 m-b30">
								<div class="icon-bx-wraper sr-iconbox bg-white p-a30 text-center">
									<div class="icon-lg m-b20"></div>
									<div class="icon-content">
										<h4 class="dlab-tilte">VIONS Global Sound</h4>
										<p>Through VIONS Global Sound, we showcase top-tier DJs, blending cutting-edge sound with exceptional booking services to create unforgettable experiences that redefine the international electronic music scene</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 m-b30">
								<div class="icon-bx-wraper sr-iconbox bg-white p-a30 text-center">
									<div class="icon-lg m-b20"></div>
									<div class="icon-content">
										<h4 class="dlab-tilte">Branding</h4>
										<p>At VIONS, we help build and strengthen your brand identity. From creating logos to defining your company's voice and visual style, our comprehensive approach to branding ensures that your brand is consistent and recognizable across all customer touch points.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="text-center mt-4">
							<a href="contact-us.php" class="btn purple outline outline-2 radius-xl btn-aware">EXPLORE MORE<span></span></a>
						</div>
					</div>
				</div>
				<div class="section-full content-inner bg-gray">
					<div class="container">
						<div class="section-head text-center">
							<h1 class="head-title">VIONS Global Sound</h1>
							<p>Enhance your booking with the bridge between the most avant-garde DJs and the global audience.</h3>
							<h5>Be part of VIONS GLOBAL SOUND</h3>
								<p>Whether you're an event organizer searching for new cutting-edge sounds or a DJ seeking international bookings, this is your place.
							</h5>
							<div class="d-flex flex-wrap justify-content-center">
								<a href="contact-us.php" class="btn purple outline outline-2 radius-xl btn-aware m-r10 m-b10">SEND YOUR PRESSKIT
									<span></span></a>
								<a href="global-sound.php" class="btn purple outline outline-2 radius-xl btn-aware m-b10">DISCOVER DJS
									<span></span></a>
							</div>
						</div>
						<div class="dlab-blog-grid-3 row">
							<?php if (!empty($djs)): ?>
								<?php foreach ($djs as $dj): ?>
									<div class="post col-lg-6 col-md-6 col-sm-12 col-xs-12 wow fadeInUp <?php foreach ($dj['categoria_ids'] as $categoria_id): ?>categoria-<?= htmlspecialchars($categoria_id) ?> <?php endforeach; ?>" data-wow-duration="2s" data-wow-delay="0.2s">
										<div class="">
											<div class="blog-media">
												<img src="/admin/<?= htmlspecialchars($dj['imagen_perfil']) ?>" alt="<?= htmlspecialchars($dj['dj_name']) ?>">
											</div>
											<div class="dlab-post-info">
												<div class="dlab-post-title">
													<h4 class="post-title font-weight-600">
														<a href="DJs-details.php?id=<?= htmlspecialchars($dj['id']) ?>">
															<?= htmlspecialchars($dj['dj_name']) ?>
														</a>
													</h4>
												</div>
												<div class="dlab-post-text">
													<p><?= htmlspecialchars(truncateWords($dj['info'], maxWords: 40)) ?></p>
												</div>
												<div class="dlab-post-readmore blog-share">
													<a href="DJs-details.php?id=<?= htmlspecialchars($dj['id']) ?>" title="View Profile" rel="bookmark" class="btn purple outline outline-2 radius-xl btn-aware m-b10">
														VIEW PROJECT<span></span>
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php else: ?>
								<p>No hay DJs disponibles.</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="section-full content-inner-2">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-6 wow fadeIn m-b30" data-wow-duration="2s" data-wow-delay="0.2s">
								<div class="about-slide owl-carousel owl-dots-none owl-none">
									<div class="item">
										<div class="dlab-media radius-md">
											<img src="images/about/pic1.webp" alt="VIONS creative team working on innovative designs" loading="lazy">
										</div>
									</div>
									<div class="item">
										<div class="dlab-media radius-md">
											<img src="images/about/pic2.webp" alt="Visual presentation of VIONS' services" loading="lazy">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 align-self-center">
								<div class="project-about-info">
									<h2 class="m-b20">We are VIONS: </h2>
									<h3>Where innovation, imagination, and groundbreaking sound converge to craft a visually and sonically stunning future.</h3>
								</div>
								<a href="portfolio.php" class="btn purple outline outline-2 radius-xl btn-aware m-r10 m-b10">VIEW PORTFOLIO<span></span></a>
								<a href="about-us.php" class="btn purple outline outline-2 radius-xl btn-aware m-b10">COMPANY HISTORY<span></span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="section-full video-bx overlay-black-dark bg-img-fix" style="background: #000000;">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 text-center text-white">
								<div class="containervid ">
									<video class="videopxh" autoplay loop muted>
										<source src="images/VIONS-VID.mp4" type="video/mp4">
										Tu navegador no soporta la etiqueta de video.
									</video>
								</div>
								<h2 class="video-title">Our passion for creativity and innovation</h2>
								<p class="video-content"> Is reflected in each of our services, including visual marketing, graphic design, branding, and international DJ bookings. We work hand in hand with our
									clients to create unique visual experiences, powerful brand strategies, and exceptional musical moments that capture the essence of each project. By integrating cutting-edge
									sound with striking visuals, we connect deeply with audiences and elevate every event to a new level of impact and engagement.</p>
								<a href="contact-us.php" class="btn purple outline outline-2 radius-xl btn-aware m-r10 m-b10">CONTACT US<span></span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<?php require_once('includes/footer.php'); ?>
	<script src="js/jquery.min.js"></script>
	<script src="plugins/imagesloaded/imagesloaded.js"></script>
	<script src="plugins/masonry/masonry-3.1.4.js"></script>
	<script src="plugins/masonry/masonry.filter.js"></script>
	<script src="plugins/wow/wow.js"></script><!-- WOW JS -->
	<script src="plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script><!-- FORM JS -->
	<script src="plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script><!-- FORM JS -->
	<script src="plugins/magnific-popup/magnific-popup.js"></script>
	<script src="plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
	<script src="plugins/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
	<script src="plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
	<script src="plugins/scroll/scrollbar.min.js"></script><!-- OWL SLIDER -->
	<script src="js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
	<script src="js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS -->
	<!-- revolution -->
	<script src="plugins/revolution/revolution/js/jquery.themepunch.tools.min.js"></script>
	<script src="plugins/revolution/revolution/js/jquery.themepunch.revolution.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.actions.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.migration.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
	<script src="plugins/revolution/revolution/js/extensions/revolution.extension.video.min.js"></script>
	<script src="js/rev.slider.js"></script>
	<script>
		jQuery(document).ready(function() {
			'use strict';
			dz_rev_slider_1();
		}); /*ready*/
	</script>
</body>

</html>