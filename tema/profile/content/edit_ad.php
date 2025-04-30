<?php

$userId = $_SESSION['user_id'] ?? null;
$adId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$userId || !$adId) {
    header("Location: /login.php");
    exit;
}

$stmt = $baglanti->prepare("SELECT * FROM ads WHERE id = ? AND user_id = ? LIMIT 1");
$stmt->execute([$adId, $userId]);
$ad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ad) {
    echo "<div class='alert alert-danger m-5'>Elan tapılmadı və ya icazəniz yoxdur.</div>";
    exit;
}

$selectedFeatures = json_decode($ad['features'], true);
$images = json_decode($ad['images'], true);

?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="col-md-8 col-lg-9">
    <div class="d-flex justify-content-between align-items-center shadow-sm border rounded-4 p-4 mb-4 flex-wrap gap-3">
        <h4 class="fw-semibold mb-0">Elan Düzenle</h4>
    </div>

    <div class="step-wrapper shadow-sm border rounded-4 p-4">
        <form method="post" action="/tema/includes/ad_update_process.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $ad['id'] ?>">

            <!-- Step 1: Əsas Məlumatlar -->
            <div id="step1" class="step active">
                <h4 class="fw-semibold mb-4">1. Əsas Məlumatlar</h4>

                <div class="mb-3">
                    <label class="form-label">Başlıq</label>
                    <input type="text" class="form-control rounded-3" name="title" value="<?= htmlspecialchars($ad['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kateqoriya</label>
                    <select class="form-select rounded-3" name="category" required>
                        <option value="obyekt" <?= $ad['category'] === 'obyekt' ? 'selected' : '' ?>>Obyekt</option>
                        <option value="ofis" <?= $ad['category'] === 'ofis' ? 'selected' : '' ?>>Ofis</option>
                        <option value="qaraj" <?= $ad['category'] === 'qaraj' ? 'selected' : '' ?>>Qaraj</option>
                        <option value="torpaq" <?= $ad['category'] === 'torpaq' ? 'selected' : '' ?>>Torpaq</option>
                        <option value="menzil" <?= $ad['category'] === 'menzil' ? 'selected' : '' ?>>Menzil</option>
                        <option value="heyet" <?= $ad['category'] === 'heyet' ? 'selected' : '' ?>>Həyət evi / Bağ evi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Əməliyyat növü</label>
                    <select class="form-select rounded-3" name="operation_type" required>
                        <option value="satilik" <?= $ad['operation_type'] === 'satilik' ? 'selected' : '' ?>>Satılıq</option>
                        <option value="kiraye" <?= $ad['operation_type'] === 'kiraye' ? 'selected' : '' ?>>Kirayə</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bina vəziyyəti</label>
                    <select class="form-select rounded-3" name="building_condition" required>
                        <option value="yeni" <?= $ad['building_condition'] === 'yeni' ? 'selected' : '' ?>>Yeni</option>
                        <option value="ikincil" <?= $ad['building_condition'] === 'ikincil' ? 'selected' : '' ?>>İkincil</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sahə (m²)</label>
                    <input type="number" class="form-control rounded-3" name="area" value="<?= $ad['area'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Torpağın sahəsi (m²)</label>
                    <input type="number" class="form-control rounded-3" name="land_area" value="<?= $ad['land_area'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Çıxarış</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificate" value="1" <?= $ad['certificate'] ? 'checked' : '' ?> required>
                        <label class="form-check-label">Var</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificate" value="0" <?= !$ad['certificate'] ? 'checked' : '' ?> required>
                        <label class="form-check-label">Yox</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">İpoteka</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="mortgage" value="1" <?= $ad['mortgage'] ? 'checked' : '' ?> required>
                        <label class="form-check-label">Var</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="mortgage" value="0" <?= !$ad['mortgage'] ? 'checked' : '' ?> required>
                        <label class="form-check-label">Yox</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Təmirli</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="renovated" value="1" <?= $ad['renovated'] ? 'checked' : '' ?> required>
                        <label class="form-check-label">Bəli</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="renovated" value="0" <?= !$ad['renovated'] ? 'checked' : '' ?> required>
                        <label class="form-check-label">Xeyr</label>
                    </div>
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="goToStep(2)">
                        Növbəti <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Əmlak Məlumatları -->
            <div id="step2" class="step">
                <h4 class="fw-semibold mb-4">2. Əmlak Məlumatları</h4>

                <div class="mb-3">
                    <label class="form-label">Mərtəbə</label>
                    <input type="text" class="form-control rounded-3" name="floor" value="<?= $ad['floor'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Otaq sayı</label>
                    <select class="form-select rounded-3" name="room_count" required>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>" <?= $ad['room_count'] == $i ? 'selected' : '' ?>><?= $i ?> otaq</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Qiymət (AZN)</label>
                    <input type="number" class="form-control rounded-3" name="price" value="<?= $ad['price'] ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Elan haqqında məlumat</label>
                    <textarea class="form-control rounded-3" name="description" rows="4" required><?= htmlspecialchars($ad['description']) ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep(1)">
                        <i class="bi bi-chevron-left me-1"></i> Əvvəlki
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="goToStep(3)">
                        Növbəti <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Xüsusiyyətlər, Konum, Adres -->
            <div id="step3" class="step">
                <h4 class="fw-semibold mb-4">3. Xüsusiyyətlər, Konum, Adres</h4>

                <div class="mb-3">
                    <label class="form-label">Ünvan</label>
                    <input type="text" class="form-control rounded-3" name="address" value="<?= htmlspecialchars($ad['address']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Şəhər</label>
                    <input type="text" class="form-control rounded-3" name="city" value="<?= htmlspecialchars($ad['city']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rayon / İlçe</label>
                    <input type="text" class="form-control rounded-3" name="district" value="<?= htmlspecialchars($ad['district']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Məhəllə</label>
                    <input type="text" class="form-control rounded-3" name="neighborhood" value="<?= htmlspecialchars($ad['neighborhood']) ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Xüsusiyyətlər</label>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2">
                        <?php
                        $featureList = ['Lift', 'Parking', 'Kombi', 'İsti döşəmə', 'Balkon', 'Mətbəx mebeli', 'Su çəni', 'Kamera sistemi'];
                        foreach ($featureList as $index => $feature): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="features[]" value="<?= $feature ?>" id="feature<?= $index ?>" <?= in_array($feature, $selectedFeatures) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="feature<?= $index ?>"><?= $feature ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>



                <div class="mb-4">
                    <label class="form-label">Xəritədən konum seçin</label>
                    <div id="map" style="height: 300px; border-radius: 10px;"></div>
                    <input type="hidden" name="latitude" id="latitude" value="<?= $ad['latitude'] ?>">
                    <input type="hidden" name="longitude" id="longitude" value="<?= $ad['longitude'] ?>">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep(2)">
                        <i class="bi bi-chevron-left me-1"></i> Əvvəlki
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="goToStep(4)">
                        Növbəti <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>

            <!-- Step 4: Şəkil Yükləmə -->
            <div id="step4" class="step">
                <h4 class="fw-semibold mb-4">4. Şəkil Yükləmə</h4>

                <?php if (!empty($images)): ?>
                    <div class="mb-3">
                        <label class="form-label d-block">Mövcud şəkillər</label>
                        <div class="row g-2" id="existingImages">
                            <?php foreach ($images as $index => $img): ?>
                                <div class="col-4 col-md-3 col-lg-2 position-relative" data-image="<?= $img ?>">
                                    <img src="/tema/<?= $img ?>" class="img-fluid rounded shadow-sm" style="height: 100px; object-fit: cover;">

                                    <!-- Sol üst köşeye silme butonu -->
                                    <button type="button"
                                        class="btn position-absolute top-0 start-0 p-0 rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 22px; height: 22px; font-size: 16px; color: black; background-color: white; border: none; line-height: 1;"
                                        onclick="removeExistingImage(this, '<?= $img ?>')">
                                        &times;
                                    </button>


                                </div>


                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Silinen resimler için hidden input -->
                <div id="removedImagesInputs"></div>

                <div class="mb-3">
                    <label for="images" class="form-label">Yeni şəkilləri əlavə edin (opsiyonel)</label>
                    <input class="form-control" type="file" id="images" name="images[]" accept="image/*" multiple>
                    <small class="text-muted">Yalnız şəkil faylları. Maksimum 20 şəkil əlavə edə bilərsiniz.</small>
                </div>

                <div id="preview" class="row g-2 mb-4"></div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep(3)">
                        <i class="bi bi-chevron-left me-1"></i> Əvvəlki
                    </button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        Yenilə <i class="bi bi-check-circle ms-1"></i>
                    </button>
                </div>
            </div>


        </form>
    </div>
