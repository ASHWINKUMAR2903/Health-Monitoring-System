<?php
require '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$userId = $_SESSION['user_id'];

// Generate 30 days of one reading/day with realistic random variation.
$stmt = $pdo->prepare('INSERT INTO health_data (user_id, recorded_at, bpm, spo2) VALUES (?, ?, ?, ?)');

for ($i = 29; $i >= 0; $i--) {
    $date = date('Y-m-d H:i:s', strtotime("-{$i} days"));
    $bpm  = random_int(62, 95);
    $spo2 = random_int(95, 99);
    $stmt->execute([$userId, $date, $bpm, $spo2]);
}

header('Location: ../dashboard.php?seeded=1');
exit;
