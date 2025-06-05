<?php
session_start();
include 'database.php';

$user_id = $_GET['id'];
$allowed_ips = ['127.0.0.1', '::1'];
if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips) && !isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] !== $user_id && !in_array($_SERVER['REMOTE_ADDR'], $allowed_ips))) {
    die('Access denied');
}

$stmt = $db->prepare('SELECT secret FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$secret = $stmt->fetchColumn();

if ($secret) {
    echo "<h2>Your Secret: " . htmlspecialchars($secret) . "</h2>";
} else {
    echo "<h2>No secret found.</h2>";
}
?>
