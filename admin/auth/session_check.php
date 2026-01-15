<?php
session_start([
    'cookie_lifetime' => 0,
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'use_strict_mode' => true
]);

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must log in to access this page.";
    header("Location: ../auth/login.php");
    exit;
}

// Protección contra secuestro de sesión
if (!isset($_SESSION['user_agent'])) {
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
} elseif ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php?error=invalid_session");
    exit;
}

$timeout = 1800;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    $_SESSION['error'] = "Your session has expired due to inactivity.";
    header("Location: ../auth/login.php");
    exit;
}

$_SESSION['last_activity'] = time();

// Regenera el ID de sesión cada 5 minutos
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 300) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}
?>
