<?php
include('../auth/session_check.php');
include_once('../actions/dashboard-functions.php');
include_once('../actions/dj-functions/dj-functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener todos los portafolios con sus categorías
$portafolios = obtenerTodosLosPortafolios();
$totalPortafolios = is_array($portafolios) ? count($portafolios) : 0;

// Obtener el último portafolio
$ultimoPortafolio = obtenerUltimoPortafolio();
$tituloUltimoPortafolio = $ultimoPortafolio['nombre'] ?? 'No hay portafolios registrados';
$descripcionUltimoPortafolio = $ultimoPortafolio['descripcion'] ?? 'No se ha creado ningún portafolio aún.';
$imagenMiniatura = $ultimoPortafolio['miniatura'] ?? 'images/default.jpg';

// Obtener usuarios
$usuarios = obtenerUsuarios();
$totalUsuarios = is_array($usuarios) ? count($usuarios) : 0;

// Obtener datos del origen de visitas
$origenVisitas = obtenerOrigenDeVisitas();
$origenLabels = [];
$origenData = [];

foreach ($origenVisitas as $origen) {
    $origenLabels[] = $origen['origin'];
    $origenData[] = $origen['total'];
}

// Obtener el total de DJs
$totalDJs = obtenerTotalDJs();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard VIONS</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/scripts.js"></script>
    <style>
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header-custom {
            background-color: #6f42c1;
            color: white;
            font-weight: bold;
            border-radius: 15px 15px 0 0;
        }

        .card-footer-custom {
            background-color: #f8f9fc;
            border-radius: 0 0 15px 15px;
        }

        .img-thumbnail {
            border-radius: 10px;
        }

        .welcome-card {
            background-color: #f1e6fe;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: white;
        }

        .btn-custom:hover {
            background-color: #5a2a9e;
            border-color: #5a2a9e;
        }

        .card-custom .card-body {
            color: #333;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h3 class="mt-4">Dashboard</h3>
                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card welcome-card">
                                <div class="card-header card-header-custom">
                                    <h4><i class="fas fa-user-circle me-1"></i>
                                        Bienvenido, <?php
                                                    if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                                                        echo htmlspecialchars($_SESSION['first_name']) . ' ' . htmlspecialchars($_SESSION['last_name']);
                                                    } else {
                                                        echo 'Guest';
                                                    }
                                                    ?></h4>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">¡Estás logueado con éxito en el dashboard!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-custom mb-4 shadow-lg" style="background: linear-gradient(135deg, #8e44ad, #9b59b6);">
                                <div class="card-body text-center text-white">
                                    <h5 class="card-title">Total de Usuarios</h5>
                                    <h3 class="display-4"><?php echo $totalUsuarios; ?></h3>
                                    <a href="list-users.php" class="btn btn-light btn-sm mt-3">Ver Detalles</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-custom mb-4 shadow-lg" style="background: linear-gradient(135deg, #3498db, #1abc9c);">
                                <div class="card-body text-center text-white">
                                    <h5 class="card-title">Total de Portafolios</h5>
                                    <h3 class="display-4"><?php echo $totalPortafolios; ?></h3>
                                    <a href="list-portfolio.php" class="btn btn-light btn-sm mt-3">Ver Detalles</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-custom mb-4 shadow-lg" style="background: linear-gradient(135deg, #e91e63, #c2185b);">
                                <div class="card-body text-center text-white">
                                    <h5 class="card-title">Total de DJs</h5>
                                    <h3 class="display-4"><?php echo $totalDJs; ?></h3>
                                    <a href="list-djs.php" class="btn btn-light btn-sm mt-3">Ver Detalles</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12">
                            <div class="card card-custom mb-4 shadow-lg" style="background: linear-gradient(135deg, #9b59b6, #8e44ad);">
                                <div class="card-body d-flex align-items-center text-white">
                                    <img src="../<?php echo $imagenMiniatura; ?>" class="img-fluid" style="width: 120px; height: 120px; border-radius: 10px;">
                                    <div class="ms-3">
                                        <h5 class="card-title"><?php echo htmlspecialchars($tituloUltimoPortafolio); ?></h5>
                                        <p><?php echo htmlspecialchars(substr($descripcionUltimoPortafolio, 0, 100)) . (strlen($descripcionUltimoPortafolio) > 100 ? '...' : ''); ?></p>
                                        <a href="../../public/artist-details.php?id=<?php echo $ultimoPortafolio['id']; ?>" class="btn btn-light btn-sm mt-3">Ver Detalles</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script>
    </script>
</body>

</html>