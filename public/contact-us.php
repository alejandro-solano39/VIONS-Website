<?php
$artistas = include('../src/actions/get-artists.php');

// Filtrar artistas activos
$artistas = array_filter($artistas, function ($artista) {
	return isset($artista['activo']) && $artista['activo'] == 1;
});

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="VIONS: Innovating in marketing and design through unique visions and sonic experiences. Redefine your brand with our creative and impactful solutions." />
	<meta name="keywords" content="VIONS, innovative marketing, sonic experiences, unique design, brand identity, visual creativity, futuristic design, sound art" />
	<meta name="author" content="VIONS" />
	<meta name="robots" content="index, follow" />
	<link rel="canonical" href="https://www.vions.com.mx/">
	<meta property="og:title" content="VIONS - Innovative Marketing & Design" />
	<meta property="og:description" content="Experience how VIONS transforms brands with innovative concepts, blending visual creativity and sound experiences for extraordinary results." />
	<meta property="og:image" content="https://www.vions.com.mx/images/Vionslg.png" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://www.vions.com.mx" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:site_name" content="VIONS" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="VIONS - Innovative Marketing & Design" />
	<meta name="twitter:description" content="Explore how VIONS redefines marketing and design through unique innovations and sonic experiences." />
	<meta name="twitter:image" content="https://www.vions.com.mx/images/Vionslg.png" />
	<meta name="twitter:site" content="@VIONSOfficial" />
	<meta name="twitter:creator" content="@VIONSOfficial" />
	<link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />
	<title>VIONS - Unique Innovations for Unique Visions</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
	<link rel="stylesheet" type="text/css" href="css/plugins.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="css/skin/skin-1.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
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
<style>
	.card-form {
		background: #ffffff;
		border-radius: 10px;
		padding: 40px 30px;
		box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
		margin: 40px 0;
		width: 100%;
		box-sizing: border-box;
	}

	.card-form h2 {
		font-size: 28px;
		color: #333;
		margin-bottom: 20px;
		text-align: center;
	}

	.form-group {
		margin-bottom: 20px;
		position: relative;
	}

	.input-field,
	.select-field,
	textarea {
		width: 100%;
		padding: 15px 50px 15px 50px;
		font-size: 16px;
		border: 1px solid #ccc;
		border-radius: 8px;
		box-sizing: border-box;
		background: #f9f9f9;
		color: #333;
		transition: border-color 0.3s;
	}

	.input-field:focus,
	.select-field:focus,
	textarea:focus {
		border-color: #6f42c1;
		outline: none;
	}

	textarea {
		min-height: 120px;
		resize: vertical;
	}

	.input-icon {
		position: absolute;
		left: 20px;
		top: 50%;
		transform: translateY(-50%);
		font-size: 18px;
		color: #aaa;
		pointer-events: none;
	}

	.input-field:focus~.input-icon,
	.select-field:focus~.input-icon,
	textarea:focus~.input-icon {
		color: #6f42c1;
	}

	.submit-btn {
		display: block;
		margin: 0 auto;
		width: auto;
		background: #6f42c1;
		color: #fff;
		padding: 15px;
		border: none;
		border-radius: 30px;
		font-size: 16px;
		font-weight: bold;
		cursor: pointer;
		transition: background 0.3s ease;
	}

	.submit-btn:hover {
		background: #643cad;
	}

	.submit-btn:active {
		transform: scale(0.98);
	}

	@media (max-width: 768px) {
		.card-form {
			padding: 20px;
		}

		.card-form h2 {
			font-size: 24px;
		}

		.input-field,
		.select-field,
		textarea {
			padding: 12px 40px;
			font-size: 14px;
		}

		.input-icon {
			left: 10px;
			font-size: 16px;
		}

		.submit-btn {
			font-size: 15px;
		}
	}
</style>

