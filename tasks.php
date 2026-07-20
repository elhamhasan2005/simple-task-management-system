<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Task.php';

$database = new Database();
$db = $database->connect();

$taskObj = new Task($db);
$tasks = $taskObj->getAllTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tasks</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h1>Manage All Tasks</h1>

    <nav>
        <a href="dashboard.php">Admin Dashboard</a>
        <a href="users.php">Manage Users</a>
        <a href="../dashboard.php">User Dashboard</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <h2>All System Tasks</h2>

    <?php if (!empty($tasks)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Task Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['id']) ?></td>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= htmlspecialchars($task['status']) ?></td>
                    <td><?= htmlspecialchars($task['first_name'] . ' ' . $task['last_name']) ?></td>
                    <td><?= htmlspecialchars($task['email']) ?></td>
                    <td><?= htmlspecialchars($task['created_at']) ?></td>
                    <td class="actions">
                        <a href="../edit_task.php?id=<?= $task['id'] ?>">Edit</a>
                        <a href="../toggle_task.php?id=<?= $task['id'] ?>">Toggle Status</a>
                        <a href="../delete_task.php?id=<?= $task['id'] ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</div>

</body>
</html>