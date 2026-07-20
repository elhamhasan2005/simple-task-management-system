<?php
session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/User.php';

$database = new Database();
$db = $database->connect();

$userObj = new User($db);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $user = $userObj->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
                exit;
            } else {
                header("Location: dashboard.php");
                exit;
            }
        } else {
            $message = "Invalid email or password.";
        }
    } else {
        $message = "Please enter email and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Login</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
    </nav>

    <?php if (!empty($message)): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>