<?php
include('../../auth/session_check.php');
include_once('../../src/actions/dashboard-functions.php');

// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener los datos de visitas agrupados

// $visitasPorDispositivo = obtenerVisitasPorDispositivo();

?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard de Analíticas</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Agregar Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Agregar Leaflet.js para mapa interactivo -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Agregar Leaflet Heatmap plugin -->
    <script src="https://unpkg.com/leaflet-heat/dist/leaflet-heat.js"></script>

    <!-- Agregar Bootstrap para diseño responsivo y mejorado -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />


<body>
    <div class="col-xl-4 col-md-12 mb-4">
        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header bg-danger text-white">
                <i class="fas fa-mobile-alt me-1"></i> Visitas por Dispositivo
            </div>
            <div class="card-body">
                <canvas id="visitasPorDispositivoChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12 mb-4">
        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header bg-danger text-white">
                <i class="fas fa-mobile-alt me-1"></i> Visitas por Dispositivo
            </div>
            <div class="card-body">
                <table id="datatablesVisitasPorDispositivo" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Dispositivo</th>
                            <th>Total Visitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitasPorDispositivo as $dispositivo): ?>
                            <tr>
                                <td><i class="fas fa-mobile-alt"></i> <?php echo htmlspecialchars($dispositivo['device_type']); ?></td>
                                <td><?php echo htmlspecialchars($dispositivo['total_visitas']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>



<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>

<script>

// Crear gráfico de visitas por dispositivo
var visitasPorDispositivoChart = new Chart(document.getElementById('visitasPorDispositivoChart'), {
    type: 'doughnut',
    data: {
        labels: visitasPorDispositivo.map(function(item) {
            return item.device_type;
        }),
        datasets: [{
            label: 'Visitas por Dispositivo',
            data: visitasPorDispositivo.map(function(item) {
                return item.total_visitas;
            }),
            backgroundColor: ['#ff6347', '#ff4500', '#2e8b57', '#ffd700']
        }]
    }
});

document.addEventListener("DOMContentLoaded", function() {
    // Datos desde PHP para la gráfica
    const elementosPorSource = <?php echo json_encode($elementosPorSource); ?>;

    const sources = elementosPorSource.map(elemento => elemento.source || "Desconocido");
    const totals = elementosPorSource.map(elemento => elemento.total);

    // Configuración de la gráfica
    const ctx = document.getElementById('graficaElementosPorSource').getContext('2d');
    new Chart(ctx, {
        type: 'pie', // Puedes cambiar a 'bar', 'line', etc.
        data: {
            labels: sources,
            datasets: [{
                label: 'Elementos por Source',
                data: totals,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ${value}`;
                        }
                    }
                }
            }
        }
    });
});
</script>

</html>