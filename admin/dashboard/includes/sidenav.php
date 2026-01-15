<?php
// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="/admin/dashboard/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Create</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Portfolios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="/admin/dashboard/list-portfolio.php">List artist</a>
                    </nav>
                </div>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="/admin/dashboard/list-DJs.php">List DJs</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapsePages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="/admin/dashboard/list-users.php">List Users</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Analytics</div>

                <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAnalytics" aria-expanded="false" aria-controls="collapseAnalytics">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                    Analíticas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAnalytics" aria-labelledby="headingAnalytics" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="analytics-overview.php">Resumen</a>
                        <a class="nav-link" href="analytics-traffic.php">Tráfico</a>
                        <a class="nav-link" href="/admin/dashboard/analytics/analytics-locations.php">Ubicaciones</a>
                        <a class="nav-link" href="analytics-devices.php">Dispositivos</a>
                    </nav>
                </div> -->


                <a class="nav-link" href="/admin/dashboard/list-origins.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                    Analytics
                </a>

                <!-- <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a> -->
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <div>
                <?php
                if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                    echo htmlspecialchars($_SESSION['first_name']) . ' ' . htmlspecialchars($_SESSION['last_name']);
                } else {
                    echo 'Guest';
                }
                ?>
            </div>
            <div class="small">Last login:
                <?php
                if (isset($_SESSION['last_login'])) {
                    echo htmlspecialchars($_SESSION['last_login']);
                }
                ?>
            </div>
        </div>


    </nav>
</div>