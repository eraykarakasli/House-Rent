<div class="col-md-8 col-lg-9">
    <!-- Sayfa Başlığı ve Buton -->
    <div class="d-flex justify-content-between align-items-center shadow-sm border rounded-4 p-4 mb-4 flex-wrap gap-3">
        <h4 class="fw-semibold mb-0">Elanlarım</h4>
        <a href="profileads.php?page=new" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-circle me-2"></i> Yeni Elan Yarat
        </a>
    </div>

    <!-- Elan Kartları -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="col">
                <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden">
                    <!-- Carousel -->
                    <div class="position-relative">
                        <div id="myAdCarousel<?= $i ?>" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner rounded" style="height: 200px;">
                                <div class="carousel-item active">
                                    <img src="../../assets/evresim.webp" class="d-block w-100" style="height: 200px; object-fit: cover;" alt="ev">
                                </div>
                                <div class="carousel-item">
                                    <img src="../../assets/evresim2.webp" class="d-block w-100" style="height: 200px; object-fit: cover;" alt="ev">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#myAdCarousel<?= $i ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" style="filter: invert(1);"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#myAdCarousel<?= $i ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" style="filter: invert(1);"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Kart İçeriği -->
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="fs-6">145,000 AZN</strong>
                            <span class="badge bg-success">Aktiv</span>
                        </div>
                        <div class="mb-2 text-secondary d-flex align-items-center">
                            <i class="bi bi-geo-alt me-1"></i> <span>Əhmədli, Bakı</span>
                        </div>
                        <div class="d-flex justify-content-between text-secondary mb-3">
                            <div class="d-flex align-items-center"><i class="bi bi-building me-1"></i> 6/9</div>
                            <div class="d-flex align-items-center"><i class="bi bi-door-open me-1"></i> 3 otaq</div>
                            <div class="d-flex align-items-center"><i class="bi bi-aspect-ratio me-1"></i> 80m²</div>
                        </div>

                        <!-- Yönetim Butonları -->
                        <div class="d-flex justify-content-between">
                            <a href="ilan-duzenle.php?id=<?= $i ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i> Düzəlt
                            </a>
                            <a href="ilan-sil.php?id=<?= $i ?>" onclick="return confirm('Elanı silmək istədiyinizə əminsiniz?')" class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-trash me-1"></i> Sil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>
