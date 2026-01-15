<?php
include('../auth/session_check.php');
include_once('../actions/dashboard-functions.php');
include_once('../actions/save_link.php');

// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener los datos de visitas agrupados
$elementosPorSource = obtenerElementosPorSource();
$visitasPorDia = obtenerVisitasPorDia();
$visitasPorHora = obtenerVisitasPorHora();
$visitasPorOrigen = obtenerVisitasPorOrigen();
$visitasPorDispositivo = obtenerVisitasPorDispositivo();
$visitasPorOrigenAvanzado = obtenerVisitasPorOrigenAvanzado();
$resumenVisitas = obtenerResumenVisitas();
$ubicaciones = obtenerUbicacionesVisitas();

?>


<!DOCTYPE html>
<html lang="es">

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
    <script src="js/scripts.js"></script>
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Leaflet.js para mapa interactivo -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Heatmap plugin -->
    <script src="https://unpkg.com/leaflet-heat/dist/leaflet-heat.js"></script>

    <!--  Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />


</head>

<body class="sb-nav-fixed">
    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>

                <div class="container-fluid px-4">
                    <h1 class="mt-4 mb-3">Dashboard de Analíticas</h1>

                    <!-- Resumen general -->
                    <div class="row mb-4">
                        <div class="col-xl-4 col-md-6">
                            <div class="card shadow-lg border-0 rounded-3">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-chart-pie me-1"></i> Resumen de Visitas
                                </div>
                                <div class="card-body">
                                    <p><strong>Total de Visitas:</strong> <?php echo $resumenVisitas['total_visitas']; ?></p>
                                    <p><strong>Orígenes Únicos:</strong> <?php echo $resumenVisitas['origenes_unicos']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de gráficos -->
                    <h2 class="mt-4 mb-3">Gráficos de Análisis</h2>
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="card shadow-lg border-0 rounded-3 mb-4">
                                <div class="card-header bg-info text-white">
                                    <i class="fas fa-calendar-day me-1"></i> Visitas por Día
                                </div>
                                <div class="card-body">
                                    <canvas id="visitasPorDiaChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12">
                            <div class="card shadow-lg border-0 rounded-3 mb-4">
                                <div class="card-header bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i> Visitas por Hora
                                </div>
                                <div class="card-body">
                                    <canvas id="visitasPorHoraChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de tablas -->
                    <div class="row">
                        <div class="col-xl-4 col-md-12 mb-4">
                            <div class="card shadow-lg border-0 rounded-3 mb-4">
                                <div class="card-header bg-success text-white">
                                    <i class="fas fa-share-alt me-1"></i> Visitas por Origen (URL)
                                </div>
                                <div class="card-body">
                                    <canvas id="visitasPorOrigenAvanzadoChart"></canvas>
                                </div>
                            </div>
                        </div>

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
                            <div class="card shadow-lg border-0 rounded-3">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-chart-pie me-1"></i> Gráfica de Fuente de Visualizacion
                                </div>
                                <div class="card-body">
                                    <canvas id="graficaElementosPorSource"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Tablas de datos -->
                        <h2 class="mt-4 mb-3">Tablas de Datos</h2>
                        <div class="row">
                            <div class="col-xl-4 col-md-12 mb-4">
                                <div class="card shadow-lg border-0 rounded-3 mb-4">
                                    <div class="card-header bg-success text-white">
                                        <i class="fas fa-share-alt me-1"></i> Visitas por Origen
                                    </div>
                                    <div class="card-body">
                                        <table id="datatablesVisitasPorOrigen" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Origen</th>
                                                    <th>Total Visitas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($visitasPorOrigen as $origen): ?>
                                                    <tr>
                                                        <td><i class="fas fa-link"></i> <?php echo htmlspecialchars($origen['origin']); ?></td>
                                                        <td><?php echo htmlspecialchars($origen['total_visitas']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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
                            <div class="col-xl-4 col-md-12 mb-4">
                                <div class="card mb-4 shadow-lg border-0 rounded-3">
                                    <div class="card-header bg-primary text-white">
                                        <i class="fas fa-table me-1"></i>Fuente de Visualizacion
                                    </div>
                                    <div class="card-body">
                                        <table id="datatablesElementosPorSource" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Fuente</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($elementosPorSource)): ?>
                                                    <?php foreach ($elementosPorSource as $elemento): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($elemento['source']) ?: 'Desconocido'; ?></td>
                                                            <td><?= $elemento['total']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="2" class="text-center">No se encontraron resultados</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Formulario: Agregar enlace -->
                            <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
                                <div class="card shadow-lg border-0 rounded-3">
                                    <div class="card-header bg-primary text-white">
                                        <i class="fas fa-link me-1"></i> Agregar Enlace de Origen
                                    </div>
                                    <div class="card-body">
                                        <form action="../actions/save_link.php" method="POST">
                                            <div class="mb-3">
                                                <label for="source" class="form-label">Source:</label>
                                                <input type="text" id="source" name="source" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="link" class="form-label">Link:</label>
                                                <input type="text" id="link" name="link" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-success">Guardar Enlace</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla: Enlaces guardados -->
                            <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
                                <div class="card shadow-lg border-0 rounded-3">
                                    <div class="card-header bg-success text-white">
                                        <i class="fas fa-link me-1"></i> Enlaces Guardados
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Origen</th>
                                                        <th>Enlace</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $stmt = $pdo->query("SELECT * FROM source_links");
                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($row['source']); ?></td>
                                                            <td>
                                                                <a href="<?php echo htmlspecialchars($row['link']); ?>" class="text-truncate d-block" style="max-width: 150px;" target="_blank">
                                                                    <?php echo htmlspecialchars($row['link']); ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-info btn-sm" onclick="copiarEnlace('<?php echo htmlspecialchars($row['link']); ?>')">Copiar</button>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        include_once('analytics-locations.php');
                        ?>
                    </div>
                </div>
            </main>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
