<?php
include "../../tema/includes/config.php"; // Eğer zaten dahilse tekrar koymana gerek yok

$map = isset($_GET['map']) && $_GET['map'] === 'on';

// Veritabanından aktif (status = 1) ilanları çekiyoruz
$stmt = $baglanti->prepare("SELECT * FROM ads WHERE status = 1 ORDER BY created_at DESC");
$stmt->execute();
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 <?= $map ? 'row-cols-lg-3' : 'row-cols-lg-5' ?> g-4">
        <?php foreach ($ads as $ad): ?>
            <?php
            // Images alanını JSON'dan array'e çeviriyoruz
            $imagesArray = json_decode($ad['images'], true);

            // İlk resim var mı kontrol ediyoruz
            if (!empty($imagesArray) && is_array($imagesArray)) {
                $firstImage = "../../tema/" . ltrim($imagesArray[0], '/');
            } else {
                $firstImage = "../../assets/no-image.webp"; // Default resim
            }

            // Özellikler alanı
            $features = !empty($ad['features']) ? explode(',', $ad['features']) : [];
            ?>
            <div class="col">
                <a href="../../pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>" class="text-decoration-none text-dark">
                    <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden w-100">

                        <!-- İlan Resmi -->
                        <div class="position-relative" style="height: 200px;">
                            <img src="<?= htmlspecialchars($firstImage) ?>" class="d-block w-100" alt="İlan Fotoğrafı" style="height: 200px; object-fit: cover;">
                            <button class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2">
                                <i class="bi bi-heart"></i>
                            </button>

                            <!-- Dinamik Özellik İkonları -->
                            <div class="position-absolute top-0 start-0 m-2 d-flex flex-row gap-1">

                                <?php if (!empty($ad['certificate']) && $ad['certificate'] == 1): ?>
                                    <span class="btn btn-success btn-sm rounded-circle" title="Çıxarış var">
                                        <i class="bi bi-clipboard-check-fill"></i>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($ad['mortgage']) && $ad['mortgage'] == 1): ?>
                                    <span class="btn btn-warning btn-sm rounded-circle" title="İpoteka mümkündür">
                                        <i class="bi bi-percent"></i>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($ad['renovated']) && $ad['renovated'] == 1): ?>
                                    <span class="btn btn-danger btn-sm rounded-circle" title="Təmirli">
                                        <i class="bi bi-hammer"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- İlan Bilgileri -->
                        <div class="p-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong class="fs-6"><?= htmlspecialchars(number_format($ad['price'], 0, ',', ' ')) ?> AZN</strong>
                                <small class="text-muted" style="font-size: 12px;"><?= date("d.m.Y", strtotime($ad['created_at'])) ?></small>
                            </div>

                            <div class="mb-2 text-secondary d-flex align-items-center py-2">
                                <i class="bi bi-geo-alt me-1"></i>
                                <span><?= htmlspecialchars($ad['address']) ?></span>
                            </div>

                            <div class="d-flex justify-content-between text-secondary mt-2">
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-building me-1"></i>
                                    <span><?= htmlspecialchars($ad['floor']) ?></span>
                                </div>
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-door-open me-1"></i>
                                    <span><?= htmlspecialchars($ad['room_count']) ?> otaq</span>
                                </div>
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-aspect-ratio me-1"></i>
                                    <span><?= htmlspecialchars($ad['area']) ?>m²</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>