<?php
require '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$start  = $_GET['start'] ?? null;
$end    = $_GET['end'] ?? null;

$sql = 'SELECT recorded_at, bpm, spo2 FROM health_data WHERE user_id = ?';
$params = [$userId];

if ($start) {
    $sql .= ' AND recorded_at >= ?';
    $params[] = $start . ' 00:00:00';
}
if ($end) {
    $sql .= ' AND recorded_at <= ?';
    $params[] = $end . ' 23:59:59';
}
$sql .= ' ORDER BY recorded_at ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

echo json_encode([
    'dates' => array_map(fn($r) => $r['recorded_at'], $rows),
    'bpm'   => array_map(fn($r) => (int) $r['bpm'], $rows),
    'spo2'  => array_map(fn($r) => (int) $r['spo2'], $rows),
]);
