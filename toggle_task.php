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

$taskObj->toggleStatus($taskId);

if ($_SESSION['role'] === 'admin') {
    header("Location: admin/tasks.php");
} else {
    header("Location: dashboard.php");
}

exit;