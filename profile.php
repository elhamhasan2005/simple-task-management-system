<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/User.php';

$database = new Database();
$db = $database->connect();

$userObj = new User($db);
$user = $userObj->getById($_SESSION['user_id']);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);

    if (!empty($firstName) && !empty($lastName) && !empty($email)) {
        try {
            $updated = $userObj->updateProfile($_SESSION['user_id'], $firstName, $lastName, $email);

            if ($updated) {
                $_SESSION['first_name'] = $firstName;
                $_SESSION['last_name'] = $lastName;
                $_SESSION['email'] = $email;

                $message = "Profile updated successfully.";
                $user = $userObj->getById($_SESSION['user_id']);
            } else {
                $message = "Profile update failed.";
            }
        } catch (PDOException $e) {
            $message = "Email already exists or database error.";
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
    <title>Profile</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>My Profile</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="admin/dashboard.php">Admin Panel</a>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </nav>

    <?php if (!empty($message)): ?>
        <p class="<?= str_contains($message, 'successfully') ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>

        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>