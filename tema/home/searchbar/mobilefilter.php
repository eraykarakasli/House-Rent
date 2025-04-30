<style>
    body.modal-open {
        overflow-x: hidden;
    }

    @media (max-width: 991.98px) {
        #filterModal .modal-dialog {
            margin: 0;
            width: 100%;
            max-width: 100%;
        }

        #filterModal .modal-content {
            background-color: #06264e;
            color: #ffffff;
            border-radius: 0;
            min-height: 100vh;
            overflow-x: hidden;
            padding: 0;
        }

        #filterModal input.form-control,
        #filterModal select.form-select,
        #filterModal button.btn {
            font-size: 18px;
        }
    }

    @media (min-width: 992px) {
        #filterModal .modal-dialog {
            margin: 2rem auto;
            width: 100%;
            max-width: 700px;
        }

        #filterModal .modal-content {
            background-color: #06264e;
            color: #ffffff;
            border-radius: 1rem;
            padding: 2rem;
            overflow-x: hidden;
            min-height: auto;
        }

        #filterModal .modal-body {
            padding: 1rem 0 0 0;
        }

        #filterModal input.form-control,
        #filterModal select.form-select,
        #filterModal button.btn {
            font-size: 0.95rem;
        }
    }

    #locationInput::placeholder {
        color: #ffffff;
        opacity: 1;
    }

    .filter-reset-link {
        color: #ccc;
        font-size: 14px;
        text-decoration: underline;
        position: absolute;
        right: 2rem;
        bottom: 2rem;
    }

    .filter-reset-link:hover {
        color: #fff;
        text-decoration: underline;
    }
</style>

<!-- Filtr Modalı -->
<!-- Filtr Modalı -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-white" id="filterModalLabel">Gayrimenkul Filtrləmə</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Bağla"></button>
            </div>
            <div class="modal-body px-3">
                <form method="GET" action="/pages/ads/ads.php" class="d-flex flex-column justify-content-between h-100 position-relative">

                    <div class="w-100">
                        <!-- Konum -->
                        <div class="d-flex align-items-center gap-2 mb-4 text-white">
                            <i class="bi bi-geo-alt fs-4"></i>
                            <input type="text" name="search" class="form-control form-control-lg bg-secondary text-white border-0 rounded w-100" placeholder="Şəhər, ünvan..." value="<?= $_GET['search'] ?? '' ?>">
                        </div>

                        <div class="row g-4">
                            <!-- Kategori -->
                            <div class="col-6">
                                <select class="form-select form-select-lg bg-secondary text-white border-0 rounded w-100" name="category">
                                    <option value="" disabled <?= empty($_GET['category']) ? 'selected' : '' ?>>Kateqoriya</option>
                                    <?php
                                    $cats = ["obyekt", "ofis", "qaraj", "torpaq", "menzil", "heyet_bagi"];
                                    foreach ($cats as $cat):
                                    ?>
                                        <option value="<?= $cat ?>" <?= ($_GET['category'] ?? '') === $cat ? 'selected' : '' ?>>
                                            <?= ucfirst($cat) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Əməliyyat -->
                            <div class="col-6">
                                <select class="form-select form-select-lg bg-secondary text-white border-0 rounded w-100" name="operation">
                                    <option value="" disabled <?= empty($_GET['operation']) ? 'selected' : '' ?>>Əməliyyat növü</option>
                                    <option value="satiliq" <?= ($_GET['operation'] ?? '') === 'satiliq' ? 'selected' : '' ?>>Satılıq</option>
                                    <option value="kiraye" <?= ($_GET['operation'] ?? '') === 'kiraye' ? 'selected' : '' ?>>Kirayə</option>
                                </select>
                            </div>

                            <!-- Bina Tipi -->
                            <div class="col-12 d-flex gap-3 flex-wrap">
                                <?php
                                $building = $_GET['building_type'] ?? 'her_sey';
                                $types = ['her_sey' => 'Her şey', 'ikincil' => 'İkincil', 'yeni' => 'Yeni bina'];
                                foreach ($types as $val => $label):
                                ?>
                                    <input type="radio" class="btn-check" name="building_type" id="<?= $val ?>" value="<?= $val ?>" <?= $building === $val ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-light btn-lg flex-fill" for="<?= $val ?>"><?= $label ?></label>
                                <?php endforeach; ?>
                            </div>

                            <!-- Otaq ve Qiymət -->
                            <div class="col-12 d-flex gap-3">
                                <div class="w-50">
                                    <select class="form-select form-select-lg bg-secondary text-white border-0 rounded w-100" name="room_count">
                                        <option value="" <?= empty($_GET['room_count']) ? 'selected' : '' ?>>Otaq sayı</option>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($_GET['room_count'] ?? '') == $i ? 'selected' : '' ?>>
                                                <?= $i ?> otaq
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="w-50 d-flex gap-2">
                                    <input type="number"
                                        name="min_price"
                                        class="form-control form-control-lg bg-secondary text-white border-0 rounded"
                                        placeholder="Min AZN"
                                        min="0"
                                        value="<?= $_GET['min_price'] ?? '' ?>">

                                    <input type="number"
                                        name="max_price"
                                        class="form-control form-control-lg bg-secondary text-white border-0 rounded"
                                        placeholder="Max AZN"
                                        min="0"
                                        value="<?= $_GET['max_price'] ?? '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-lg btn-light w-100 rounded-pill fw-semibold">Elanı göstər</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- Lokasyon Seçimi Modalı (isteğe bağlı, çalışmıyor gibi görünüyor) -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="locationModalLabel">Konum seç</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Bağla"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control form-control-lg mb-3" placeholder="Şəhər, bölgə və ya ünvan axtar...">
            </div>
        </div>
    </div>
</div>