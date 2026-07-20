<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/Task.php';

$database = new Database();
$db = $database->connect();

$taskObj = new Task($db);
$tasks = $taskObj->getTasksByUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['first_name']) ?></h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="add_task.php">Add Task</a>
        <a href="profile.php">Profile</a>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="admin/dashboard.php">Admin Panel</a>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </nav>

    <h2>My Tasks</h2>

    <?php if (!empty($tasks)): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= htmlspecialchars($task['status']) ?></td>
                    <td><?= htmlspecialchars($task['created_at']) ?></td>
                    <td class="actions">
                        <a href="edit_task.php?id=<?= $task['id'] ?>">Edit</a>
                        <a href="toggle_task.php?id=<?= $task['id'] ?>">Toggle Status</a>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
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