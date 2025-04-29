<?php
include_once __DIR__ . "/../config.php"; // yol konumuna göre ayarla

$stmt = $baglanti->prepare("SELECT * FROM site_settings ORDER BY id DESC LIMIT 1");
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$phone = $settings['phone'] ?? '';
$email = $settings['email'] ?? '';
$facebook = $settings['facebook'] ?? '';
$instagram = $settings['instagram'] ?? '';
$about = $settings['sayt_haqqinda'] ?? '';
$site_logo = '/' . ltrim($site['logo'] ?? 'assets/icon.png', '/');
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<footer class="bg-light py-5">
    <div class="container">
        <!-- row satırı -->
        <div class="row justify-content-between row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 gx-5 gy-5">



            <!-- Logo ve açıklama -->
            <div class="col-12 col-md-6 col-lg-3">

                <img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo" style="height: 40px;">

                <p class="mt-2 text-muted"><?= htmlspecialchars($about) ?></p>
                <small class="text-muted">© Copyright 2025 Qbit Technologies MMC.<br> Bütün hüquqlar qorunur.</small>
            </div>

            <!-- Menü -->
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold">Menyu</h6>
                <ul class="list-unstyled">
                    <li><a href="/pages/info/aboutus.php" class="text-decoration-none text-muted">Haqqımızda</a></li>
                    <li><a href="/pages/info/blog.php" class="text-decoration-none text-muted">Blog</a></li>
                </ul>
            </div>

            <!-- Dəstək -->
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold">Dəstək</h6>
                <ul class="list-unstyled">
                    <li><a href="/pages/info/terms.php" class="text-decoration-none text-muted">İstifadəçi razılaşması</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Məxfilik siyasəti</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Sual-cavablar</a></li>
                </ul>
            </div>

            <!-- Əlaqə -->
            <div class="col">
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