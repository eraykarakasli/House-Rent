<div class="col-md-8 col-lg-9">
            <!-- Sağ Panel: Profilim -->
            <div class="row shadow-sm border rounded-4 p-4 ">
                <h4 class="fw-semibold ">Profilim</h4>
            </div>

            <div class="row g-4 mt-2 shadow-sm border rounded-4 p-4">
                <!-- Profil Resmi Alanı -->
                <div class="col-md-5 ">
                    <div class="bg-light rounded-4 d-flex flex-column justify-content-center align-items-center py-5" style="height: 100%;">
                        <i class="bi bi-person-circle" style="font-size: 4rem; color: #c0c0c0;"></i>
                        <small class="text-muted mt-3">Profil şəkli yüklə</small>
                        <label class="btn btn-light text-primary mt-2 px-4 py-2 rounded-pill" style="background-color: #eafaff; cursor: pointer;">
                            Şəkil seç
                            <input type="file" hidden>
                        </label>
                    </div>
                </div>

                <!-- Profil Bilgi Alanı -->
                <div class="col-md-7">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Ad</label>
                            <input type="text" class="form-control rounded-pill" placeholder="Ad" value="">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefon nömrəsi</label>
                            <input type="tel" class="form-control rounded-pill" placeholder="Telefon nömrəsini əlavə et">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">E-poçt ünvanı</label>
                            <input type="email" class="form-control rounded-pill" placeholder="E-poçt ünvanı" value="">
                        </div>

                        <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #00a6c1;">
                            Yadda saxla
                        </button>
                    </form>
                </div>
            </div>
        </div>