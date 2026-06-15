<!DOCTYPE html>
<html lang="en" class="<?= $currentTheme['mode'] === 'dark' ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThemeForge</title>

    <link rel="stylesheet" href="<?= $basePath ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $basePath ?>assets/css/themes/<?= $currentTheme['file'] ?>">
</head>

<body>
<header class="site-header">
    <div class="container header-inner">
        <div>
            <h1>ThemeForge</h1>
            <p>Welcome, <?= $_SESSION["username"] ?? "Guest" ?></p>
        </div>

        <nav class="nav-links">
            <a href="<?= $basePath ?>index.php">Dashboard</a>
            <a href="<?= $basePath ?>pages/themes.php">Gallery</a>
            <a href="<?= $basePath ?>pages/logout.php">Logout</a>
        </nav>
    </div>
</header>