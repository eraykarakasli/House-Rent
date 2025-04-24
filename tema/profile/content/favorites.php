<div class="col-md-8 col-lg-9">
    <!-- Başlık -->
    <div class="row shadow-sm border rounded-4 p-4 mb-4">
        <h4 class="fw-semibold mb-0">Seçilmişlər</h4>
    </div>

    <!-- Seçilmiş İlan Kartları -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="col">
                <a href="../../pages/adsdetail/adsdetail.php" class="text-decoration-none text-dark">
                    <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden w-100">

                        <!-- Görseller (carousel) -->
                        <div class="position-relative">
                            <div id="carouselFav<?= $i ?>" class="carousel slide" data-bs-ride="false">
                                <div class="carousel-inner rounded" style="height: 200px;">
                                    <div class="carousel-item active">
                                        <img src="../../assets/evresim.webp" class="d-block w-100" style="height: 200px; object-fit: cover;" alt="ev">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../../assets/evresim2.webp" class="d-block w-100" style="height: 200px; object-fit: cover;" alt="ev">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../../assets/evresim3.webp" class="d-block w-100" style="height: 200px; object-fit: cover;" alt="ev">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselFav<?= $i ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" style="filter: invert(1);"></span>
                                    <span class="visually-hidden">Önceki</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselFav<?= $i ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" style="filter: invert(1);"></span>
                                    <span class="visually-hidden">Sonraki</span>
                                </button>
                            </div>

                            <!-- Favori kaldır -->
                            <button class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2" title="Seçilmişdən çıxart">
                                <i class="bi bi-heart-fill text-danger"></i>
                            </button>

                            <!-- Etiketler -->
                            <div class="position-absolute top-0 start-0 m-2 d-flex gap-1">
                                <span class="btn btn-success btn-sm rounded-circle"><i class="bi bi-clipboard-check-fill"></i></span>
                                <span class="btn btn-warning btn-sm rounded-circle"><i class="bi bi-percent"></i></span>
                                <span class="btn btn-danger btn-sm rounded-circle"><i class="bi bi-hammer"></i></span>
                            </div>
                        </div>

                        <!-- İlan Bilgisi -->
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong class="fs-6">105,000 AZN</strong>
                                <small class="text-muted" style="font-size: 12px;">41 dəq əvvəl</small>
                            </div>
                            <div class="mb-2 text-secondary d-flex align-items-center">
                                <i class="bi bi-geo-alt me-1"></i>
                                <span>Yeni Günəşli</span>
                            </div>
                            <div class="d-flex justify-content-between text-secondary">
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-building me-1"></i>
                                    <span>5/9</span>
                                </div>
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-door-open me-1"></i>
                                    <span>2 otaq</span>
                                </div>
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="bi bi-aspect-ratio me-1"></i>
                                    <span>60m²</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
        <?php endfor; ?>
    </div>
</div>
