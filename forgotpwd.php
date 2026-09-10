<?php
require 'config.php';
session_start();
$errors = [];
$done = false;

if (isset($_POST['reset_request'])) {
    $email = trim($_POST['email']);
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    // For a school/demo project we just acknowledge the request either way
    // (never reveal whether an email exists in the system).
    $done = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMonitor - Forgot Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>
        <?php if ($done): ?>
            <p>If that email is registered, reset instructions would be sent (email sending is not wired up in this demo).</p>
            <p><a href="login.php">Back to Login</a></p>
        <?php else: ?>
            <?php include 'includes/errors.php'; ?>
            <form method="POST" action="forgotpwd.php">
                <input type="email" placeholder="Your account email" name="email" required>
                <button class="mybutton primary" type="submit" name="reset_request">Send Reset Link</button>
            </form>
            <p><a href="login.php">Back to Login</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
