<?php
session_name('user_session');
session_start();
include "../../tema/includes/header/header.php";
include "../../tema/includes/config.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    header("Location: /");
    exit;
}

$stmt = $baglanti->prepare("SELECT * FROM ads WHERE id = ?");
$stmt->execute([$id]);
$ad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ad) {
    echo "Elan tapılmadı.";
    exit;
}

$operationText = match (strtolower($ad['operation_type'])) {
    'kiraye', 'kira' => 'Kirayə',
    'satiliq', 'satış' => 'Satılıq',
    default => '—'
};

$updateView = $baglanti->prepare("UPDATE ads SET view_count = view_count + 1 WHERE id = ?");
$updateView->execute([$id]);

$userStmt = $baglanti->prepare("SELECT first_name, last_name, phone, profile_photo FROM users WHERE id = ?");
$userStmt->execute([$ad['user_id']]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

$images = json_decode($ad['images'], true) ?? [];
?>

<div class="container px-3 px-md-4">
    <div class="row gx-4 gy-5 pb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="fw-bold mb-0 mb-lg-0">
                        <?= htmlspecialchars($ad['title']) ?>
                    </h4>
                    <?php if ($ad['is_promoted']): ?>
                        <i class="bi bi-star-fill text-warning fs-5" title="Öne Çıxarılmış Elan"></i>
                    <?php endif; ?>
                </div>
                <span class="text-muted small text-decoration-underline" style="font-size: 0.75rem;">ID: <?= htmlspecialchars($ad['id']) ?></span>
            </div>
            </h4>

            <div class="row gx-3 gy-3 mb-4">
                <div class="col-md-7">
                    <img src="../../tema/<?= htmlspecialchars($images[0] ?? 'assets/no-image.webp') ?>" class="gallery-main rounded-4 w-100" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="0" alt="Ana Görsel">
                </div>
                <div class="col-md-5">
                    <div class="row g-3">
                        <?php for ($i = 1; $i < min(5, count($images)); $i++): ?>
                            <div class="col-6">
                                <img src="../../tema/<?= htmlspecialchars($images[$i]) ?>" class="gallery-sub rounded-4 w-100" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="<?= $i ?>" alt="Görsel <?= $i + 1 ?>">
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <!-- SOL BLOK -->
            <div class="col-lg-8">
                <div class="row row-cols-2 row-cols-md-4 text-center py-3 mb-4 g-3">
                    <?php
                    $details = [
                        'Kateqoriya' => [$ad['category'], 'bi bi-grid'],
                        'Əməliyyat növü' => [$operationText, ''],
                        'Sahə' => [$ad['area'] . ' m²', 'bi bi-aspect-ratio'],
                        'Torpaq sahəsi' => [$ad['land_area'] . ' m²', 'bi bi-aspect-ratio-fill'],
                        'Otaq sayı' => [$ad['room_count'], 'bi bi-door-closed'],
                        'Mərtəbə' => [$ad['floor'], 'bi bi-building'],
                        'Çıxarış' => [$ad['certificate'] ? 'Bəli' : 'Xeyr', 'bi bi-check2-circle'],
                        'Təmirli' => [$ad['renovated'] ? 'Bəli' : 'Xeyr', 'bi bi-tools']
                    ];
                    foreach ($details as $label => [$value, $icon]): ?>
                        <div class="col">
                            <div class="text-muted"><?= $label ?></div>
                            <strong><?= $icon ? "<i class='$icon'></i> " : "" ?><?= htmlspecialchars($value) ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold">Elan haqqında</h5>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($ad['description'])) ?></p>
                </div>

                <?php $features = json_decode($ad['features'], true); ?>
                <?php if (!empty($features) && is_array($features)): ?>
                    <div class="mb-4">
                        <h6 class="fw-semibold">Xüsusiyyətlər:</h6>
                        <div class="row row-cols-2 row-cols-md-2 g-3">
                            <?php
                            $featureIcons = [
                                'Lift' => 'bi-building-up',
                                'Parking' => 'bi-car-front',
                                'Kombi' => 'bi-thermometer-sun',
                                'İsti döşəmə' => 'bi-fire',
                                'Balkon' => 'bi-door-open',
                                'Mətbəx mebeli' => 'bi-cup-straw',
                                'Su çəni' => 'bi-droplet',
                                'Kamera sistemi' => 'bi-camera-video',
                                'Təhlükəsizlik' => 'bi-shield-lock',
                                'Quruducu maşın' => 'bi-droplet-half',
                                '1 Sanitar qovşaq' => 'bi-toilet'
                            ];
                            foreach ($features as $feature):
                                $icon = $featureIcons[$feature] ?? 'bi-check-circle';
                            ?>
                                <div class="col d-flex align-items-center gap-2">
                                    <i class="bi <?= $icon ?> text-dark"></i>
                                    <span class="text-muted small"><?= htmlspecialchars($feature) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <h6 class="fw-semibold">Ünvan:</h6>
                <p class="text-muted"><?= htmlspecialchars($ad['address']) ?></p>

                <?php if ($ad['mortgage']): ?>
                    <div class="alert alert-info"><i class="bi bi-info-circle"></i> Bu elan ipotekaya uyğundur.</div>
                <?php endif; ?>

                <div class="mt-4 rounded overflow-hidden">
                    <iframe src="https://maps.google.com/maps?q=<?= $ad['latitude'] ?>,<?= $ad['longitude'] ?>&z=15&output=embed" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen></iframe>
                </div>
            </div>

            <!-- SAĞ BLOK -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card-style mb-4 text-center">
                    <h4 class="fw-bold"><?= htmlspecialchars(number_format($ad['price'], 0, ',', ' ')) ?> AZN</h4>
                    <p class="text-muted"><?= number_format($ad['price'] / ($ad['area'] ?: 1), 0, ',', ' ') ?> AZN/m²</p>
                </div>

                <div class="card-style mb-4 text-center">
                    <img src="<?= !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : '../../assets/proifle.png' ?>" alt="Profil" class="rounded-circle mb-2" width="50">
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h6>
                    <p class="text-muted small mb-2">Telefon: <?= htmlspecialchars($user['phone']) ?></p>
                    <a href="tel:<?= htmlspecialchars($user['phone']) ?>" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-telephone"></i> Zəng et
                    </a>
                </div>

                <div class="text-center mb-3">
                    <div class="text-muted"><?= $ad['view_count'] ?> baxış</div>
                    <button id="complaintButton" class="btn btn-outline-danger mt-2 rounded-pill">
                        <i class="bi bi-flag"></i> Şikayət et
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Galeri Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen m-0 p-0 ">

            <div class="modal-content bg-black border-0 w-100">
                <div class="modal-header border-0 p-2">
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center overflow-hidden">
                    <div id="modalCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                        <div class="carousel-inner w-100 h-100">
                            <?php foreach ($images as $index => $img): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> h-100">
                                    <img src="../../tema/<?= htmlspecialchars($img) ?>" class="img-fluid h-100 object-fit-contain mx-auto d-block" alt="...">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

    document.getElementById('complaintButton').addEventListener('click', function() {
        if (isLoggedIn) {
            const modal = new bootstrap.Modal(document.getElementById('complaintModal'));
            modal.show();
        } else {
            window.location.href = '/pages/auth/login.php';
        }
    });

    const galleryImages = document.querySelectorAll('.gallery-main, .gallery-sub');
    const modalCarousel = document.querySelector('#modalCarousel');
    modalCarousel.setAttribute('data-bs-ride', 'false');
    modalCarousel.setAttribute('data-bs-interval', 'false');

    galleryImages.forEach(img => {
        img.addEventListener('click', () => {
            const index = parseInt(img.getAttribute('data-index'));
            const carousel = bootstrap.Carousel.getInstance(modalCarousel) || new bootstrap.Carousel(modalCarousel);
            carousel.to(index);
        });
    });
</script>

<style>
    .gallery-main {
        height: 400px;
        object-fit: cover;
        border-radius: 16px;
    }

    .gallery-sub {
        height: 195px;
        object-fit: cover;
        border-radius: 16px;
    }

    .card-style {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 16px;
        padding: 24px;
    }

    /* 🎯 Karusel içindeki büyük görsel için düzeltme */
    .carousel-item img {
        max-height: 100vh;
        max-width: 100%;
        object-fit: contain;
        margin: auto;
        display: block;
        background-color: #000;
    }
</style>


<?php include "../../tema/ads/adsdetail/ads_complaint_modal.php"; ?>
<?php include "../../tema/includes/footer/footer.php"; ?>