<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style-dashboard.css">
    <title>Login | VIONS</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="../actions/login-action.php" method="POST">
                <h1>Sign In</h1>
                <span>or use your email and password</span>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#">Forget Your Password?</a>
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
