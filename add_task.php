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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title) && !empty($description)) {
        $created = $taskObj->createTask($_SESSION['user_id'], $title, $description);

        if ($created) {
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Failed to add task.";
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
    <title>Add Task</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Add New Task</h1>

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
        <input type="text" name="title" required>

        <label>Description / Notes</label>
        <textarea name="description" rows="5" required></textarea>

        <button type="submit">Add Task</button>
    </form>
</div>

</body>
</html>