<?php
require_once '../includes/auth.php';
require_once '../config/themes.php';

$basePath = "../";

$selectedThemeId = $_COOKIE["selected_theme"] ?? "perplexity";
$currentTheme = $themes[0];

foreach ($themes as $theme) {
    if ($theme["id"] === $selectedThemeId) {
        $currentTheme = $theme;
        break;
    }
}

$uploadDir = "../assets/uploads/";
$files = scandir($uploadDir);
?>

<?php include '../includes/header.php'; ?>

<main class="container gallery-page">
    <div class="gallery-header">
        <p class="eyebrow">Theme Showcase</p>
        <h2>Uploaded Themes</h2>
        <p>All uploaded dashboard screenshots are displayed here.</p>
    </div>

    <?php if (count($files) <= 2): ?>
        <div class="empty-gallery">
            <h3>No uploads yet.</h3>
            <p>Upload a theme showcase from the dashboard.</p>
            <a href="../index.php" class="primary-link">Go to Dashboard</a>
        </div>
    <?php else: ?>
        <div class="gallery-grid">
            <?php foreach ($files as $file): ?>
                <?php
                if ($file === "." || $file === "..") {
                    continue;
                }

                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (!in_array($extension, ["jpg", "jpeg", "png"])) {
                    continue;
                }

                $themeName = pathinfo($file, PATHINFO_FILENAME);
                ?>

                <article class="gallery-card">
                    <img src="../assets/uploads/<?= $file ?>" alt="<?= $themeName ?>">

                    <div class="gallery-card-body">
                        <h3><?= $themeName ?></h3>
                        <p><?= strtoupper($extension) ?> Theme Showcase</p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>