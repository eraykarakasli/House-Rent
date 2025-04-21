<?php
include "../../tema/includes/header/header.php";
?>
<div class="container">
    <div class="row gap-5 pb-5">
        <!-- Başlık + Galeri -->
        <div class="col-12">
            <h4 class="fw-bold mb-4">Satılır, obyekt 160m², 8 Noyabr m.</h4>

            <!-- Galeri -->
            <div class="d-flex gap-2 mb-4" style="height: 400px;">
                <div class="w-50">
                    <img src="../../assets/evresim6.webp" class="cursor-pointer img-fluid rounded w-100 h-100 object-fit-cover gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="0" alt="Ana Görsel" style="cursor: pointer;">
                </div>
                <div class="w-50 d-flex flex-wrap gap-2">
                    <div class="position-relative" style="width: calc(50% - 4px); height: 49%;">
                        <img src="../../assets/evresim7.webp" class="img-fluid rounded w-100 h-100 object-fit-cover gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="1" alt="Görsel 2" style="cursor: pointer;">
                    </div>
                    <div class="position-relative" style="width: calc(50% - 4px); height: 49%;">
                        <img src="../../assets/evresim8.webp" class="img-fluid rounded w-100 h-100 object-fit-cover gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="2" alt="Görsel 3" style="cursor: pointer;">
                    </div>
                    <div class="position-relative" style="width: calc(50% - 4px); height: 49%;">
                        <img src="../../assets/evresim9.webp" class="img-fluid rounded w-100 h-100 object-fit-cover gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="3" alt="Görsel 4" style="cursor: pointer;">
                    </div>
                    <div class="position-relative" style="width: calc(50% - 4px); height: 49%;">
                        <img src="../../assets/evresim10.webp" class="img-fluid rounded w-100 h-100 object-fit-cover gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="4" alt="Görsel 5" style="cursor: pointer;">
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel Modal -->
        <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen m-0 w-100">
                <div class="modal-content bg-black border-0 w-100">
                    <div class="modal-header border-0 p-2">
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 text-center overflow-hidden">
                        <div id="modalCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                            <div class="carousel-inner w-100 h-100">
                                <div class="carousel-item active h-100">
                                    <img src="../../assets/evresim6.webp" class="img-fluid h-100 object-fit-contain mx-auto d-block" alt="...">
                                </div>
                                <div class="carousel-item h-100">
                                    <img src="../../assets/evresim7.webp" class="img-fluid h-100 object-fit-contain mx-auto d-block" alt="...">
                                </div>
                                <!-- Diğer görseller -->
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
            <!-- Sol Açıklama Alanı -->
            <div class="col-lg-8">
                <!-- Özellikler -->
                <div class="row text-center  py-3 mb-4">
                    <div class="col">
                        <div class="text-muted">Kateqoriya</div>
                        <strong><i class="bi bi-grid"></i> Obyekt</strong>
                    </div>
                    <div class="col">
                        <div class="text-muted">Sahə</div>
                        <strong><i class="bi bi-aspect-ratio"></i> 160m²</strong>
                    </div>
                    <div class="col">
                        <div class="text-muted">Çıxarış</div>
                        <strong><i class="bi bi-check2-circle"></i> Bəli</strong>
                    </div>
                    <div class="col">
                        <div class="text-muted">Təmirli</div>
                        <strong><i class="bi bi-tools"></i> Bəli</strong>
                    </div>
                </div>

                <!-- Elan haqqında -->
                <h5 class="fw-bold">Elan haqqında</h5>
                <p class="text-muted">8 noyabr metrosunun yaxinligi,H.Əliyev kuçəsinə 150metr məsafədə yeni tikili binanin altinda umumi sahəsi 160 kv.m olan işlək obyekt satilir.Obyektin Güclü işıqlanma sistemi, istilik sistemi kombidir,hər iki girişə 3 faza elektrik xətti çəkilib.Obyekt
                    2 otaq,mətbəx,sanuzel və böyük zaldan ibarətdir.
                    Obyekt qarşıdan 4 vitrin,həyətdən 3 vitrindir.Obyektin sənədləri qaydasindadir, (çixarişi ) var.
                    Hal hazirda obyekti uzun muddətli ayliq 3000azn icarəyə verilib. Real alicilara qiymətdə endirim...</p>

                <!-- Yaxınlıqdakılar -->
                <h5 class="fw-bold mt-4">Yaxınlıqdakılar</h5>
                <ul class="list-unstyled row row-cols-2 row-cols-md-3 g-2">
                    <li><i class="bi bi-geo"></i> 8 Noyabr</li>
                    <li><i class="bi bi-house"></i> Size Zero</li>
                    <li><i class="bi bi-mortarboard"></i> 153 Nə-li məktəb</li>
                    <li><i class="bi bi-tree"></i> Uşaq bağçası</li>
                    <li><i class="bi bi-bus-front"></i> 6, 13, 52, 83</li>
                </ul>

                <!-- Google Harita örneği (iframe) -->
                <div class="mt-4 rounded overflow-hidden">
                    <iframe src="https://maps.google.com/maps?q=40.3902,49.8522&z=15&output=embed" width="100%" height="300" frameborder="0" allowfullscreen=""></iframe>
                </div>

                <!-- Qiymət Tarixəsə -->
                <div class="mt-4 border-top pt-3">
                    <h6 class="fw-semibold">Qiymət tarixəsə</h6>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Mart 29, 2025</span>
                        <strong>550,000 AZN</strong>
                    </div>
                </div>
            </div>

            <!-- Sağ Alan -->
            <div class="col-lg-4">
                <!-- Qiymət Kartı -->
                <div class="bg-white border rounded-4 p-4 mb-4">
                    <h4 class="fw-bold">550,000 AZN</h4>
                    <p class="text-muted">3,400 AZN/m²</p>
                    <button class="btn btn-dark w-100">
                        <i class="bi bi-calculator"></i> İpoteka hesabla
                    </button>
                </div>

                <!-- Emlakçı Profili -->
                <div class="bg-white border rounded-4 p-4 mb-4 text-center">
                    <img src="../../assets/proifle.png" alt="Profil" class="rounded-circle mb-2" width="50">
                    <h6 class="fw-bold mb-1">Real Əlmak Tebriz</h6>
                    <p class="text-muted small mb-2">Rasul - 2 gün əvvəl</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary d-flex align-items-center gap-2 p-2"><i class="bi bi-telephone"></i> Zəng et</button>
                        <button class="btn btn-outline-primary d-flex align-items-center gap-2 p-2"><i class="bi bi-chat-dots"></i> Mesaj yaz</button>
                    </div>
                </div>

                <!-- Sayımlar -->
                <div class="bg-white border-bottom p-4 text-center">
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold">255</h6>
                            <div class="text-muted">Baxış sayı</div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold">39288</h6>
                            <div class="text-muted">Göstərilmə sayı</div>
                        </div>
                    </div>
                </div>
                <div class="fw-semibold d-flex justify-content-center mt-3 gap-2">
                    <i class="bi bi-flag"></i> Şikayət et
                </div>
            </div>
        </div>
    </div>

</div>
<!-- carousel -->
<script>
    const galleryImages = document.querySelectorAll('.gallery-img');
    const modalCarousel = document.querySelector('#modalCarousel');

    // Otomatik geçişi devre dışı bırak
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

</div>
<?php include "../../tema/ads/adsdetail/adsdetailmodal.php"; ?>
<?php include "../../tema/includes/footer/footer.php"; ?>