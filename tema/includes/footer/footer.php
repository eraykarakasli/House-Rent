<?php
include_once __DIR__ . "/../config.php";

// Site ayarlarını çek
$stmt = $baglanti->prepare("SELECT * FROM site_settings ORDER BY id DESC LIMIT 1");
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$phone = $settings['phone'] ?? '';
$email = $settings['email'] ?? '';
$facebook = $settings['facebook'] ?? '';
$instagram = $settings['instagram'] ?? '';
$about = $settings['sayt_haqqinda'] ?? '';
$site_logo = '/' . ltrim($settings['logo'] ?? 'assets/icon.png', '/');

// Static page'leri al
$pageStmt = $baglanti->prepare("SELECT title, slug FROM static_pages WHERE slug IS NOT NULL AND title IS NOT NULL ORDER BY id ASC");
$pageStmt->execute();
$staticPages = $pageStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<footer class="bg-light py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 gx-5 gy-5">

            <!-- Logo ve açıklama -->
            <div class="col-12 col-md-6 col-lg-3 text-center text-md-start">
                <img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo" style="height: 40px;">
                <p class="mt-2 text-muted"><?= htmlspecialchars($about) ?></p>
                <small class="text-muted d-block">© Copyright 2025 @eraykarakasli<br>Bütün hüquqlar qorunur.</small>
            </div>

            <!-- Dinamik Menyu -->
            <div class="col-6 col-lg-2 text-center text-md-start">
                <h6 class="fw-bold">Menyu</h6>
                <ul class="list-unstyled d-inline-block text-center text-md-start">
                    <?php foreach ($staticPages as $page): ?>
                        <li>
                            <a href="/pages/info/static_page.php?slug=<?= urlencode($page['slug']) ?>" class="text-decoration-none text-muted">
                                <?= htmlspecialchars($page['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li><a href="/pages/info/blog.php" class="text-decoration-none text-muted">Blog</a></li>
                </ul>
            </div>

            <!-- Dəstək -->
            <div class="col-6 col-lg-2 text-center text-md-start">
                <h6 class="fw-bold">Dəstək</h6>
                <ul class="list-unstyled d-inline-block text-center text-md-start">
                    <li><a href="/pages/info/terms.php" class="text-decoration-none text-muted">İstifadəçi razılaşması</a></li>
                    <li><a href="/pages/info/privacy.php" class="text-decoration-none text-muted">Məxfilik siyasəti</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Sual-cavablar</a></li>
                </ul>
            </div>

            <!-- Əlaqə -->
            <div class="col text-center text-md-start">
                <h6 class="fw-bold">Əlaqə</h6>

                <?php if (!empty($phone)): ?>
                    <p class="mb-1">
                        <a href="tel:<?= htmlspecialchars($phone) ?>" class="text-decoration-none text-muted">
                            <i class="bi bi-telephone me-2"></i><?= htmlspecialchars($phone) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($email)): ?>
                    <p class="mb-1">
                        <a href="mailto:<?= htmlspecialchars($email) ?>" class="text-decoration-none text-muted">
                            <i class="bi bi-envelope me-2"></i><?= htmlspecialchars($email) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($facebook)): ?>
                    <p class="mb-1">
                        <a href="<?= htmlspecialchars($facebook) ?>" target="_blank" class="text-decoration-none text-muted">
                            <i class="bi bi-facebook me-2"></i>Facebook
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($instagram)): ?>
                    <p class="mb-1">
                        <a href="<?= htmlspecialchars($instagram) ?>" target="_blank" class="text-decoration-none text-muted">
                            <i class="bi bi-instagram me-2"></i>Instagram
                        </a>
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</footer>


</body>
</html>
