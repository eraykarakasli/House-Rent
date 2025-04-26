<?php
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

// Görüntülenmeyi artır
$updateView = $baglanti->prepare("UPDATE ads SET view_count = view_count + 1 WHERE id = ?");
$updateView->execute([$id]);

$userStmt = $baglanti->prepare("SELECT first_name, last_name, phone, profile_photo FROM users WHERE id = ?");
$userStmt->execute([$ad['user_id']]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

$images = json_decode($ad['images'], true) ?? [];
?>

<div class="container">
    <div class="row gap-5 pb-5">
        <div class="col-12">
            <h4 class="fw-bold mb-4"><?= htmlspecialchars($ad['title']) ?></h4>

            <div class="d-flex gap-2 mb-4" style="height: 400px;">
                <div class="w-50">
                    <img src="../../tema/<?= htmlspecialchars($images[0] ?? 'assets/no-image.webp') ?>" class="cursor-pointer img-fluid rounded w-100 h-100 object-fit-cover gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="0" alt="Ana Görsel" style="cursor: pointer;">
                </div>
                <div class="w-50 d-flex flex-wrap gap-2">
                    <?php for ($i = 1; $i < min(5, count($images)); $i++): ?>
                        <div class="position-relative" style="width: calc(50% - 4px); height: 49%;">
                            <img src="../../tema/<?= htmlspecialchars($images[$i]) ?>" class="img-fluid rounded w-100 h-100 object-fit-cover gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="<?= $i ?>" alt="Görsel <?= $i + 1 ?>" style="cursor: pointer;">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen m-0 w-100">
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
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="row text-center py-3 mb-4">
                    <div class="col">
                        <div class="text-muted">Kateqoriya</div>
                        <strong><i class="bi bi-grid"></i> <?= htmlspecialchars($ad['category']) ?></strong>
                    </div>
                    <div class="col">
                        <div class="text-muted">Sahə</div>
                        <strong><i class="bi bi-aspect-ratio"></i> <?= htmlspecialchars($ad['area']) ?>m²</strong>
                    </div>
                    <div class="col">
                        <div class="text-muted">Çıxarış</div>
                        <strong><i class="bi bi-check2-circle"></i> <?= $ad['certificate'] ? 'Bəli' : 'Xeyr' ?></strong>
                    </div>
                    <div class="col">
                        <div class="text-muted">Təmirli</div>
                        <strong><i class="bi bi-tools"></i> <?= $ad['renovated'] ? 'Bəli' : 'Xeyr' ?></strong>
                    </div>
                </div>

                <h5 class="fw-bold">Elan haqqında</h5>
                <p class="text-muted"><?= nl2br(htmlspecialchars($ad['description'])) ?></p>

                <h6 class="fw-semibold mt-4">Ünvan:</h6>
                <p class="text-muted"> <?= htmlspecialchars($ad['address']) ?> </p>

                <!-- Google Maps iframe -->
                <div class="mt-4 rounded overflow-hidden">
                    <iframe src="https://maps.google.com/maps?q=<?= $ad['latitude'] ?>,<?= $ad['longitude'] ?>&z=15&output=embed" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen></iframe>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-white border rounded-4 p-4 mb-4">
                    <h4 class="fw-bold"><?= htmlspecialchars(number_format($ad['price'], 0, ',', ' ')) ?> AZN</h4>
                    <p class="text-muted"><?= number_format($ad['price'] / ($ad['area'] ?: 1), 0, ',', ' ') ?> AZN/m²</p>
                    <button class="btn btn-dark w-100">
                        <i class="bi bi-calculator"></i> İpoteka hesabla
                    </button>
                </div>

                <div class="bg-white border rounded-4 p-4 mb-4 text-center">
                    <img src="<?= !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : '../../assets/proifle.png' ?>" alt="Profil" class="rounded-circle mb-2" width="50">
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h6>
                    <p class="text-muted small mb-2">Telefon: <?= htmlspecialchars($user['phone']) ?></p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="tel:<?= htmlspecialchars($user['phone']) ?>" class="btn btn-primary d-flex align-items-center gap-2 p-2">
                            <i class="bi bi-telephone"></i> Zəng et
                        </a>
                        <!-- <button class="btn btn-outline-primary d-flex align-items-center gap-2 p-2"><i class="bi bi-chat-dots"></i> Mesaj yaz</button> -->
                    </div>
                </div>

                <div class="bg-white border-bottom p-4 text-center">
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold"><?= htmlspecialchars($ad['view_count']) ?></h6>
                            <div class="text-muted">Baxış sayı</div>
                        </div>
                    </div>
                </div>

                <div class="fw-semibold d-flex justify-content-center mt-3 gap-2">
                    <button class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#complaintModal">
                        <i class="bi bi-flag"></i> Şikayət et
                    </button>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
    const galleryImages = document.querySelectorAll('.gallery-img');
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

<?php include "../../tema/ads/adsdetail/ads_complaint_modal.php"; ?>
<?php include "../../tema/includes/footer/footer.php"; ?>