<?php
session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/Task.php';

$database = new Database();
$db = $database->connect();

$taskObj = new Task($db);
$recentTasks = $taskObj->getRecentPendingTasks(5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Simple Task Management System</h1>

    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>

            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin/dashboard.php">Admin Panel</a>
            <?php endif; ?>

            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>

    <h2>Recent Pending Tasks</h2>

    <?php if (!empty($recentTasks)): ?>
        <table>
            <tr>
                <th>Task Title</th>
                <th>Description</th>
                <th>User</th>
                <th>Created At</th>
            </tr>

            <?php foreach ($recentTasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= htmlspecialchars($task['first_name'] . ' ' . $task['last_name']) ?></td>
                    <td><?= htmlspecialchars($task['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No pending tasks found.</p>
    <?php endif; ?>
</div>

</body>
</html>