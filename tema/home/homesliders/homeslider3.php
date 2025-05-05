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

$categories = [
    'obyekt' => 'Obyekt',
    'ofis' => 'Ofis',
    'qaraj' => 'Qaraj',
    'torpaq' => 'Torpaq',
    'menzil' => 'Menzil',
    'heyet' => 'Həyət evi / Bağ evi'
];

foreach ($categories as $catKey => $catName):
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE category = ? AND status = 1 AND is_promoted = 1 ORDER BY created_at DESC LIMIT 10");
    $stmt->execute([$catKey]);
    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($ads)) continue;
?>
    <div class="container my-5">
        <div class="d-flex gap-2 align-items-center mb-3">
            <h4 class="fw-bold"><?= $catName ?> Elanları</h4>
        </div>
        <div class="position-relative">
            <div class="d-flex flex-nowrap overflow-auto gap-3 pb-3 px-2 slider-scroll" id="slider-<?= $catKey ?>" style="scroll-behavior: smooth;">
                <?php foreach ($ads as $ad): ?>
                    <?php
                    $images = json_decode($ad['images'], true);
                    $firstImage = !empty($images) ? "../../tema/" . ltrim($images[0], '/') : "../../assets/no-image.webp";
                    ?>
                    <div class="text-decoration-none text-dark" style="cursor:pointer; width: 250px; flex: 0 0 auto;">
                        <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden w-100">
                            <!-- Resim ve favori butonu -->
                            <div class="position-relative" style="height: 180px;" onclick="window.location.href='../../pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>'">
                                <img src="<?= htmlspecialchars($firstImage) ?>" class="d-block w-100" alt="İlan Fotoğrafı" style="height: 180px; object-fit: cover;">

                                <!-- Favori butonu -->
                                <a href="#" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2" onclick="toggleFavorite(event, <?= $ad['id'] ?>)">
                                    <i class="bi <?= in_array((int)$ad['id'], $userFavorites) ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i>
                                </a>

                                <!-- Ek ikonlar -->
                                <div class="position-absolute top-0 start-0 m-2">
                                    <?php if (!empty($ad['certificate']) && $ad['certificate'] == 1): ?>
                                        <span class="btn btn-success btn-sm rounded-circle" title="Çıxarış var">
                                            <i class="bi bi-clipboard-check-fill"></i>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($ad['mortgage']) && $ad['mortgage'] == 1): ?>
                                        <span class="btn btn-warning btn-sm rounded-circle" title="İpoteka var">
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

                            <!-- Bilgi bölümü -->
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
                    </div>

                <?php endforeach; ?>
            </div>
            <button class="btn btn-light position-absolute top-50 start-0 translate-middle-y shadow rounded-circle" onclick="scrollSlider('slider-<?= $catKey ?>', -1)">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="btn btn-light position-absolute top-50 end-0 translate-middle-y shadow rounded-circle" onclick="scrollSlider('slider-<?= $catKey ?>', 1)">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
        <div class="w-100 text-center mt-3">
            <a href="/pages/ads/ads.php?category=<?= $catKey ?>" class="btn btn-sm p-2 fs-6 rounded-3 fw-semibold" style="background-color: #031f26; color: white;">Bütün <?= $catName ?> elanları</a>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function scrollSlider(id, direction) {
        const slider = document.getElementById(id);
        const firstCard = slider.querySelector('div[style*="width"]');
        const scrollAmount = firstCard ? firstCard.clientWidth + 16 : 320; // 16: gap aralığı
        slider.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }

    function toggleFavorite(e, adId) {
        e.preventDefault();
        e.stopPropagation();

        const allIcons = document.querySelectorAll(`a[onclick*="toggleFavorite"][onclick*="${adId}"] i`);

        fetch('../../tema/includes/add_fav.php?id=' + adId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allIcons.forEach(icon => {
                        icon.classList.remove("bi-heart", "bi-heart-fill", "text-danger");
                        if (data.action === "added") {
                            icon.classList.add("bi-heart-fill", "text-danger");
                        } else {
                            icon.classList.add("bi-heart");
                        }
                    });
                } else {
                    alert("Favori işlemi başarısız: " + data.message);
                }
            })
            .catch(err => console.error("Hata:", err));
    }
</script>
<style>
    .slider-scroll {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .slider-scroll::-webkit-scrollbar {
        display: none;
    }

    @media (max-width: 575.98px) {
        .slider-scroll>div[style*="width: 250px"] {
            width: 100% !important;
        }
    }
</style>