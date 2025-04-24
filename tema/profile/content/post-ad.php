<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="col-md-8 col-lg-9">
    <div class="d-flex justify-content-between align-items-center shadow-sm border rounded-4 p-4 mb-4 flex-wrap gap-3">
        <h4 class="fw-semibold mb-0">Elan Yarat</h4>
    </div>
    <div class="step-wrapper shadow-sm border rounded-4 p-4">

        <!-- Step 1: Əlsas Məlumatlar -->
        <div id="step1" class="step active">
            <h4 class="fw-semibold mb-4">1. Əlsas Məlumatlar</h4>
            <form id="adFormStep1">
                <div class="mb-3">
                    <label class="form-label">Başlıq</label>
                    <input type="text" class="form-control rounded-3" name="title" placeholder="Məsələn: 3 otaqlı təmirli mənzil" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kateqoriya</label>
                    <select class="form-select rounded-3" name="category" required>
                        <option value="">Seçin...</option>
                        <option value="ev">Ev</option>
                        <option value="torpaq">Torpaq</option>
                        <option value="ofis">Ofis</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sahə (m²)</label>
                    <input type="number" class="form-control rounded-3" name="area" placeholder="Məsələn: 80" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Torpağın sahəsi (m²)</label>
                    <input type="number" class="form-control rounded-3" name="land_area" placeholder="Ələvə edin (isteəyə bağlı)">
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Çıxarış</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificate" id="certYes" value="var" required>
                        <label class="form-check-label" for="certYes">Var</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificate" id="certNo" value="yox" required>
                        <label class="form-check-label" for="certNo">Yox</label>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="goToStep(2)">
                        Növbəti <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 2: Əlmak Məlumatları -->
        <div id="step2" class="step">
            <h4 class="fw-semibold mb-4">2. Əlmak Məlumatları</h4>
            <form id="adFormStep2">
                <div class="mb-3">
                    <label class="form-label">Mərtəbə</label>
                    <input type="text" class="form-control rounded-3" name="floor" placeholder="Məsələn: 3/9" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Otaq sayı</label>
                    <select class="form-select rounded-3" name="room_count" required>
                        <option value="">Seçin...</option>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> otaq</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Qiymət (AZN)</label>
                    <input type="number" class="form-control rounded-3" name="price" placeholder="Məsələn: 85000" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Elan haqqında məlumat</label>
                    <textarea class="form-control rounded-3" name="description" rows="4" placeholder="Əlmak haqqında ətraflı məlumat daxil edin..." required></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep(1)">
                        <i class="bi bi-chevron-left me-1"></i> Əlvəlki
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="goToStep(3)">
                        Növbəti <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 3: Xüsusiyyətlər, Konum, Adres -->
        <div id="step3" class="step">
            <h4 class="fw-semibold mb-4">3. Xüsusiyyətlər, Konum, Adres</h4>
            <form id="adFormStep3">
                <div class="mb-4">
                    <label class="form-label">Xüsusiyyətlər</label>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2">
                        <?php
                        $features = ['Lift', 'Parking', 'Kombi', 'İsti döşəmə', 'Balkon', 'Mətbəx mebeli', 'Su çəni', 'Kamera sistemi'];
                        foreach ($features as $index => $feature): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="features[]" id="feature<?= $index ?>" value="<?= $feature ?>">
                            <label class="form-check-label" for="feature<?= $index ?>"><?= $feature ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ünvanı xəritədə tap (küçə, bina, rayon)</label>
                    <input type="text" class="form-control" name="address" placeholder="Ünvan daxil edin..." required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Xəritədən konum seçin</label>
                    <div id="map" style="height: 300px; border-radius: 10px;"></div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep(2)">
                        <i class="bi bi-chevron-left me-1"></i> Əlvəlki
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="goToStep(4)">
                        Növbəti <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 4: Şəkil Yükləmə -->
        <div id="step4" class="step">
            <h4 class="fw-semibold mb-4">4. Şəkil Yükləmə</h4>

            <form id="adFormStep4" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="images" class="form-label">Şəkil seçin</label>
                    <input class="form-control" type="file" id="images" name="images[]" accept="image/*" multiple required>
                    <small class="text-muted">Yalnız şəkillər. Maksimum 20 şəkil yükləyə bilərsiniz.</small>
                </div>

                <!-- Önizleme Alanı -->
                <div id="preview" class="row g-2 mb-4"></div>

                <!-- Navigasiya -->
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep(3)">
                        <i class="bi bi-chevron-left me-1"></i> Əvvəlki
                    </button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        Elanı Yarat <i class="bi bi-check-circle ms-1"></i>
                    </button>
                </div>
            </form>
        </div>



    </div>
</div>
<script>
    let map; // Global olarak tanımla
    let marker; // Marker'ı da dışarı çıkar

    document.addEventListener("DOMContentLoaded", function() {
        map = L.map('map').setView([40.4093, 49.8671], 11); // Bakı merkez
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;

            // Marker yoksa oluştur, varsa güncelle
            if (!marker) {
                marker = L.marker([lat, lng]).addTo(map);
            } else {
                marker.setLatLng([lat, lng]);
            }

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    });

    // reism yükleme kontrolü
    document.getElementById("images").addEventListener("change", function() {
        const preview = document.getElementById("preview");
        preview.innerHTML = "";

        const files = this.files;

        if (files.length > 20) {
            alert("Maksimum 20 şəkil yükləyə bilərsiniz!");
            this.value = ""; // temizle
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
        const currentStep = document.querySelector('#step' + stepNumber);
        currentStep.classList.add('active');

        // Eğer Step 3'e geçiliyorsa, harita boyutunu yenile
        if (stepNumber === 3 && typeof map !== 'undefined') {
            setTimeout(() => {
                map.invalidateSize();
            }, 200); // 200ms bekletmek görünürlükte sorun çıkmasını engeller
        }
    }
</script>


<style>
    .step {
        display: none;
    }

    .step.active {
        display: block;
    }
</style>