<?php
session_start();
require_once '../includes/functions.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    foreach ($users as $user) {
        if ($user["username"] === $username && $user["password"] === $password) {
            session_regenerate_id(true);

            $_SESSION["username"] = $user["username"];
            $_SESSION["status"] = $user["status"];
            $_SESSION["login_time"] = time();

            header("Location: ../index.php");
            exit;
        }
    }

    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThemeForge Login</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/themes/claude.css">
</head>
<body>

<div class="login-page">
    <form method="POST" class="login-card">
        <div class="login-brand">
            <span class="brand-icon">TF</span>
            <div>
                <h2>ThemeForge Login</h2>
                <p>Access your theme dashboard</p>
            </div>
        </div>

        <?php if ($error): ?>
            <p class="form-error"><?= $error ?></p>
        <?php endif; ?>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>

        <button type="submit" class="login-btn">Login</button>
    </form>
</div>

</body>
</html>