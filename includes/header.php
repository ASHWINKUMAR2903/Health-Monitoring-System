<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loggedIn = isset($_SESSION['user_id']);
?>
<header>
    <nav>
        <div class="logo">HealthMonitor</div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <?php if ($loggedIn): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="healthdata.php">Health Data</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="contact.php">Contact</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