<body id="bg">
	<div class="page-wraper">
		<div id="overlay" style="display: none;">
			<div class="spinner"></div>
		</div>
		<header class="site-header header-transparent mo-left">
			<?php require_once('includes/navbar.php'); ?>
		</header>
		<div class="page-content bg-white">
			<div class="dlab-bnr-inr dlab-bnr-inr-sm overlay-black-middle bg-pt" style="background-image:url(images/img-portada/Vions_Portada.webp);" alt="Lazy loading image" loading="lazy">
				<div class="container">
					<div class="dlab-bnr-inr-entry">
						<h1 class="text-white">¡Connect with VIONS!</h1>
					</div>
				</div>
			</div>
			<div class="content-block">
				<div class="section-full content-inner-1">
					<div class="container-fluid">
						<div class="section-head text-center">
							<h2 class="head-title">Always Help You</h2>
							<p style="font-size: 1.8rem; font-weight: bold;">We are here to help you create unique multisensory experiences.</p>
						</div>
						<section class="banner-map">
							<div id="map" style="width:100%; height:400px;"></div>
						</section>
					</div>
				</div>

				<div class="section-full content-inner-2 contact-box">
					<div class="container">
						<div class="row align-items-center m-b50">
							<div class="col-lg-4 col-md-4 col-sm-6">
								<div class="icon-bx-wraper m-b30 left">
									<div class="icon-md m-b20 m-t5">
										<a href="javascript:void(0)" class="icon-cell text-white">
											<i class="ti-headphone-alt"></i>
										</a>
									</div>

									<div class="icon-content">
										<h4 class="dlab-tilte m-b5">Phone</h4>
										<p>Phone: (+52) 4774671061</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6">
								<div class="icon-bx-wraper m-b30 left">
									<div class="icon-md m-b20 m-t5">
										<a href="javascript:void(0)" class="icon-cell text-white">
											<i class="ti-location-pin"></i>
										</a>
									</div>
									<div class="icon-content">
										<h4 class="dlab-tilte m-b5">Address</h4>
										<p class="justify-content-center">Mexico:
											Creative & Operations Team
											<br>
											France:
											International Collaborations Network
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="icon-bx-wraper m-b30 left">
									<div class="icon-md m-b20 m-t5">
										<a href="javascript:void(0)" class="icon-cell text-white">
											<i class="ti-email"></i>
										</a>
									</div>
									<div class="icon-content">
										<h4 class="dlab-tilte m-b5">Email</h4>
										<p>info@vions.com.mx</p>
									</div>
								</div>
							</div>
						</div>
						<div class="section-head text-center">
							<h2 class="head-title">Ready to Create Unique Experiences?</h2>
							<p style="font-size: 1.5rem; font-weight: bold;">Connect with VIONS and transform your vision into a multisensory reality</p>
						</div>
						<div class="dzFormMsg"></div>
						<form method="post" class="card-form" action="script/send_email.php" accept-charset="UTF-8" novalidate>

							<div class="form-group">
								<input name="dzName" type="text" required class="input-field" placeholder="Your Name">
								<i class="fas fa-user input-icon"></i>
							</div>
							<div class="form-group">
								<input name="dzEmail" type="email" required class="input-field" placeholder="Your Email">
								<i class="fas fa-envelope input-icon"></i>
							</div>

							<div class="form-group">
								<select name="formCategory" class="select-field" required>
									<option value="">Select Category</option>
									<?php foreach ($artistas as $artista): ?>
										<option value="<?= htmlspecialchars($artista['id']) ?>"><?= htmlspecialchars($artista['nombre']) ?></option>
									<?php endforeach; ?>
									<option value="Press">Collaborations</option>
									<option value="Press">Visual Marketing</option>
									<option value="Press">Press</option>
									<option value="Others">Others</option>
								</select>
								<i class="fas fa-list input-icon"></i>
							</div>
							<div class="form-group">
								<textarea name="dzMessage" required placeholder="Your Message" class="input-field"></textarea>
								<i class="fas fa-comments input-icon"></i>
							</div>
							<div class="form-group">
								<button type="submit" class="submit-btn">Send Message</button>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
		<?php include('includes/footer.php'); ?>

	</div>
	<script src="js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
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
	<script src="js/dz.ajax.js"></script><!-- CONTACT JS  -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const map = L.map('map').setView([30, -30], 2);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attribution: '© OpenStreetMap contributors'
			}).addTo(map);

			const locationMexico = [19.432608, -99.133209];
			const locationFrancia = [48.856613, 2.352222];
			L.marker(locationMexico).addTo(map).bindPopup('Ciudad de México, México');
			L.marker(locationFrancia).addTo(map).bindPopup('París, Francia');
		});

		document.addEventListener("DOMContentLoaded", function() {
			const form = document.querySelector("form.card-form");
			const submitButton = form.querySelector(".submit-btn");

			if (form) {
				form.addEventListener("submit", function(event) {
					event.preventDefault();
					submitButton.disabled = true;
					submitButton.textContent = "Sending...";
					console.log("Form submitted, waiting for response...");

					Swal.fire({
						title: 'Sending...',
						text: 'We are sending your message, please wait.',
						icon: 'info',
						showConfirmButton: false,
						allowOutsideClick: false,
						didOpen: () => {
							setTimeout(() => {
								console.log("Simulating success...");
								Swal.fire({
									title: 'Success!',
									text: 'Your message has been sent successfully.',
									icon: 'success',
									confirmButtonText: 'OK'
								}).then(() => {
									form.submit();
								});
							}, 2000);
						}
					});
				});
			}
		});


		document.addEventListener("DOMContentLoaded", function() {
			const params = new URLSearchParams(window.location.search);
			const designerId = params.get("id");

			if (designerId) {
				// Selecciona la categoría del artista basado en el ID
				const categorySelect = document.querySelector('select[name="formCategory"]');
				categorySelect.value = designerId;
			}

			// Deshabilitar la categoría "Booking" si existe
			const bookingOption = categorySelect.querySelector('option[value="Booking"]');
			if (bookingOption) {
				bookingOption.disabled = true;
			}
		});
	</script>

</body>

</html>