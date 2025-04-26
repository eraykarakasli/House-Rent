<style>
    body.modal-open {
        overflow-x: hidden;
    }

    /* Küçük ekranlar (mobil) için */
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

    /* Büyük ekranlar (desktop) için */
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

        /* Büyük ekranda da input ve select yazılarını biraz küçültelim */
        #filterModal input.form-control,
        #filterModal select.form-select,
        #filterModal button.btn {
            font-size: 0.95rem;
        }
    }
</style>



<!-- Filtr Modalı -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-white" id="filterModalLabel">Gayrimenkul Filtrləmə</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Bağla"></button>
            </div>
            <div class="modal-body px-3">
                <form method="post" action="" enctype="multipart/form-data" class="d-flex flex-column justify-content-between h-100">
                    <div class="w-100">
                        <!-- Konum Seçimi Satırı -->
                        <div class="d-flex align-items-center gap-2 mb-4 text-white">
                            <i class="bi bi-geo-alt fs-4"></i>
                            <input type="text" class="form-control form-control-lg bg-secondary text-white border-0 rounded w-100" placeholder="Yer seçin">
                        </div>

                        <div class="row g-4">
                            <div class="col-6">
                                <select class="form-select form-select-lg bg-secondary text-white border-0 rounded w-100" name="category">
                                    <option selected disabled>Kateqoriya</option>
                                    <option value="ev">Daire</option>
                                    <option value="torpaq">Torpaq</option>
                                    <option value="ofis">Ofis</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-select form-select-lg bg-secondary text-white border-0 rounded w-100" name="operation">
                                    <option selected disabled>Əməliyyat növü</option>
                                    <option value="almaq">Satın almaq</option>
                                    <option value="kiraye">Kirayə</option>
                                </select>
                            </div>

                            <div class="col-12 d-flex gap-3 flex-wrap">
                                <input type="radio" class="btn-check" name="building_type" id="all" value="her_sey" checked>
                                <label class="btn btn-outline-light btn-lg flex-fill" for="all">Her şey</label>

                                <input type="radio" class="btn-check" name="building_type" id="second" value="ikincil">
                                <label class="btn btn-outline-light btn-lg flex-fill" for="second">İkincil</label>

                                <input type="radio" class="btn-check" name="building_type" id="new" value="yeni">
                                <label class="btn btn-outline-light btn-lg flex-fill" for="new">Yeni bina</label>
                            </div>

                            <!-- Otaq sayı ve Qiymət yan yana tek satırda -->
                            <div class="col-12 d-flex gap-3">
                                <div class="w-50">
                                    <select class="form-select form-select-lg bg-secondary text-white border-0 rounded w-100" name="room_count">
                                        <option selected disabled>Otaq sayı</option>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?> otaq</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="w-50">
                                    <select class="form-select form-select-lg bg-secondary text-white border-0 rounded w-100" name="price_range">
                                        <option selected disabled>Qiymət</option>
                                        <option value="0-100000">0 - 100000 AZN</option>
                                        <option value="100000-200000">100000 - 200000 AZN</option>
                                        <option value="200000+">200000+ AZN</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-lg btn-light w-100 rounded-pill fw-semibold">290 Elanı göstər</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Lokasyon Seçimi Modalı -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="locationModalLabel">Konum seç</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Bağla"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control form-control-lg mb-3" placeholder="Şəhər, bölgə və ya ünvan axtar...">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dark text-white">📍 Bakı</li>
                    <li class="list-group-item bg-dark text-white">📍 Gəncə</li>
                    <li class="list-group-item bg-dark text-white">📍 Sumqayıt</li>
                </ul>
            </div>
        </div>
    </div>
</div>