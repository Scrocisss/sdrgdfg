<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'database.php';

$id = $_SESSION['user_id'];
$stmt = $db->prepare('SELECT avatar FROM users WHERE id = ?');
$stmt->execute([$id]);
$url = $stmt->fetchColumn();

$default_avatar = 'https://hackerlab.pro/game_api/images/avatars/4f7d8c97-12c1-4930-90f5-34d40b4d8526.webp?1745843705237&w=256&q=75';

if (!preg_match('/^https?:\/\//i', $url)) {
    $url = $default_avatar;
}

$data = file_get_contents($url);
if ($data === false) {
    $data = file_get_contents($default_avatar);
}

$info = getimagesizefromstring($data);
header('Content-Type: ' . $info['mime']);
echo $data;
?>