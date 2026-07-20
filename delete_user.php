<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/User.php';

$database = new Database();
$db = $database->connect();

$userObj = new User($db);

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$userId = (int) $_GET['id'];

if ($userId === (int) $_SESSION['user_id']) {
    header("Location: users.php");
    exit;
}

$userObj->deleteUser($userId);

header("Location: users.php");
exit;