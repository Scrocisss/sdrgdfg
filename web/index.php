<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <div class="profile-section">
        <div class="avatar-container">
            <img src="avatar.php" alt="Avatar">
        </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="info-box">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <h2>Website is still under development. Please check back later.</h2>
	<h3><a href="user.php?id=<?php echo $user_id; ?>">View secret</a></h3>
    </div>
</body>
</html>