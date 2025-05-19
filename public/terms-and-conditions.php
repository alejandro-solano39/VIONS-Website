<?php
$categorias = include('../actions/get-category.php');
$artistas = include('../actions/get-artists.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore VIONS' Terms and Conditions to understand the guidelines and policies for using our innovative marketing and design services." />
    <meta name="keywords" content="VIONS, terms and conditions, service guidelines, policies, innovative marketing, design services, sonic experiences" />
    <meta name="author" content="VIONS" />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="https://www.vions.com.mx/">
    <meta property="og:title" content="VIONS - Terms and Conditions" />
    <meta property="og:description" content="Read VIONS' Terms and Conditions to learn more about the policies governing our innovative services in marketing and design." />
    <meta property="og:image" content="https://www.vions.com.mx/images/Vionslg.png" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.vions.com.mx/terms-and-conditions" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="VIONS" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="VIONS - Terms and Conditions" />
    <meta name="twitter:description" content="Discover the Terms and Conditions for using VIONS' innovative marketing and design services. Read the policies governing our services." />
    <meta name="twitter:image" content="https://www.vions.com/images/Vionslg.png" />
    <meta name="twitter:site" content="@VIONSOfficial" />
    <meta name="twitter:creator" content="@VIONSOfficial" />
    <link rel="icon" href="images/Vionslg.png" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="images/Vionslg.png" />
    <title>VIONS - Terms and Conditions</title>
    <link rel="stylesheet" type="text/css" href="css/plugins.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/templete.css">
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
        .definitions-list {
            list-style: none;
            padding: 0;
            margin: 0 auto;
            text-align: center;
            max-width: 800px;
            color: #777784;
        }

        .definitions-list li {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .definitions-list li::before {
            content: "•";
            color: #630B23;
            ;
            font-size: 1.5rem;
            font-weight: bold;
            margin-right: 10px;
        }

        .definitions-list .sub-list {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        .definitions-list .sub-list li {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 10px;
        }

        .definitions-list .sub-list li::before {
            content: "○";
            color: #630B23;
            ;
            font-size: 1.2rem;
            font-weight: bold;
            margin-right: 10px;
        }

        .highlight {
            background-color: #5651b1;
            padding: 5px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
    </style>

</head>

<body id="bg">
    <div class="page-wraper">
        <div id="loading-area"></div>
        <header class="site-header bg-white mo-left">
            <?php include_once('includes/navbar.php'); ?>
        </header>
        <div class="page-content bg-white">
            <div class="dlab-bnr-inr dlab-bnr-inr-sm overlay-black-middle bg-pt"
                style="background-image:url(images/banner/bnr1.webp);">
                <div class="container">
                    <div class="dlab-bnr-inr-entry">
                        <h1 class="text-white">Terms and Conditions of VIONS</h1>
                    </div>
                </div>
            </div>
            <div class="section-full content-inner">
                <div class="container">
                    <div class="section-head text-center">
                        <h3 class="head-title">1. Introduction
                        </h3>
                        <p>Welcome to VIONS. By accessing and using our platform, you agree to comply with these
                            Terms and Conditions. These terms govern the use of our website and associated services, so
                            we recommend you read them carefully. If you do not agree with any of these terms, please
                            refrain from using our site.
                            VIONS reserves the right to modify these Terms and Conditions at any time, notifying users
                            by
                            publishing the updated version on our website.
                        </p>
                        <h3>2. Definitions</h3>
                        <p>For the purposes of these Terms and Conditions, the following definitions apply:</p>
                        <ul class="definitions-list">
                            <li>
                                <strong class="highlight">“VIONS”:</strong> The platform, brand, and services we offer.
                            </li>
                            <li>
                                <strong class="highlight">“User”:</strong> Any person who accesses, browses, or uses the
                                services on our platform.
                            </li>
                            <li>
                                <strong class="highlight">“Content”:</strong> Any material available on the site,
                                including texts, images, videos, graphics, and design.
                            </li>
                        </ul>
                        <h3>3. Intellectual Property</h3>
                        <p>All intellectual property rights over the content on this site, including designs, logos,
                            graphics,
                            videos, and texts, are the exclusive property of VIONS or its respective creators, who have
                            granted us a license for their use.
                            It is strictly prohibited to reproduce, distribute, modify, transmit, or use any content
                            from this
                            site without prior written authorization from VIONS.</p>
                        <h3 style="text-align: center;">4. Permitted Use of the Site</h3>
                        <p style="text-align: center;">By using our platform, you agree to:</p>
                        <ul class="definitions-list">
                            <li>Use the site and its services solely for lawful purposes.</li>
                            <li>Provide truthful and complete information in the forms or registrations you complete on the platform.</li>
                            <h6 class="highlight">Refrain from:</h6>
                            <ul class="definitions-list">
                                <li>Accessing restricted areas without authorization.</li>
                                <li>Interfering with the site’s operation through viruses, malware, or any other means.</li>
                                <li>Using our content or services for unauthorized commercial purposes.</li>
                            </ul>
                        </ul>
                        <p style="text-align: center;">VIONS reserves the right to suspend or cancel access to any user who violates these conditions.</p>
                        <h3>5. Limitation of Liability </h3>
                        <p>VIONS strives to maintain accurate and up-to-date content on the platform. However, we do
                            not guarantee continuous availability of the site or that the content is free from errors or
                            interruptions. </p>
                        <p>To the fullest extent permitted by law, VIONS will not be liable for:</p>
                        <ul class="definitions-list">
                            <li>
                                Direct, indirect, or consequential damages arising from the use of the platform.
                            </li>
                            <li>
                                Loss of data, income, or any other negative consequence resulting from the use or
                                inability to use our site. </li>
                        </ul>
                        <h3>6. Modifications</h3>
                        <p>VIONS reserves the right to update, modify, or delete any content, functionality, or these
                            Terms and Conditions without prior notice. Any changes will take effect upon their publication
                            on the site. We recommend you periodically review this page to stay informed of any updates. </p>

                        <h3>7. Governing Law and Dispute Resolution</h3>
                        <p>These Terms and Conditions are governed by and construed in accordance with the laws of
                            Mexico.
                            In the event of a dispute related to the use of the platform, the user agrees to submit to the
                            competent courts in Guanajuato, Mexico, waiving any other jurisdiction that may apply.</p>
                        <h3>8. Contact</h3>
                        <p>If you have any questions or concerns regarding these Terms and Conditions, you can contact
                            us at:</p>
                        <ul class="definitions-list">
                            <li>
                                <strong class="highlight">Email:</strong>: info@vions.com.mx
                            </li>
                        </ul>
                        <h5>Last updated: November 21, 2024
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <?php include_once('includes/footer.php'); ?>
    <script src="js/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="plugins/scroll/scrollbar.min.js"></script><!-- OWL SLIDER -->
    <script src="js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
    <script src="js/dz.ajax.js"></script><!-- CONTACT JS  -->

</body>

</html>