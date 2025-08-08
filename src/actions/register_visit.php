<?php
include_once(__DIR__ . '/../../config/config.php');

try {
    $options = [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    ];

    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

// Obtener parámetros de la URL
$origin = isset($_GET['origin']) ? htmlspecialchars(substr($_GET['origin'], 0, 50)) : 'Unknown';

// Obtener IP del usuario y User Agent
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

// Función para detectar tipo de dispositivo
function getDeviceType($user_agent)
{
    if (preg_match('/mobile/i', $user_agent)) {
        return 'Mobile';
    } elseif (preg_match('/tablet/i', $user_agent)) {
        return 'Tablet';
    } elseif (preg_match('/desktop|windows|macintosh/i', $user_agent)) {
        return 'Desktop';
    } else {
        return 'Unknown';
    }
}
$device_type = getDeviceType($user_agent);

$date_time = date('Y-m-d H:i:s');

// Inicializar variables de ubicación
$country = 'Unknown';
$region = 'Unknown';
$city = 'Unknown';
$latitude = 'Unknown';
$longitude = 'Unknown';

// Validar IP y obtener información geográfica
if (filter_var($user_ip, FILTER_VALIDATE_IP) && $user_ip !== '127.0.0.1') {
    $geo_url = "http://ip-api.com/json/{$user_ip}";
    $geo_data = @file_get_contents($geo_url);
    $geo_info = $geo_data ? json_decode($geo_data) : null;

    if ($geo_info && $geo_info->status === 'success') {
        $country = $geo_info->country ?? 'Unknown';
        $region = $geo_info->regionName ?? 'Unknown';
        $city = $geo_info->city ?? 'Unknown';
        $latitude = $geo_info->lat ?? 'Unknown';
        $longitude = $geo_info->lon ?? 'Unknown';
    }
}

// Determinar el origen de la visita
$referrer = $_SERVER['HTTP_REFERER'] ?? '';
$utm_source = $_GET['utm_source'] ?? null;
$gclid = $_GET['gclid'] ?? null;
$source = 'Directo';

if ($utm_source || $gclid) {
    $source = 'Anuncios';
} elseif (strpos($referrer, 'google.com') !== false || strpos($referrer, 'bing.com') !== false || strpos($referrer, 'yahoo.com') !== false) {
    $source = 'Búsqueda Orgánica';
} elseif (strpos($referrer, 'facebook.com') !== false) {
    $source = 'Facebook';
} elseif (strpos($referrer, 'instagram.com') !== false) {
    $source = 'Instagram';
} elseif (strpos($referrer, 'twitter.com') !== false) {
    $source = 'Twitter';
} elseif (strpos($referrer, 'linkedin.com') !== false) {
    $source = 'LinkedIn';
} elseif (strpos($referrer, 'tiktok.com') !== false) {
    $source = 'TikTok';
} elseif (strpos($referrer, 'pinterest.com') !== false) {
    $source = 'Pinterest';
}

try {
    $sql = "INSERT INTO visits (origin, ip_address, user_agent, device_type, country, region, city, latitude, longitude, date_time, source) 
            VALUES (:origin, :ip_address, :user_agent, :device_type, :country, :region, :city, :latitude, :longitude, :date_time, :source)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':origin' => $origin,
        ':ip_address' => $user_ip,
        ':user_agent' => $user_agent,
        ':device_type' => $device_type,
        ':country' => $country,
        ':region' => $region,
        ':city' => $city,
        ':latitude' => $latitude,
        ':longitude' => $longitude,
        ':date_time' => $date_time,
        ':source' => $source,
    ]);

    error_log("Visita registrada exitosamente.");
} catch (PDOException $e) {
    error_log("Error registrando la visita: " . $e->getMessage());
}

$conn = null;

ini_set('display_errors', 0);
error_reporting(0);
