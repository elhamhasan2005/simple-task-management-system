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

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$taskId = (int) $_GET['id'];
$task = $taskObj->getTaskById($taskId);

if (!$task) {
    header("Location: dashboard.php");
    exit;
}

if ($_SESSION['role'] !== 'admin' && $task['user_id'] != $_SESSION['user_id']) {
    header("Location: dashboard.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title) && !empty($description)) {
        $updated = $taskObj->updateTask($taskId, $title, $description);

        if ($updated) {
            if ($_SESSION['role'] === 'admin') {
                header("Location: admin/tasks.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $message = "Failed to update task.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Edit Task</h1>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <?php if (!empty($message)): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Task Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>

        <label>Description / Notes</label>
        <textarea name="description" rows="5" required><?= htmlspecialchars($task['description']) ?></textarea>

        <button type="submit">Update Task</button>
    </form>
</div>

</body>
</html>