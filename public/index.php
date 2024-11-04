<?php
$categorias = include('../actions/get-category.php');
$artistas = include('../actions/get-artists.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="Vions - Company" />
	<meta property="og:title" content="Vions - Company" />
	<meta property="og:description" content="Vions - Company" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON -->
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />

	<!-- PAGE TITLE HERE -->
	<title>VIONS</title>

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
	<script src="js/html5shiv.min.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	<!-- Fuentes -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100..900;1,100..900&family=Martian+Mono:wght@100..800&family=New+Amsterdam&family=SUSE:wght@100..800&display=swap" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Klee+One:wght@400;600&display=swap" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
	<!-- REVOLUTION SLIDER CSS -->
	<link rel="stylesheet" type="text/css" href="plugins/revolution/revolution/css/layers.css">
	<link rel="stylesheet" type="text/css" href="plugins/revolution/revolution/css/settings.css">
	<!-- <link rel="stylesheet" type="text/css" href="plugins/revolution/revolution/css/navigation.css">-->

	<!-- video css-->
	<style>
		/* Estilos para el contenedor */
		.containervid {
			position: relative;
			width: 640;
			height: 460px;
			background-color: black;
			/* Cuadro negro */
		}

		.videopxh {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
	</style>

</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-area"></div>

		<!-- Content -->
		<div class="page-content bg-white">
			<!-- header -->
			<header class="site-header header-transparent mo-left">

				<?php include('includes/navbar.php'); ?>
			</header>
			<!-- header END -->

			<!-- Slider -->
			<div class="main-slider style-two default-banner" id="home">
				<div class="tp-banner-container">
					<div class="tp-banner">
						<div id="welcome_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="reveal-add-on36" data-source="gallery" style="background:#000000;padding:0px;">
							<!-- START REVOLUTION SLIDER 5.4.7.2 fullscreen mode -->
							<div id="welcome" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.4.7.2">
								<ul> <!-- SLIDE  -->
									<li data-index="rs-100" data-transition="fadethroughdark" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="" data-rotate="0" data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
										<!-- MAIN IMAGE -->
										<img src="images/main-slider/dummy.png" alt="" data-lazyload="images/main-slider/slide4.png" data-bgposition="center center" data-kenburns="on" data-duration="4000" data-ease="Power3.easeInOut" data-scalestart="150" data-scaleend="100" data-rotatestart="0" data-rotateend="0" data-blurstart="0" data-blurend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="4" class="rev-slidebg" data-no-retina>
								</ul>
								<!-- <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>	</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Slider END -->
			<!-- header -->

			<!-- header END -->
			<div class="content-block">
				<!-- Project Info -->
				<div class="section-full content-inner-2">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-6 wow fadeIn m-b30" data-wow-duration="2s" data-wow-delay="0.2s">
								<div class="about-slide owl-carousel owl-dots-none owl-none">
									<div class="item">
										<div class="dlab-media radius-md">
											<img src="images/about/pic1.PNG" alt="">
										</div>
									</div>
									<div class="item">
										<div class="dlab-media radius-md">
											<img src="images/about/pic2.PNG" alt="">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 align-self-center">
								<div class="project-about-info">
									<h2 class="m-b20">We are VIONS: where innovation, imagination, and groundbreaking sound converge to craft a visually and sonically stunning future.</h2>
								</div>
								<a href="project-detail-3.php" class="btn purple outline outline-2 radius-xl btn-aware m-r10 m-b10">View Portfolio<span></span></a>
								<a href="CompanyHistory.php" class="btn purple outline outline-2 radius-xl btn-aware m-b10">Company History<span></span></a>
							</div>
						</div>
					</div>
				</div>
				<!-- Project Info End -->
				<!-- About Us -->
				<div class="section-full content-inner bg-gray">
					<div class="container">
						<div class="section-head text-center">
							<h2 class="head-title">Our Services</h2>
							<p>At VIONS, we are dedicated to promoting Mexican digital art in 3D and curating top Mexican DJs through our comprehensive services. From innovative visual designs to exclusive DJ bookings, we enhance your presence and impact at high-profile European events and parties.</p>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-6 m-b30">
								<div class="icon-bx-wraper sr-iconbox bg-white p-a30 text-center">
									<div class="icon-lg m-b20">
										<a href="javascript:void(0)" class="icon-cell"></a>
									</div>
									<div class="icon-content">
										<h4 class="dlab-tilte">Visual Marketing</h4>
										<p>Discover the power of visual marketing with VIONS! We merge the creativity of 3D graphic design with dynamic social
											media advertising strategies to create campaigns that not only capture attention, but inspire and connect with your audience.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 m-b30">
								<div class="icon-bx-wraper sr-iconbox bg-white p-a30 text-center">
									<div class="icon-lg m-b20">
										<a href="javascript:void(0)" class="icon-cell"></a>
									</div>
									<div class="icon-content">
										<h4 class="dlab-tilte">VIONS Global Sound</h4>
										<p>Through VIONS Global Sound, we showcase top-tier DJs, blending cutting-edge sound with exceptional booking services to create
											unforgettable experiences that redefine the international electronic music scene</p>
										<p></p>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 m-b30">
								<div class="icon-bx-wraper sr-iconbox bg-white p-a30 text-center">
									<div class="icon-lg m-b20">
										<a href="javascript:void(0)" class="icon-cell"></a>
									</div>
									<div class="icon-content">
										<h4 class="dlab-tilte">Branding</h4>
										<p>At VIONS, we help build and strengthen your brand identity. From creating logos to defining your company's voice and visual style, our comprehensive
											approach to branding ensures that your brand is consistent and recognizable across all customer touch points.</p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<!-- About Us End -->
				<!-- Video Section -->

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
								<a href="contact-us-1.html" class="btn purple radius-xl"><span class="text-white">Contact us</span></a>
							</div>
						</div>
					</div>
				</div>
				<!-- Video Section END -->

				<!-- Mostrador Designers -->
				<div class="section-full bg-white content-inner-1">
					<div class="container">
						<div class="section-head text-center">
							<h2 class="head-title">Our Designers</h2>
							<p>Whether you are a digital artist in search of new horizons...</p>
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
										<?php foreach ($artistas as $artista): ?>
											<li class="card-container col-lg-3 col-md-4 col-sm-6 p-lr0 categoria-<?= htmlspecialchars($artista['categoria_id']) ?>">
												<div class="dlab-media dlab-img-overlay1 dlab-img-effect portbox1">
													<img src="/<?= htmlspecialchars($artista['miniatura']) ?>" alt="Artista Miniatura" />
													<div class="overlay-bx">
														<div class="portinner">
															<span><?= htmlspecialchars($artista['categoria']) ?></span>
															<h3 class="port-title"><?= htmlspecialchars($artista['nombre']) ?></h3>
															<a href="portfolio.php?artist=<?= urlencode($artista['nombre']) ?>" class="btn outline white outline-2 radius-xl">Ir a portafolio</a>
														</div>
													</div>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>



							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Projects End -->
		<!-- Pricing Table -->
		<div class="section-full bg-white content-inner">
			<div class="container">
				<div class="section-head text-center">
					<h2 class="head-title">Join Us</h2>
					<p>At VIONS, we seamlessly blend innovative design and exceptional DJ talent, offering a unique platform that connects visionary digital artists and top-tier Mexican DJs with high-profile
						European events. Elevate your next event with our creative expertise and musical excellence.</p>
					<a href="" class="btn purple primary radius-xl"><span class="text-white">Contact Us</span></a>
				</div>
			</div>
		</div>
	</div>
	<!-- Content END-->

	</div>
	<!--Footer -->
	<?php include('includes/footer.php'); ?>
	<!-- Footer END -->
	<!-- JAVASCRIPT FILES ========================================= -->

	<script src="js/jquery.min.js"></script>
	<script src="plugins/imagesloaded/imagesloaded.js"></script>
	<script src="plugins/masonry/masonry-3.1.4.js"></script>
	<script src="plugins/masonry/masonry.filter.js"></script>

	<script src="plugins/wow/wow.js"></script><!-- WOW JS -->
	<script src="plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script><!-- FORM JS -->
	<script src="plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script><!-- FORM JS -->
	<script src="plugins/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
	<script src="plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
	<script src="plugins/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
	<script src="plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
	<script src="plugins/scroll/scrollbar.min.js"></script><!-- OWL SLIDER -->
	<script src="js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
	<script src="js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS -->
	<script src="js/dz.ajax.js"></script><!-- CONTACT JS  -->


	<!-- revolution -->
	<script src="plugins/revolution/revolution/js/jquery.themepunch.tools.min.js"></script>
	<script src="plugins/revolution/revolution/js/jquery.themepunch.revolution.min.js"></script>

	<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems ! The following part can be removed on Server for On Demand Loading) -->
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