<?php
session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/User.php';

$database = new Database();
$db = $database->connect();

$userObj = new User($db);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)) {
        try {
            $registered = $userObj->register($firstName, $lastName, $email, $password);

            if ($registered) {
                $message = "Account created successfully. You can now login.";
            } else {
                $message = "Registration failed.";
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
    <title>Register</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Create Account</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
    </nav>

    <?php if (!empty($message)): ?>
        <p class="<?= str_contains($message, 'successfully') ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <label>First Name</label>
        <input type="text" name="first_name" required>

        <label>Last Name</label>
        <input type="text" name="last_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>