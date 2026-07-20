<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h1>Admin Dashboard</h1>

    <nav>
        <a href="../index.php">Home</a>
        <a href="../dashboard.php">User Dashboard</a>
        <a href="users.php">Manage Users</a>
        <a href="tasks.php">Manage Tasks</a>
        <a href="../profile.php">Profile</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <h2>Welcome Admin, <?= htmlspecialchars($_SESSION['first_name']) ?></h2>

    <p>From this panel, you can manage all users and all tasks in the system.</p>
</div>

</body>
</html>