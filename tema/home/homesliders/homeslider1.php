<?php

// Kullanıcının favorileri
$userFavorites = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $baglanti->prepare("SELECT favorites FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && !empty($user['favorites'])) {
        $userFavorites = json_decode($user['favorites'], true);
    }
}

// Sadece obyekt kategorisinden öne çıkarılmış ilanları alalım
$stmt = $baglanti->prepare("SELECT * FROM ads WHERE category = 'obyekt' AND status = 1 AND is_promoted = 1 ORDER BY created_at DESC LIMIT 10");
$stmt->execute();
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <div class="d-flex gap-2 align-items-center mb-3">
        <h4 class="fw-bold">Öne Çıxarılmış Obyekt Elanları</h4>
    </div>

    <div class="position-relative">
        <div class="d-flex flex-nowrap overflow-auto gap-3 pb-3 px-2" id="obyektSlider" style="scroll-behavior: smooth;">
            <?php foreach ($ads as $ad): ?>
                <?php
                    $images = json_decode($ad['images'], true);
                    $firstImage = !empty($images) ? "../../tema/" . ltrim($images[0], '/') : "../../assets/no-image.webp";
                ?>
                <div onclick="window.location.href='../../pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>'" class="text-decoration-none text-dark" style="cursor:pointer; width: 250px; flex: 0 0 auto;">
                    <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden w-100">

                        <!-- İlan Resmi -->
                        <div class="position-relative" style="height: 180px;">
                            <img src="<?= htmlspecialchars($firstImage) ?>" class="d-block w-100" alt="İlan Fotoğrafı" style="height: 180px; object-fit: cover;">

                            <!-- Favori butonu -->
                            <a href="../../tema/includes/add_fav.php?id=<?= $ad['id'] ?>" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2 p-1" onclick="event.stopPropagation();">
                                <i class="bi <?= in_array((int)$ad['id'], $userFavorites) ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i>
                            </a>

                            <!-- Kupça, İpoteka, Təmirli ikonları -->
                            <div class="position-absolute top-0 start-0 m-2">
                                <?php if (!empty($ad['certificate']) && $ad['certificate'] == 1): ?>
                                    <span class="btn btn-success btn-sm rounded-circle p-1" title="Çıxarış var">
                                        <i class="bi bi-clipboard-check-fill"></i>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($ad['mortgage']) && $ad['mortgage'] == 1): ?>
                                    <span class="btn btn-warning btn-sm rounded-circle p-1" title="İpoteka var">
                                        <i class="bi bi-percent"></i>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($ad['renovated']) && $ad['renovated'] == 1): ?>
                                    <span class="btn btn-danger btn-sm rounded-circle p-1" title="Təmirli">
                                        <i class="bi bi-hammer"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- İlan Bilgileri -->
                        <div class="p-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong class="fs-6"><?= htmlspecialchars(number_format($ad['price'], 0, ',', ' ')) ?> AZN</strong>
                                <small class="text-muted" style="font-size: 12px;">
                                    <?= date("d.m.Y", strtotime($ad['created_at'])) ?>
                                </small>
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
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Kaydırma Okları -->
        <button class="btn btn-light position-absolute top-50 start-0 translate-middle-y shadow rounded-circle" onclick="scrollSlider('obyektSlider', -1)">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="btn btn-light position-absolute top-50 end-0 translate-middle-y shadow rounded-circle" onclick="scrollSlider('obyektSlider', 1)">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <!-- Tümünü Gör Butonu -->
    <div class="w-100 text-center mt-3">
        <a href="/pages/ads/ads.php?category=obyekt" class="btn btn-dark btn-sm p-2 fs-6 rounded-3">Bütün obyekt elanları</a>
    </div>
</div>

<script>
function scrollSlider(id, direction) {
    const slider = document.getElementById(id);
    const scrollAmount = 320;
    slider.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}
</script>
