<?php
require 'config.php';
session_start();

$errors = [];

// Already logged in? go straight to the dashboard.
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login_user'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username)) $errors[] = 'Username is required';
    if (empty($password)) $errors[] = 'Password is required';

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Wrong username/password combination';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMonitor - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to Your Account</h2>
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="error"><p><?php echo htmlspecialchars($_SESSION['msg']); unset($_SESSION['msg']); ?></p></div>
        <?php endif; ?>
        <?php include 'includes/errors.php'; ?>
        <form method="POST" action="login.php">
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            <button class="mybutton primary" type="submit" name="login_user">Login</button>
        </form>
        <p><a href="forgotpwd.php">Forgot Password?</a></p>
        <p>Don't have an account yet?</p>
        <a href="register.php"><button class="mybutton secondary" type="button">Sign Up</button></a>
    </div>
</body>
</html>