</body>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Scripts para los gráficos -->
<script>
    // Datos de visitas por día
    var visitasPorDia = <?php echo json_encode($visitasPorDia); ?>;
    var visitasPorHora = <?php echo json_encode($visitasPorHora); ?>;
    var visitasPorOrigenAvanzado = <?php echo json_encode($visitasPorOrigenAvanzado); ?>;
    var visitasPorDispositivo = <?php echo json_encode($visitasPorDispositivo); ?>;

    // Gráfico de visitas por día
    var visitasPorDiaChart = new Chart(document.getElementById('visitasPorDiaChart'), {
        type: 'line',
        data: {
            labels: visitasPorDia.map(function(item) {
                return item.dia;
            }),
            datasets: [{
                label: 'Visitas por Día',
                data: visitasPorDia.map(function(item) {
                    return item.total_visitas;
                }),
                borderColor: '#6f42c1',
                backgroundColor: 'rgba(111, 66, 193, 0.2)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // Gráfico de visitas por hora
    var visitasPorHoraChart = new Chart(document.getElementById('visitasPorHoraChart'), {
        type: 'bar',
        data: {
            labels: visitasPorHora.map(function(item) {
                return item.hora + ":00";
            }),
            datasets: [{
                label: 'Visitas por Hora',
                data: visitasPorHora.map(function(item) {
                    return item.total_visitas;
                }),
                backgroundColor: '#ffcc00'
            }]
        }
    });

    // Gráfico de visitas por origen avanzado
    var visitasPorOrigenAvanzadoChart = new Chart(document.getElementById('visitasPorOrigenAvanzadoChart'), {
        type: 'pie',
        data: {
            labels: visitasPorOrigenAvanzado.map(function(item) {
                return item.origin;
            }),
            datasets: [{
                label: 'Visitas por Origen Avanzado',
                data: visitasPorOrigenAvanzado.map(function(item) {
                    return item.total_visitas;
                }),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
            }]
        }
    });

    // Gráfico de visitas por dispositivo
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
            type: 'pie',
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

    function copiarEnlace(link) {
        var input = document.createElement('input');
        input.value = link;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('Enlace copiado: ' + link);
    }
</script>


</body>

</html>