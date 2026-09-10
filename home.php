<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMonitor - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Monitor Your Health in Real-Time</h1>
            <p>Track your heart rate and oxygen levels easily with our Health Monitoring System.</p>
            <div class="buttons">
                <?php if ($loggedIn): ?>
                    <a href="dashboard.php" class="cta-button">Go to Dashboard</a>
                <?php else: ?>
                    <a href="login.php" class="cta-button">Get Started</a>
                <?php endif; ?>
                <a href="#how-it-works" class="how-it-works-button">How It Works</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="feature-block">
            <div class="feature-icon"><span>&#128154;</span></div>
            <h3>Real-Time Monitoring</h3>
            <p>Track heart rate and oxygen levels over time.</p>
        </div>
        <div class="feature-block">
            <div class="feature-icon"><span>&#128736;</span></div>
            <h3>Personalized Suggestions</h3>
            <p>Get simple health tips based on your latest readings.</p>
        </div>
        <div class="feature-block">
            <div class="feature-icon"><span>&#128204;</span></div>
            <h3>Secure & Private</h3>
            <p>Your data is tied to your account and only visible to you.</p>
        </div>
    </section>

    <section id="how-it-works">
        <h2>How It Works</h2>
        <ol>
            <li>Create an account and log in.</li>
            <li>Your BPM and SpO2 readings are stored in a database table (health_data).</li>
            <li>Add readings yourself, import a CSV, or click "Generate demo data" on the dashboard.</li>
            <li>View your latest reading, trends, and health suggestions on the Dashboard.</li>
            <li>Browse full history and filter by date on the Health Data page.</li>
        </ol>
    </section>
</body>
</html>
