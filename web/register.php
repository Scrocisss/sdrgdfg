<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $secret = $_POST['secret'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $avatar = $_POST['avatar'];

    // Check if username already exists
    $check_stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
    $check_stmt->execute([$username]);
    $exists = $check_stmt->fetchColumn();

    if ($exists) {
        $error = 'Username already taken';
    } else {
        // Username is available, proceed with registration
        $stmt = $db->prepare('INSERT INTO users (username, password, secret, avatar, role) VALUES (?,?,?,?,\'user\')');
        $stmt->execute([$username, $hash, $secret, $avatar]);
        $id = $db->lastInsertId();
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <h1>Create Account</h1>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="register.php" class="auth-form">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="secret" placeholder="Secret" required>
        <input type="hidden" name="avatar" value="https://hackerlab.pro/game_api/images/avatars/4f7d8c97-12c1-4930-90f5-34d40b4d8526.webp?1745843705237&w=256&q=75">
        <button type="submit">Sign Up</button>
        <p>Already have an account? <a href="login.php">Sign In</a></p>
    </form>
</body>
</html>