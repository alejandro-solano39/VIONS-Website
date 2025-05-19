<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../dashboard/index.php");
    exit;
}

if (isset($_GET['error'])) {
    $error_message = "";
    switch ($_GET['error']) {
        case 'emptyfields':
            $error_message = "Please fill in all fields.";
            break;
        case 'wrongpassword':
            $error_message = "Incorrect password. Try again.";
            break;
        case 'usernotfound':
            $error_message = "No account found with this email.";
            break;
        case 'servererror':
            $error_message = "An unexpected error occurred. Please try again later.";
            break;
    }
    $error_message = htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style-dashboard.css">
    <title>Login | VIONS</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="../actions/login-action.php" method="POST">
                <h1>Sign In</h1>
                <?php if (isset($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <a href="../auth/forgot-password.php">Forget Your Password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Welcome to VIONS!</h1>
                    <p>We're glad to have you back. Have a wonderful day!</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>