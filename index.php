<?php
require_once 'includes/auth.php';
require_once 'config/themes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme_id'])) {
    $themeId = htmlspecialchars(strip_tags(trim($_POST['theme_id'])));
    setcookie('selected_theme', $themeId, time() + (60 * 60 * 10), '/');
    header('Location: index.php');
    exit;
}

$selectedThemeId = $_COOKIE['selected_theme'] ?? 'claude';
$currentTheme = $themes[0];

foreach ($themes as $theme) {
    if ($theme['id'] === $selectedThemeId) {
        $currentTheme = $theme;
        break;
    }
}

$uploadMessage = "";
$uploadError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["theme_image"])) {
    $allowedExtensions = ["jpg", "jpeg", "png"];
    $allowedMimeTypes = ["image/jpeg", "image/png"];

    $fileName = $_FILES["theme_image"]["name"];
    $fileTmp = $_FILES["theme_image"]["tmp_name"];
    $fileError = $_FILES["theme_image"]["error"];

    if ($fileError !== UPLOAD_ERR_OK) {
        $uploadError = "Upload failed. Please try again.";
    } else {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $mimeType = mime_content_type($fileTmp);

        if (!in_array($extension, $allowedExtensions)) {
            $uploadError = "Only JPG, JPEG, and PNG files are allowed.";
        } elseif (!in_array($mimeType, $allowedMimeTypes)) {
            $uploadError = "Invalid file type.";
        } else {
            $uploadDir = __DIR__ . "/assets/uploads/";

            $newFileName = "theme_showcase_" . time() . "." . $extension;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $uploadPath)) {
                $uploadMessage = "Theme showcase uploaded successfully.";
            } else {
                $uploadError = "Could not save uploaded file.";
            }
        }
    }
}

include 'includes/header.php';
?>

<main class="container dashboard-layout">

  <aside class="sidebar">
    <p class="eyebrow">Themes</p>

    <?php foreach ($themes as $theme):
      $isActive = $currentTheme['id'] === $theme['id'];
    ?>
      <form method="POST">
        <input type="hidden" name="theme_id" value="<?= htmlspecialchars($theme['id']) ?>">
        <button class="theme-card<?= $isActive ? ' theme-card--active' : '' ?>" type="submit">
          <div class="theme-card-top">
            <span class="theme-card-name"><?= htmlspecialchars($theme['name']) ?></span>
            <?php if ($isActive): ?>
              <span class="active-badge">Active</span>
            <?php endif ?>
          </div>
          <p class="theme-card-mode"><?= ucfirst(htmlspecialchars($theme['mode'])) ?> theme</p>
          <div class="theme-preview">
            <span style="background: <?= htmlspecialchars($theme['primary']) ?>"></span>
            <span style="background: <?= htmlspecialchars($theme['secondary']) ?>"></span>
            <span style="background: <?= htmlspecialchars($theme['background']) ?>"></span>
          </div>
        </button>
      </form>
    <?php endforeach ?>
  </aside>

  <section class="preview-panel">
    <p class="eyebrow">Current theme</p>
    <h2 class="preview-panel-name"><?= htmlspecialchars($currentTheme['name']) ?></h2>

    <div class="preview-meta">
      <span class="preview-meta-dot"></span>
      <span class="preview-meta-text">Saved for 10 hours via cookie</span>
    </div>

    <p>Your selected theme is applied across the entire dashboard. Switch anytime — your preference is remembered automatically.</p>

    <hr class="preview-divider">

    <p class="eyebrow" style="margin-bottom: 12px">Preview</p>
    <div class="button-row">
      <button class="primary-btn">Primary action</button>
      <button class="secondary-btn">Secondary</button>
    </div>
    <div class="upload-card">
      <h3>Upload Theme Showcase</h3>
      <p>Upload a screenshot of your themed dashboard.</p>

      <?php if ($uploadMessage): ?>
          <div class="success-message"><?= $uploadMessage ?></div>
      <?php endif; ?>

      <?php if ($uploadError): ?>
          <div class="error-message"><?= $uploadError ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="upload-form">
          <input type="file" name="theme_image" accept=".jpg,.jpeg,.png" required>
          <button type="submit" class="primary-btn">Upload Showcase</button>
      </form>
    </div>
  </section>

<?php include 'includes/footer.php'; ?>