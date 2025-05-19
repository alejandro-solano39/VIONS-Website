<?php
// Incluir el archivo que obtiene los detalles del DJ
$path = realpath(__DIR__ . '/../actions/get-DJs-details.php');
if (!$path) {
	die("Error: No se encontró el archivo get-dj-details.php en " . __DIR__);
}
include_once($path);

// Obtener el ID del DJ desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
echo "ID recibido: " . $id . "<br>";

// Obtener los detalles del DJ
$dj = getDJDetails($id);

if (!$dj) {
	die("<h1>Error: DJ no encontrado</h1>");
}

// Decodificar campos JSON si es necesario
$slider_images = json_decode($dj['slider_images'], true);
$social_links = json_decode($dj['social_links'], true);
$latest_tracks = json_decode($dj['latest_tracks'], true);

// Si no existe la columna "generos", puedes omitirla o reemplazarla con otra columna
$generos = isset($dj['generos']) ? explode(',', $dj['generos']) : [];
$music_releases = isset($dj['music_release']) ? explode(',', $dj['music_release']) : [];
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
	<title>VIONS - <?php echo htmlspecialchars($dj['dj_name']); ?></title>

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-area">
			<div class="loading-spinner"></div>
		</div>

		<header class="site-header header-transparent mo-left">
			<?php include('includes/navbar.php'); ?>
		</header>
		<div class="page-content bg-white">
			<!-- Imagen miniatura y nombre dj -->
			<div class="dlab-bnr-inr dlab-bnr-inr-sm overlay-black-middle bg-pt" style="background-image:url(/admin/<?php echo htmlspecialchars($dj['miniatura']); ?>);">
				<div class="container">
					<div class="dlab-bnr-inr-entry">
						<h1 class="text-white"><?php echo htmlspecialchars($dj['dj_name']); ?></h1>
					</div>
				</div>
			</div>
			<div class="content-block">
				<!-- About Us -->
				<div class="section-full content-inner bg-white">
					<div class="container">
						<div class="row">
							<div class="col-xl-8 col-lg-7 col-md-12 m-b10">
								<div class="blog-post blog-single blog-post-style-2 sidebar">
									<div class="dlab-post-info">
										<div class="dlab-post-title">
											<!-- Titulo -->
											<h2 class="post-title"><?php echo htmlspecialchars($dj['post_title']); ?></h2>
										</div>
										<div class="dlab-post-text text">
											<p><?php echo nl2br(htmlspecialchars($dj['info'])); ?></p>
											<div class="our-gallery">
												<img src="/admin/<?php echo htmlspecialchars($dj['imagen_perfil']); ?>" class="m-b30 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.6s" alt="">
											</div>
											<!-- Carrusel de imágenes -->
											<div class="section-full content-inner-1 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
												<div class="container-fluid">
													<div class="project-carousel owl-btn-center-lr owl-carousel mfp-gallery">
														<?php foreach ($slider_images as $image) { ?>
															<div class="item">
																<div class="dlab-box portfolio-bx style2 project-media">
																	<div class="dlab-media dlab-img-overlay1 dlab-img-effect">
																		<a href="javascript:void(0);"> <img src="images/DJ/<?php echo htmlspecialchars($image); ?>" alt=""> </a>
																		<div class="overlay-bx">
																			<a href="images/DJ/<?php echo htmlspecialchars($image); ?>" class="mfp-link" title="Title Come Here"><i class="ti-zoom-in"></i></a>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>
													</div>
												</div>
											</div>
											<br></br>
											<p><?php echo nl2br(htmlspecialchars($dj['info'])); ?></p>
										</div>
										<div class="dlab-post-tags d-flex">
											<div class="post-tags">
												Tags:
												<?php foreach ($generos as $genero) { ?>
													<a href="javascript:void(0);"><?php echo htmlspecialchars($genero); ?></a>
												<?php } ?>
											</div>
											<!-- Redes Sociales -->
											<div class="share-post ml-auto">
												<ul class="slide-social">
													<li>Share:</li>
													<li><a target="_blank" href="<?php echo htmlspecialchars($social_links['facebook']); ?>"><i class="fa fa-facebook"></i></a></li>
													<li><a target="_blank" href="<?php echo htmlspecialchars($social_links['instagram']); ?>"><i class="fa fa-instagram"></i></a></li>
													<li><a target="_blank" href="<?php echo htmlspecialchars($social_links['spotify']); ?>"><i class="fa fa-spotify"></i></a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Anuncios y últimas pistas -->
							<div class="col-xl-4 col-lg-5 col-md-12">
								<div class="side-bar sticky-top">
									<div class="widget widget-bx widget_archive">
										<h5 class="widget-title">MUSIC RELEASES:</h5>
										<ul>
											<?php foreach ($music_releases as $release) { ?>
												<li><a href="javascript:void(0)"><?php echo htmlspecialchars($release); ?></a></li>
											<?php } ?>
										</ul>
									</div>
									<!-- Últimas pistas -->
									<div class="widget widget-bx recent-posts-entry">
										<h5 class="widget-title">LATEST TRACKS</h5>
										<div class="widget-post-bx">
											<?php foreach ($latest_tracks as $track) { ?>
												<div class="widget-post clearfix">
													<div class="dlab-post-media">
														<img src="images/DJ/<?php echo htmlspecialchars($track['imagen']); ?>" alt="" width="200" height="143">
													</div>
													<div class="dlab-post-info">
														<h6 class="post-title"><a href="javascript:void(0)"><?php echo htmlspecialchars($track['nombre']); ?></a></h6>
														<div class="dlab-post-name">
															<a href="javascript:void(0)" class="site-button-link"><?php echo htmlspecialchars($dj['dj_name']); ?></a>
														</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
									<!-- Géneros musicales -->
									<div class="widget widget-bx widget_tag_cloud radius">
										<h5 class="widget-title">GENRES</h5>
										<div class="tagcloud">
											<?php foreach ($generos as $genero) { ?>
												<a href="javascript:void(0);"><?php echo htmlspecialchars($genero); ?></a>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require_once('includes/footer.php'); ?>

	<!-- JAVASCRIPT FILES ========================================= -->
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
	<script src="js/dz.ajax.js"></script><!-- CONTACT JS  -->
	
</body>

</html>