<?php
// Incluir la configuración y el archivo de conexión
include_once('../../../config/config.php');

// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Paso 2: Consulta para obtener las ubicaciones (latitud, longitud y total_visitas) y más datos
$sql = "SELECT latitude, longitude, origin, country, date_time, region, device_type, city, source, COUNT(*) AS total_visitas 
        FROM visits 
        GROUP BY latitude, longitude, origin, country, date_time, region, device_type, city, source";
$ubicaciones = [];

// Ejecutamos la consulta utilizando PDO
try {
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ubicaciones[] = [
            'latitud' => $row['latitude'],
            'longitud' => $row['longitude'],
            'origin' => $row['origin'],
            'country' => $row['country'],
            'date_time' => $row['date_time'],
            'region' => $row['region'],
            'device_type' => $row['device_type'],
            'city' => $row['city'],
            'source' => $row['source'],
            'total_visitas' => $row['total_visitas']
        ];
    }
} catch (PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mapa de Ubicaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <?php include('../includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('../includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Título principal -->
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                        <h1 class="display-6">Mapa y Tabla Dinámica</h1>
                        <button class="btn btn-primary">
                            <i class="fas fa-download me-1"></i> Exportar Datos
                        </button>
                    </div>

                    <!-- Mapa -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-map-marked-alt me-2"></i> Mapa Interactivo
                        </div>
                        <div class="card-body">
                            <div id="map" style="height: 500px; border-radius: 10px;"></div>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <i class="fas fa-table me-2"></i> Información de Ubicaciones
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Latitud</th>
                                            <th>Longitud</th>
                                            <th>Origen</th>
                                            <th>País</th>
                                            <th>Fecha y Hora</th>
                                            <th>Región</th>
                                            <th>Tipo de Dispositivo</th>
                                            <th>Ciudad</th>
                                            <th>Fuente</th>
                                            <th>Visitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ubicaciones as $ubicacion): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($ubicacion['latitud']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['longitud']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['origin']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['country']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['date_time']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['region']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['device_type']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['city']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['source']); ?></td>
                                                <td><?php echo htmlspecialchars($ubicacion['total_visitas']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
           

        <style>
            .card-header {
                font-weight: bold;
                font-size: 1.1rem;
            }

            .card {
                border-radius: 10px;
                overflow: hidden;
            }

            #map {
                border: 1px solid #ddd;
            }

            table th,
            table td {
                text-align: center;
                vertical-align: middle;
            }

            .btn-primary {
                background-color: #0069d9;
                border-color: #005cbf;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #004085;
            }
        </style>

        </main>

        <?php include('../includes/footer.php'); ?>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        // Inicializar DataTables
        const datatablesSimple = new simpleDatatables.DataTable("#datatablesSimple");

        // Datos de las ubicaciones obtenidas desde la base de datos
        var ubicaciones = <?php echo json_encode($ubicaciones); ?>;

        // Filtrar ubicaciones con coordenadas válidas
        var ubicacionesValidas = ubicaciones.filter(function(ubicacion) {
            return ubicacion.latitud && ubicacion.longitud &&
                ubicacion.latitud >= -90 && ubicacion.latitud <= 90 &&
                ubicacion.longitud >= -180 && ubicacion.longitud <= 180;
        });

        if (ubicacionesValidas.length > 0) {
            var map = L.map('map').setView([19.432608, -99.133209], 5); // Centrado en México

            // Agregar la capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Crear una capa de calor
            var heat = L.heatLayer(
                ubicacionesValidas.map(function(ubicacion) {
                    return [ubicacion.latitud, ubicacion.longitud, ubicacion.total_visitas || 1];
                }), {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17
                }
            ).addTo(map);

            // Agregar marcadores con información
            ubicacionesValidas.forEach(function(ubicacion) {
                L.marker([ubicacion.latitud, ubicacion.longitud])
                    .addTo(map)
                    .bindPopup("Visitas: " + ubicacion.total_visitas);
            });
        } else {
            alert("No se encontraron datos válidos para las ubicaciones.");
        }
    </script>
</body>

</html>