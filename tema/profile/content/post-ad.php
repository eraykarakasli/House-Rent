<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="col-md-8 col-lg-9">
    <div class="d-flex justify-content-between align-items-center shadow-sm border rounded-4 p-4 mb-4 flex-wrap gap-3">
        <h4 class="fw-semibold mb-0">Elan Yarat</h4>
    </div>

    <div class="step-wrapper shadow-sm border rounded-4 p-4">
        <form id="adFormStep4" method="post" action="/tema/includes/post_ad_process.php" enctype="multipart/form-data">
            <!-- Step 1: Əsas Məlumatlar -->
            <div id="step1" class="step active">
                <h4 class="fw-semibold mb-4">1. Əsas Məlumatlar</h4>

                <div class="mb-3">
                    <label class="form-label">Əmlak Başlığı</label>
                    <input type="text" class="form-control rounded-3" name="title" placeholder="Məsələn: 3 otaqlı təmirli mənzil" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kateqoriya</label>
                    <select class="form-select rounded-3" name="category" required>
                        <option value="">Seçin...</option>
                        <option value="obyekt">Obyekt</option>
                        <option value="ofis">Ofis</option>
                        <option value="qaraj">Qaraj</option>
                        <option value="torpaq">Torpaq</option>
                        <option value="menzil">Menzil</option>
                        <option value="heyet">Həyət evi / Bağ evi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Əməliyyat növü</label>
                    <select class="form-select rounded-3" name="operation_type" required>
                        <option value="">Seçin...</option>
                        <option value="satiliq">Satılıq</option>
                        <option value="kiraye">Kirayə</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bina vəziyyəti</label>
                    <select class="form-select rounded-3" name="building_condition" required>
                        <option value="">Seçin...</option>
                        <option value="yeni">Yeni</option>
                        <option value="ikincil">İkincil</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sahə (m²)</label>
                    <input type="number" class="form-control rounded-3" name="area" placeholder="Məsələn: 80" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Torpağın sahəsi (m²)</label>
                    <input type="number" class="form-control rounded-3" name="land_area" placeholder="Əlavə edin (istəyə bağlı)">
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Çıxarış</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificate" id="certYes" value="1" required>
                        <label class="form-check-label" for="certYes">Var</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificate" id="certNo" value="0" required>
                        <label class="form-check-label" for="certNo">Yox</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">İpoteka</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="mortgage" id="mortgageYes" value="1" required>
                        <label class="form-check-label" for="mortgageYes">Var</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="mortgage" id="mortgageNo" value="0" required>
                        <label class="form-check-label" for="mortgageNo">Yox</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Təmirli</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="renovated" id="renovatedYes" value="1" required>
                        <label class="form-check-label" for="renovatedYes">Bəli</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="renovated" id="renovatedNo" value="0" required>
                        <label class="form-check-label" for="renovatedNo">Xeyr</label>
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
                    <input type="text" class="form-control rounded-3" name="floor" placeholder="Məsələn: 3/9" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Otaq sayı</label>
                    <select class="form-select rounded-3" name="room_count" required>
                        <option value="">Seçin...</option>
                        <?php for ($i = 0; $i <= 10; $i++): ?>
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
                    <textarea class="form-control rounded-3" name="description" rows="4" placeholder="Əmlak haqqında ətraflı məlumat daxil edin..." required></textarea>
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
                    <label class="form-label">Şəhər</label>
                    <input type="text" class="form-control rounded-3" name="city" placeholder="Bakı" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rayon / İlçe</label>
                    <input type="text" class="form-control rounded-3" name="district" placeholder="Yasamal" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Məhəllə</label>
                    <input type="text" class="form-control rounded-3" name="neighborhood" placeholder="Elmlər Akademiyası" required>
                </div>

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
                    <label class="form-label">Ünvan</label>
                    <input type="text" class="form-control rounded-3" name="address" placeholder="Ünvanı daxil edin..." required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Xəritədən konum seçin</label>
                    <div id="map" style="height: 300px; border-radius: 10px;"></div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
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

                <div class="mb-3">
                    <label for="images" class="form-label">Şəkilləri seçin</label>
                    <input class="form-control" type="file" id="images" name="images[]" accept="image/*" multiple required>
                    <small class="text-muted">Yalnız şəkil faylları. Maksimum 20 şəkil.</small>
                </div>

                <div id="preview" class="row g-2 mb-4"></div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep(3)">
                        <i class="bi bi-chevron-left me-1"></i> Əvvəlki
                    </button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        Elanı Yarat <i class="bi bi-check-circle ms-1"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Step kontrol ve Leaflet harita scriptleri -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    let map;
    let marker;

    // Harita başlat
    map = L.map('map').setView([40.4093, 49.8671], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        if (!marker) {
            marker = L.marker([lat, lng]).addTo(map);
        } else {
            marker.setLatLng([lat, lng]);
        }
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

    // Step geçiş fonksiyonu
    window.goToStep = function (stepNumber) {
        const currentStep = document.querySelector(".step.active");
        const inputs = currentStep.querySelectorAll("input, select, textarea");
        let valid = true;

        inputs.forEach(input => {
            if (input.type === "radio") {
                const name = input.name;
                const checked = currentStep.querySelectorAll(`input[name="${name}"]:checked`).length;
                if (checked === 0) valid = false;
            } else if (input.type !== "file") {
                if (!input.value || input.value.trim() === "") valid = false;
            }
        });

        if (!valid) {
            alert("Zəhmət olmasa bu addımdakı bütün tələb olunan sahələri doldurun.");
            return;
        }

        const steps = document.querySelectorAll('.step');
        steps.forEach(step => step.classList.remove('active'));
        document.querySelector('#step' + stepNumber).classList.add('active');

        if (stepNumber === 3 && typeof map !== 'undefined') {
            setTimeout(() => {
                map.invalidateSize();
            }, 200);
        }
    };

    // Görsel önizleme ve limit kontrolü
    document.getElementById("images").addEventListener("change", function () {
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
            reader.onload = function (e) {
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

    // ✅ Form gönderim kontrolü
    const form = document.getElementById("adFormStep4");
    form.addEventListener("submit", function (e) {
        let valid = true;
        let message = "";

        const requiredFields = [
            "title", "category", "operation_type", "building_condition",
            "area", "floor", "room_count", "price", "description",
            "city", "district", "neighborhood", "address"
        ];

        requiredFields.forEach(name => {
            const input = form.querySelector(`[name="${name}"]`);
            if (!input || input.value.trim() === "") valid = false;
        });

        const radios = ["certificate", "mortgage", "renovated"];
        radios.forEach(name => {
            if (form.querySelectorAll(`input[name="${name}"]:checked`).length === 0) {
                valid = false;
            }
        });

        const lat = document.getElementById("latitude").value;
        const lng = document.getElementById("longitude").value;
        if (!lat || !lng) {
            valid = false;
            message = "Zəhmət olmasa xəritədən konum seçin.";
        }

        const imageInput = document.getElementById("images");
        if (imageInput.files.length < 5) {
            valid = false;
            message = "Zəhmət olmasa ən azı 5 şəkil seçin.";
        }

        if (!valid) {
            alert(message || "Zəhmət olmasa bütün tələb olunan sahələri doldurun.");
            e.preventDefault();
        }
    });
});
</script>



<style>
    .step {
        display: none;
    }

    .step.active {
        display: block;
    }

    @media (max-width: 575.98px) {
        .form-check {
            font-size: 14px;
        }
    }

    .is-invalid {
        border: 1px solid red;
    }
</style>