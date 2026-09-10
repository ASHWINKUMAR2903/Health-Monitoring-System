<?php
require 'includes/auth_check.php';
require 'config.php';

$userId = $_SESSION['user_id'];
$errors = [];

if (isset($_POST['update_profile'])) {
    $full_name = trim($_POST['full_name']);
    $phone     = trim($_POST['phone']);
    $age       = $_POST['age'] !== '' ? (int) $_POST['age'] : null;
    $height    = $_POST['height_cm'] !== '' ? (float) $_POST['height_cm'] : null;
    $weight    = $_POST['weight_kg'] !== '' ? (float) $_POST['weight_kg'] : null;

    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, phone = ?, age = ?, height_cm = ?, weight_kg = ? WHERE id = ?');
    $stmt->execute([$full_name, $phone, $age, $height, $weight, $userId]);
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="profile-section">
        <div class="container">
            <div class="profile-header">
                <h1>User Profile</h1>
                <p>Welcome back, <span id="user-name"><?php echo htmlspecialchars($user['username']); ?></span></p>
            </div>

            <div class="profile-details">
                <h2>Personal & Health Information</h2>
                <form method="POST" action="profile.php">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">

                    <label>Email (read-only)</label>
                    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>

                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

                    <label>Age</label>
                    <input type="number" name="age" value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>">

                    <label>Height (cm)</label>
                    <input type="number" step="0.1" name="height_cm" value="<?php echo htmlspecialchars($user['height_cm'] ?? ''); ?>">

                    <label>Weight (kg)</label>
                    <input type="number" step="0.1" name="weight_kg" value="<?php echo htmlspecialchars($user['weight_kg'] ?? ''); ?>">

                    <button class="mybutton primary" type="submit" name="update_profile">Save</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
