<?php
try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=webapp', 'webuser', 'webpassword');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('DB error: ' . $e->getMessage());
}
?>
