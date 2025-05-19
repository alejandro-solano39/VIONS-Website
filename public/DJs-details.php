<?php
include_once(__DIR__ . '/../config/config.php');
session_start(); // Para almacenar el token de Spotify

function obtenerConexion()
{
	static $conn = null;
	if ($conn === null) {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($conn->connect_error) {
			die("Conexión fallida: " . $conn->connect_error);
		}
	}
	return $conn;
}
// Obtener información del DJ por ID
function obtenerDJPorId($id)
{
	$conn = obtenerConexion();
	$sql = "SELECT d.*, COALESCE(GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', '), '') AS generos
            FROM djs_portfolios d
            LEFT JOIN dj_categories dc ON d.id = dc.dj_id
            LEFT JOIN category c ON dc.category_id = c.id
            WHERE d.id = ?
            GROUP BY d.id";

	$stmt = $conn->prepare($sql);
	if (!$stmt) {
		die("Error en la consulta: " . $conn->error);
	}

	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$dj = $result->fetch_assoc();
	$stmt->close();

	if ($dj) {
		$dj['generos'] = explode(', ', $dj['generos']);
	} else {
		$dj['generos'] = [];
	}

	return $dj;
}

// Obtener el ID del DJ desde la URL
$idDJ = isset($_GET['id']) ? intval($_GET['id']) : 0;
$dj = obtenerDJPorId($idDJ);

if (!$dj) {
	die("DJ no encontrado.");
}

function obtenerTokenSpotify()
{
	if (isset($_SESSION['spotify_token']) && $_SESSION['spotify_expires'] > time()) {
		return $_SESSION['spotify_token'];
	}

	$clientId = '74ca485d10604d30a0af80329ddd1cd7';
	$clientSecret = 'fbdab135157e4cf6a8cea7692104d72d';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret)
	]);
	$response = curl_exec($ch);
	curl_close($ch);

	$tokenData = json_decode($response, true);
	$_SESSION['spotify_token'] = $tokenData['access_token'];
	$_SESSION['spotify_expires'] = time() + $tokenData['expires_in'];

	return $tokenData['access_token'];
}

function obtenerInfoSpotify($url)
{
	$urlParts = explode('/', $url);
	$resourceId = end($urlParts);
	$accessToken = obtenerTokenSpotify();

	if (strpos($url, '/track/') !== false) {
		$apiUrl = 'https://api.spotify.com/v1/tracks/' . $resourceId;
	} elseif (strpos($url, '/album/') !== false) {
		$apiUrl = 'https://api.spotify.com/v1/albums/' . $resourceId;
	} else {
		return ['error' => 'URL no válida'];
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $apiUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Authorization: Bearer ' . $accessToken
	]);
	$response = curl_exec($ch);
	curl_close($ch);

	$data = json_decode($response, true);

	if (isset($data['images'][0]['url'])) {
		$data['album_image'] = $data['images'][0]['url'];
	}

	return $data;
}

function obtenerIframeSoundCloud($url)
{
	$api_url = "https://soundcloud.com/oembed?format=json&url=" . urlencode($url);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $api_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	$response = curl_exec($ch);
	curl_close($ch);

	$data = json_decode($response, true);
	$title = $data['title'] ?? 'Unknown Title';

	return '
    <div class="soundcloud-track">
        <h6 class="track-title">' . htmlspecialchars($title) . '</h6>
        <iframe 
            width="100%" 
            height="150" 
            scrolling="no" 
            frameborder="no" 
            allow="autoplay" 
            src="https://w.soundcloud.com/player/?url=' . urlencode($url) . '&color=%23ff5500&inverse=false&auto_play=false&show_user=true">
        </iframe>
    </div>';
}

