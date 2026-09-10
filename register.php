<?php
require 'config.php';
session_start();

$errors = [];
$username = '';
$email = '';

if (isset($_POST['reg_user'])) {
    $username     = trim($_POST['username']);
    $email        = trim($_POST['email']);
    $password_1   = $_POST['password_1'];
    $password_2   = $_POST['password_2'];

    if (empty($username))   $errors[] = 'Username is required';
    if (empty($email))      $errors[] = 'Email is required';
    if (empty($password_1)) $errors[] = 'Password is required';
    if ($password_1 !== $password_2) $errors[] = 'The two passwords do not match';

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, username, email FROM users WHERE username = ? OR email = ? LIMIT 1');
        $stmt->execute([$username, $email]);
        $existing = $stmt->fetch();

        if ($existing) {
            if ($existing['username'] === $username) $errors[] = 'Username already exists';
            if ($existing['email'] === $email)       $errors[] = 'Email already exists';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password_1, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $hash]);

        $_SESSION['user_id']  = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['msg']      = 'Account created — you are now logged in';
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMonitor - Sign Up</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Create an Account</h2>
        <?php include 'includes/errors.php'; ?>
        <form method="POST" action="register.php">
            <input type="text" placeholder="Username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <input type="email" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="password" placeholder="Password" name="password_1" required>
            <input type="password" placeholder="Confirm Password" name="password_2" required>
            <button class="mybutton primary" type="submit" name="reg_user">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Sign in</a></p>
    </div>
</body>
</html>
