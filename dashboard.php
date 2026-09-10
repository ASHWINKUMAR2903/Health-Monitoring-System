<?php
require 'includes/auth_check.php';
require 'config.php';

$userId = $_SESSION['user_id'];

// Latest reading
$stmt = $pdo->prepare('SELECT bpm, spo2, recorded_at FROM health_data WHERE user_id = ? ORDER BY recorded_at DESC LIMIT 1');
$stmt->execute([$userId]);
$latest = $stmt->fetch();

// Simple rule-based suggestions from the latest reading
$suggestions = [];
if ($latest) {
    if ($latest['bpm'] > 100) {
        $suggestions[] = 'Your heart rate is on the higher side. Consider resting and re-checking shortly.';
    } elseif ($latest['bpm'] < 60) {
        $suggestions[] = 'Your heart rate is on the lower side. If you feel dizzy or unwell, consider seeing a doctor.';
    } else {
        $suggestions[] = 'Your heart rate looks within a normal resting range.';
    }

    if ($latest['spo2'] < 95) {
        $suggestions[] = 'Your SpO2 is below the typical healthy range (95–100%). Consider consulting a healthcare provider.';
    } else {
        $suggestions[] = 'Your oxygen saturation looks healthy.';
    }
} else {
    $suggestions[] = 'No readings yet — use "Generate demo data" below, or add rows to the health_data table, to populate your dashboard.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMonitor - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

        <?php if (isset($_GET['seeded'])): ?>
            <div class="error success"><p>Demo data generated.</p></div>
        <?php endif; ?>

        <div class="vital-section">
            <div class="vital-card">
                <h3>Heart Rate (BPM)</h3>
                <p class="value"><?php echo $latest ? (int) $latest['bpm'] : '--'; ?></p>
            </div>
            <div class="vital-card">
                <h3>Oxygen Level (SpO2)</h3>
                <p class="value"><?php echo $latest ? (int) $latest['spo2'] . '%' : '--'; ?></p>
            </div>
        </div>

        <div class="suggestions-section">
            <h3>Health Suggestions</h3>
            <?php foreach ($suggestions as $s): ?>
                <p><?php echo htmlspecialchars($s); ?></p>
            <?php endforeach; ?>
        </div>

        <?php if (!$latest): ?>
            <form class="demo-data-form" action="api/seed_data.php" method="GET">
                <button class="mybutton primary" type="submit" style="width:auto; padding:10px 24px;">Generate demo data</button>
            </form>
        <?php endif; ?>

        <div class="historical-data">
            <h3>Your Health Trends</h3>
            <canvas id="historyChart" height="100"></canvas>
        </div>
    </div>

    <script src="assets/js/dashboard.js"></script>
</body>
</html>