</div>

<script>
    let map;
    let marker;
    document.addEventListener("DOMContentLoaded", function() {
        const lat = <?= $ad['latitude'] ?> || 40.4093;
        const lng = <?= $ad['longitude'] ?> || 49.8671;

        map = L.map('map').setView([lat, lng], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        marker = L.marker([lat, lng]).addTo(map);

        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            marker.setLatLng([lat, lng]);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    });

    document.getElementById("images").addEventListener("change", function() {
        const preview = document.getElementById("preview");
        preview.innerHTML = "";

        const files = this.files;
        if (files.length > 20) {
            alert("Maksimum 20 şəkil yükləyə bilərsiniz!");
            this.value = "";
            return;
        }

        Array.from(files).forEach(file => {
            if (!file.type.startsWith("image/")) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement("div");
                col.className = "col-4 col-md-3 col-lg-2";

                const img = document.createElement("img");
                img.src = e.target.result;
                img.className = "img-fluid rounded shadow-sm mb-2";
                img.style.height = "100px";
                img.style.objectFit = "cover";

                col.appendChild(img);
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });

    function goToStep(stepNumber) {
        const steps = document.querySelectorAll('.step');
        steps.forEach(step => step.classList.remove('active'));
        document.querySelector('#step' + stepNumber).classList.add('active');

        if (stepNumber === 3 && typeof map !== 'undefined') {
            setTimeout(() => {
                map.invalidateSize();
            }, 200);
        }
    }

    function removeExistingImage(button, imgPath) {
        const container = button.closest('[data-image]');
        container.remove(); // Görseli DOM'dan kaldır

        // Silinmiş görselleri gizli input olarak form içine ekle
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'removed_images[]';
        input.value = imgPath;
        document.getElementById('removedImagesInputs').appendChild(input);
    }
</script>

<style>
    .step {
        display: none;
    }

    .step.active {
        display: block;
    }

    .btn-close-white {
        filter: invert(1);
        /* Çarpı beyaz gözüksün */
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        width: 1.25rem;
        height: 1.25rem;
    }
</style>