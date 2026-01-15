<?php
// Incluir el archivo que obtiene los datos de los DJs y categorías
$djFunctions = include('../src/actions/get-all-DJs.php');
$categoryFunctions = include('../src/actions/get-category.php');
$truncateWords = include_once('../src/actions/truncateWords.php');

$djs = obtenerDJs(true); // true para obtener solo los DJs activos

$djs = $djFunctions['obtenerDJs'];
$categorias = $categoryFunctions['getMusicCategories'](); // Solo categorías de música

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="international DJs, electronic music, music events, DJ booking, global talent, VIONS Global Sound, electronic artists" />
	<meta name="author" content="VIONS" />
	<meta name="robots" content="index, follow" />
	<meta name="description" content="VIONS Global Sound connects the most cutting-edge DJs with a global audience. Discover and collaborate with top electronic music talents for your events." />
	<meta name="format-detection" content="telephone=no">

	<meta property="og:title" content="VIONS Global Sound - Connecting DJs with the World" />
	<meta property="og:description" content="Explore the talent of the most innovative DJs and find the perfect sound for your event with VIONS Global Sound." />
	<meta property="og:image" content="https://www.vions.com.mx/images/banner/GLOBAL_SOUND.webp" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://www.vions.com.mx/global-sound" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:site_name" content="VIONS Global Sound" />

	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="VIONS Global Sound - Discover Innovative DJs" />
	<meta name="twitter:description" content="Find the perfect DJ for your event with VIONS Global Sound. Explore the best electronic music talents, from emerging artists to renowned DJs." />
	<meta name="twitter:image" content="https://www.vions.com.mx/images/banner/GLOBAL_SOUND.webp" />
	<meta name="twitter:site" content="@VIONSOfficial" />
	<meta name="twitter:creator" content="@VIONSOfficial" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon.png" />

	<title>VIONS Global Sound - Connecting DJs with the World</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
	<link rel="stylesheet" type="text/css" href="plugins/revolution/revolution/css/layers.css">
	<link rel="stylesheet" type="text/css" href="plugins/revolution/revolution/css/settings.css">
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
	<style>
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

		.morado-claro {
			color: #7E79D6;
		}
	</style>
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-area"></div>
		<header class="site-header header-transparent mo-left">
			<?php include('includes/navbar.php'); ?>
		</header>
		<div class="page-content">
			<div class="dlab-bnr-inr dlab-bnr-inr-sm overlay-black-middle bg-pt" style="background-image:url(images/banner/GLOBAL_SOUND.webp);">
				<div class="container">
					<div class="dlab-bnr-inr-entry">
						<h1 class="morado-claro">GLOBAL SOUND</h1>
					</div>
				</div>
			</div>
			<div class="content-block">
				<div class="container py-5">
					<div class="text-center">
						<h1 class="mb-4">VIONS Global Sound</h1>
						<h3 class="mb-4 text-dark fs-5 fw-light lh-base">Is the bridge between the most avant-garde DJs and the global audience.</h3>
						<h3 class="mb-4 fs-5 lh-base fw-bold text-primary">Offering a unique platform to discover and connect with international talents.</h3>
						<h3 class="text-dark fs-5 fw-light lh-base">
							Easily browse profiles of emerging and big-name DJs to find the perfect sound for your event.
						</h3>
					</div>
					<div class="text-center mt-4">
						<a href="contact-us.php" class="btn purple outline outline-2 radius-xl btn-aware">JOIN US<span></span></a>
					</div>
				</div>
				<div class="section-full content-inner-2">
					<div class="container">
						<div class="col-lg-12 text-center">
							<div class="site-filters filter-style1 clearfix m-b20">
								<ul class="filters" data-toggle="buttons">
									<li data-filter="" class="btn active"><input type="radio"><a href="#"><span>All</span></a></li>
									<?php foreach ($categorias as $categoria): ?>
										<li data-filter=".categoria-<?= htmlspecialchars($categoria['id']) ?>" class="btn">
											<input type="radio"><a href="#"><span><?= htmlspecialchars($categoria['nombre']) ?></span></a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>

						<div class="dlab-blog-grid-3 row" id="masonry">
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
														<a href="DJs.details.php?id=<?= htmlspecialchars($dj['id']) ?>">
															<?= htmlspecialchars($dj['dj_name']) ?>
														</a>
													</h4>
												</div>
												<div class="dlab-post-text">
													<p><?= htmlspecialchars(truncateWords($dj['info'], maxWords: 40)) ?></p>
												</div>
												<div class="dlab-post-readmore blog-share">
													<a href="DJs-details.php?id=<?= htmlspecialchars($dj['id']) ?>" title="View Profile" rel="bookmark" class="btn purple outline outline-2 radius-xl btn-aware m-b10">
														COLLABORATE NOW <span></span>
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
			</div>
		</div>
	</div>
	</div>
	<?php require_once('includes/footer.php'); ?>
	<script src="js/jquery.min.js"></script>
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
	<script src="js/custom.js"></script>
	<script src="js/dz.carousel.js"></script>
	<script>
		$(document).ready(function() {
			$('.filters li').click(function() {
				var filterValue = $(this).attr('data-filter');
				if (filterValue === '') {
					$('.post').show();
				} else {
					$('.post').hide();
					$(filterValue).show();
				}
				$('.filters li').removeClass('active');
				$(this).addClass('active');
			});
		});
	</script>
	</div>
</body>

</html>