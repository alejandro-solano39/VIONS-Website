<?php
// Incluir la configuración y el archivo de conexión
include_once('../../config/config.php');

// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Consulta para obtener las ubicaciones (latitud, longitud y total_visitas) y más datos
$sql = "SELECT id, latitude, longitude, origin, country, date_time, region, device_type, city, source, COUNT(*) AS total_visitas 
        FROM visits 
        GROUP BY id, latitude, longitude, origin, country, date_time, region, device_type, city, source";

$ubicaciones = [];

// Ejecutamos la consulta utilizando PDO
try {
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ubicaciones[] = [
            'id' => $row['id'],
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Ubicaciones</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>

<body>

    <main>
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h2 class="mt-4 mb-3">Mapa y Tabla Dinámica</h2>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-map-marked-alt me-2"></i> Mapa Interactivo
            </div>
            <div id="map" style="height: 500px; border-radius: 10px;"></div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-table me-2"></i> Información de Ubicaciones
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Numero</th>
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
                                    <td><?php echo htmlspecialchars($ubicacion['id']); ?></td>
                                    <td><?php echo htmlspecialchars($ubicacion['origin']); ?></td>
                                    <td><?php echo htmlspecialchars($ubicacion['country']); ?></td>
                                    <td>
                                        <?php
                                        $fecha = new DateTime($ubicacion['date_time']);
                                        echo htmlspecialchars($fecha->format('d/m/Y H:i:s'));
                                        ?>
                                    </td>
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

    </main>

    <!-- Scripts: con defer -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" defer></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ubicaciones = <?php echo json_encode($ubicaciones); ?>;

            const ubicacionesValidas = ubicaciones.filter(u =>
                u.latitud && u.longitud &&
                u.latitud >= -90 && u.latitud <= 90 &&
                u.longitud >= -180 && u.longitud <= 180
            );

            if (ubicacionesValidas.length > 0) {
                const map = L.map('map').setView([19.432608, -99.133209], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Capa de calor
                L.heatLayer(
                    ubicacionesValidas.map(u => [u.latitud, u.longitud, u.total_visitas || 1]),
                    {
                        radius: 25,
                        blur: 15,
                        maxZoom: 17
                    }
                ).addTo(map);

                // Si quieres marcadores, solo los primeros 100
                ubicacionesValidas.slice(0, 100).forEach(u => {
                    L.marker([u.latitud, u.longitud])
                        .addTo(map)
                        .bindPopup("Visitas: " + u.total_visitas);
                });

            } else {
                alert("No se encontraron datos válidos para las ubicaciones.");
            }
        });
    </script>

</body>

</html>
