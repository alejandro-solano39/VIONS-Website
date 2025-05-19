<?php
include_once('../../config/config.php'); // Archivo de configuración con $pdo

// Función para obtener todos los portafolios con categorías
function obtenerTodosLosPortafolios()
{
    global $pdo;
    $sql = "SELECT portfolios.*, category.nombre AS categoria_nombre
            FROM portfolios
            INNER JOIN category ON portfolios.categoria_id = category.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener el portafolio más reciente
function obtenerUltimoPortafolio()
{
    global $pdo;
    $sql = "SELECT * FROM portfolios ORDER BY fecha_registro DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para contar usuarios
function contarUsuarios()
{
    global $pdo;
    $sql = "SELECT COUNT(*) as total FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

// Función para obtener la lista de usuarios
function obtenerUsuarios()
{
    global $pdo;
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener el resumen de visitas
function obtenerResumenVisitas()
{
    global $pdo;
    $sql = "SELECT 
                COUNT(*) as total_visitas, 
                COUNT(DISTINCT origin) as origenes_unicos 
            FROM visits";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por origen
function obtenerOrigenDeVisitas()
{
    global $pdo;
    $sql = "SELECT origin, COUNT(*) as total 
            FROM visits 
            GROUP BY origin";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por dispositivo
function obtenerDispositivosVisitas()
{
    global $pdo;
    $sql = "SELECT user_agent, COUNT(*) as total 
            FROM visits 
            GROUP BY user_agent";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener el total de visitas
function obtenerTotalVisitas()
{
    global $pdo;
    $sql = "SELECT COUNT(*) AS total_visitas FROM visits";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Función para obtener visitas agrupadas por fecha (día)
function obtenerVisitasPorDia()
{
    global $pdo;
    $sql = "SELECT DATE(date_time) AS dia, COUNT(*) AS total_visitas
            FROM visits
            GROUP BY DATE(date_time)
            ORDER BY dia DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por hora
function obtenerVisitasPorHora()
{
    global $pdo;
    $sql = "SELECT HOUR(date_time) AS hora, COUNT(*) AS total_visitas
            FROM visits
            GROUP BY HOUR(date_time)
            ORDER BY hora ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por origen (FB, Instagram, etc.)
function obtenerVisitasPorOrigen()
{
    global $pdo;
    $sql = "SELECT origin, COUNT(*) AS total_visitas
            FROM visits
            GROUP BY origin
            ORDER BY total_visitas DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por dispositivo (user agent)
function obtenerVisitasPorDispositivo()
{
    global $pdo;
    $sql = "SELECT device_type, COUNT(*) AS total_visitas
            FROM visits
            GROUP BY device_type
            ORDER BY total_visitas DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener las visitas más recientes
function obtenerVisitasRecientes($limit = 5)
{
    global $pdo;
    $sql = "SELECT * FROM visits ORDER BY date_time DESC LIMIT ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por origen (Anuncios, Búsqueda orgánica, Tráfico directo)
function obtenerVisitasPorOrigenAvanzado()
{
    global $pdo;
    $sql = "SELECT origin, COUNT(*) AS total_visitas
            FROM visits
            WHERE origin IS NOT NULL
            GROUP BY origin
            ORDER BY total_visitas DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por parámetros UTM
function obtenerVisitasPorUTM()
{
    global $pdo;
    $sql = "SELECT utm_source, utm_medium, COUNT(*) AS total_visitas
            FROM visits
            GROUP BY utm_source, utm_medium
            ORDER BY total_visitas DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener visitas agrupadas por gclid (Google Ads)
function obtenerVisitasPorGclid()
{
    global $pdo;
    $sql = "SELECT gclid, COUNT(*) AS total_visitas
            FROM visits
            GROUP BY gclid
            ORDER BY total_visitas DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener las ubicaciones de las visitas
function obtenerUbicacionesVisitas()
{
    global $pdo;
    // Consulta SQL con más detalles
    $sql = "SELECT latitude, longitude, origin, country, date_time, region, device_type, city, source, COUNT(*) AS total_visitas 
            FROM visits 
            GROUP BY latitude, longitude, origin, country, date_time, region, device_type, city, source";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function obtenerElementosPorSource()
{
    global $pdo;

    $sql = "SELECT source, COUNT(*) AS total
            FROM visits
            GROUP BY source
            ORDER BY total DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