// Decodificar las pistas recientes del DJ
$latestTracks = json_decode($dj['latest_tracks'], true);
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
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />

	<title>VIONS - <?php echo htmlspecialchars($dj['dj_name']); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

	<style>
		.our-gallery img {
			width: 100%;
			height: 300px;
			max-width: 100%;
			object-fit: cover;
			display: block;
			margin: 20px auto;
			border-radius: 10px;
		}

		.project-carousel {
			width: 100%;
			max-width: 100%;
			margin: 0 auto;
			overflow: hidden;
		}

		.project-carousel .dlab-media img {
			width: 100%;
			height: 400px;
			object-fit: cover;
			border-radius: 10px;
		}

		.project-carousel .item {
			margin: 0 10px;
		}

		.dlab-post-media iframe {
			width: 100%;
			max-width: 100%;
			border-radius: 10px;
		}

		.music-releases-container {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.music-release-item {
			display: flex;
			align-items: center;
			background: #f8f9fa;
			border-radius: 8px;
			padding: 8px;
			text-decoration: none;
			color: #333;
			transition: background 0.3s ease;
			border: 1px solid #ddd;
		}

		.music-release-item:hover {
			background: #e9ecef;
		}

		.music-release-favicon {
			width: 24px;
			height: 24px;
			border-radius: 4px;
			margin-right: 8px;
		}

		.music-release-title {
			font-size: 14px;
			font-weight: bold;
			color: #007bff;
		}
	</style>

</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-area"></div>
		<header class="site-header header-transparent mo-left">
			<?php include('includes/navbar.php'); ?>
		</header>
		<div class="page-content bg-white">
			<!-- Imagen portada y nombre dj -->
			<div class="dlab-bnr-inr dlab-bnr-inr-sm overlay-black-middle bg-pt"
				style="background-image: url('/admin/<?php echo htmlspecialchars($dj['cover_image']); ?>');">
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
									</div>
									<div class="dlab-post-info">
										<!-- Información -->
										<div class="dlab-post-text text">
											<p><?php echo nl2br(htmlspecialchars($dj['info'])); ?></p>
											<!-- miniatura -->

											<div class="our-gallery">
												<img src="/admin/<?php echo htmlspecialchars($dj['miniatura']); ?>"
													class="m-b30 wow fadeIn"
													data-wow-duration="2s"
													data-wow-delay="0.6s"
													alt="Imagen de <?php echo htmlspecialchars($dj['dj_name']); ?>">
											</div>

											<div class="section-full content-inner-1 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
												<div class="container-fluid">
													<div class="project-carousel owl-btn-center-lr owl-carousel mfp-gallery">
														<?php
														$sliderImages = json_decode($dj['slider_images'], true);
														if ($sliderImages) {
															foreach ($sliderImages as $image) {
																echo '<div class="item">
                            								<div class="dlab-box portfolio-bx style2 project-media">
                                								<div class="dlab-media dlab-img-overlay1 dlab-img-effect">
                                    									<a href="javascript:void(0);"> 
                                        									<img src="/admin/' . htmlspecialchars($image) . '" alt=""> 
                                    									</a>
                                   									<div class="overlay-bx">
                                        							<a href="/admin/' . htmlspecialchars($image) . '" class="mfp-link" title="" >
                                            							<i class="ti-zoom-in"></i>
                                       								</a>
                                    							</div>
                                								</div>
                            								</div>
                       									</div>';
															}
														}
														?>
													</div>
												</div>
											</div>

											<br></br>
											<br></br>
											<!-- Texto personalizado -->
											<div class="vions-celebration-text">
												<?php if (!empty($dj['custom_text'])): ?>
													<p><?php echo nl2br(htmlspecialchars($dj['custom_text'])); ?></p>
												<?php else: ?>
													<p>At VIONS, we celebrate <?php echo htmlspecialchars($dj['dj_name']); ?>'s vision of transforming the sound space into a unique and unforgettable experience. His passion for music and his ability to emotionally connect with the audience are a reflection of the innovative spirit we seek to promote.</p>
												<?php endif; ?>
											</div>
										</div>
										<div class="dlab-post-tags d-flex">
											<div class="post-tags">
												<ul class="slide-social list-unstyled d-flex align-items-center gap-2 m-0">


													<li class="fw-bold">Tags:</li>

													<?php
													foreach ($dj['generos'] as $genero) {
														echo '<a href="javascript:void(0);">' . htmlspecialchars($genero) . '</a>';
													}
													?>
												</ul>
											</div>
											<!-- Redes Sociales -->
											<div class="share-post ml-auto">
												<ul class="slide-social list-unstyled d-flex align-items-center gap-2 m-0">
													<li class="fw-bold">Social networks:</li>
													<?php
													$socialLinks = json_decode($dj['social_links'], true);
													if (!empty($socialLinks)) {
														$faIcons = [
															'facebook'   => 'fa-brands fa-facebook',
															'twitter'    => 'fa-brands fa-x-twitter',
															'instagram'  => 'fa-brands fa-instagram',
															'youtube'    => 'fa-brands fa-youtube',
															'soundcloud' => 'fa-brands fa-soundcloud',
															'spotify'    => 'fa-brands fa-spotify',
															'tiktok'     => 'fa-brands fa-tiktok',
														];

														foreach ($socialLinks as $platform => $link) {
															// Deteccion de la red social por su URL
															$platformName = '';

															if (strpos($link, 'facebook.com') !== false) {
																$platformName = 'facebook';
															} elseif (strpos($link, 'twitter.com') !== false || strpos($link, 'x.com') !== false) {
																$platformName = 'twitter';
															} elseif (strpos($link, 'instagram.com') !== false) {
																$platformName = 'instagram';
															} elseif (strpos($link, 'youtube.com') !== false) {
																$platformName = 'youtube';
															} elseif (strpos($link, 'soundcloud.com') !== false) {
																$platformName = 'soundcloud';
															} elseif (strpos($link, 'spotify.com') !== false) {
																$platformName = 'spotify';
															} elseif (strpos($link, 'tiktok.com') !== false) {
																$platformName = 'tiktok';
															}

															$iconClass = isset($faIcons[$platformName]) ? $faIcons[$platformName] : 'fa-solid fa-share';

															echo '<li>
                        									<a target="_blank" href="' . htmlspecialchars($link) . '" class="text-dark d-flex align-items-center">
                            								<i class="' . htmlspecialchars($iconClass) . ' me-1"></i>
                       										 </a>
                      										</li>';
														}
													} else {
														echo '<li>No social links available</li>';
													}
													?>
												</ul>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-5 col-md-12">
								<div class="side-bar sticky-top">
									<div class="widget widget-bx widget_archive">
										<h5 class="widget-title">MUSIC RELEASES:</h5>
										<div class="music-releases-container">
											<?php
											$musicReleases = json_decode($dj['music_release'], true);
											if ($musicReleases) {
												foreach ($musicReleases as $release) {
													$url = (strpos($release, 'http') === 0) ? $release : 'https://' . $release;
													$parsedUrl = parse_url($url);
													$domain = $parsedUrl['host'] ?? $url;

													echo '
                <a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer" class="music-release-item">
                    <img src="https://www.google.com/s2/favicons?sz=64&domain=' . $domain . '" alt="Favicon" class="music-release-favicon">
                    <span class="music-release-title">' . htmlspecialchars($domain) . '</span>
                </a>';
												}
											}
											?>
										</div>
									</div>


									<div class="widget widget-bx recent-posts-entry">
										<h5 class="widget-title">LATEST TRACKS</h5>
										<div class="widget-post-bx">
											<?php
											if ($latestTracks) {
												foreach ($latestTracks as $track) {
													if (strpos($track, 'spotify.com') !== false) {
														$trackInfo = obtenerInfoSpotify($track);
														if ($trackInfo && isset($trackInfo['album']['images'][0]['url'])) {
															echo '<div class="widget-post clearfix">
																<div class="dlab-post-media">
																	<img src="' . $trackInfo['album']['images'][0]['url'] . '" alt="" width="200" height="143">
																</div>
																<div class="dlab-post-info">
																	<div class="dlab-post-header">
																		<h6 class="post-title"><a href="' . $track . '">' . $trackInfo['name'] . '</a></h6>
																	</div>
																	<div class="dlab-post-name">
																		<a href="' . $track . '" class="site-button-link">' . $dj['dj_name'] . '</a>
																	</div>
																</div>
															</div>';
														} else {
															echo '<div class="widget-post clearfix">
																<div class="dlab-post-media">
																	<img src="images/DJ/Gall1.png" alt="" width="200" height="143">
																</div>
																<div class="dlab-post-info">
																	<div class="dlab-post-header">
																		<h6 class="post-title"><a href="' . $track . '">' . $track . '</a></h6>
																	</div>
																	<div class="dlab-post-name">
																		<a href="' . $track . '" class="site-button-link">' . $dj['dj_name'] . '</a>
																	</div>
																</div>
															</div>';
														}
													} elseif (strpos($track, 'soundcloud.com') !== false) {
														echo '<div class="widget-post clearfix full-width">
															' . obtenerIframeSoundCloud($track) . '
														</div>';
													} else {
														echo '<div class="widget-post clearfix">
															<div class="dlab-post-media">
																<img src="images/DJ/Gall1.png" alt="" width="200" height="143">
															</div>
															<div class="dlab-post-info">
																<div class="dlab-post-header">
																	<h6 class="post-title"><a href="' . $track . '">' . $track . '</a></h6>
																</div>
																<div class="dlab-post-name">
																	<a href="' . $track . '" class="site-button-link">' . $dj['dj_name'] . '</a>
																</div>
															</div>
														</div>';
													}
												}
											}
											?>
										</div>
									</div>

									<div class="widget widget-bx widget_tag_cloud radius">
										<h5 class="widget-title">GENRES</h5>
										<div class="tagcloud">
											<?php foreach ($dj['generos'] as $genero) { ?>
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
	<script src="js/dz.ajax.js"></script>
	<script>
		$(document).ready(function() {
			$(".project-carousel").owlCarousel({
				loop: true,
				margin: 10,
				nav: true,
				responsive: {
					0: {
						items: 1
					},
					600: {
						items: 2
					},
					1000: {
						items: 3
					}
				}
			});
		});
	</script>
</body>

</html>