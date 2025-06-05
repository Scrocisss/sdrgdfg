<?php
session_start();
include 'database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $db->prepare('SELECT id,password,role FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($u && password_verify($password, $u['password'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $u['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<h1>Sign In</h1>
<?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="POST" action="login.php" class="auth-form">
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Sign In</button>
  <p>Don't have an account? <a href="register.php">Sign Up</a></p>
</form>
</body>
</html>