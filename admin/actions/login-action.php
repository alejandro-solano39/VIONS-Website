<?php
include_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: ../auth/login.php?error=emptyfields");
        exit;
    }

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        error_log("Error de conexión: " . $conn->connect_error);
        header("Location: ../auth/login.php?error=servererror");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, email, password, first_name, last_name, role_id, status, last_login FROM users WHERE email = ?");
    if (!$stmt) {
        error_log("Error en la preparación de la consulta: " . $conn->error);
        header("Location: ../auth/login.php?error=servererror");
        exit;
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['last_login'] = $user['last_login'];
            $_SESSION['loggedin'] = true;

            $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $updateStmt->bind_param('i', $user['id']);
            $updateStmt->execute();
            $updateStmt->close();

            header("Location: ../dashboard/index.php");
            exit;
        } else {
            header("Location: ../auth/login.php?error=wrongpassword");
            exit;
        }
    } else {
        header("Location: ../auth/login.php?error=usernotfound");
        exit;
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../auth/login.php");
    exit;
}
?>
