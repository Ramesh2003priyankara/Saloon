<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'clerk') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Clerk Dashboard</title>
</head>
<body>
  <h1>Welcome Clerk, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
  <a href="logout.php">Logout</a>
</body>
</html>
