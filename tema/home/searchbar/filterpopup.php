<!-- Modal -->
<div class="modal fade " id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 shadow border-0 ">
            <div class="modal-header border-bottom mx-4 ">
                <h4 class="modal-title fw-bold text-center w-100" id="filterModalLabel">Ətraflı axtarış</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body mx-5" style="max-height: 70vh; overflow-y: auto;">
                <!-- Elan növü -->
                <p class="fw-bold">Elan növü</p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <input type="checkbox" class="btn-check" id="alqisatqi" autocomplete="off" name="elanNovu[]" value="Alqı-satqı">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="alqisatqi">Alqı-satqı</label>

                    <input type="checkbox" class="btn-check" id="kiraye" autocomplete="off" name="elanNovu[]" value="Kirayə">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="kiraye">Kirayə</label>

                    <input type="checkbox" class="btn-check" id="gunluk" autocomplete="off" name="elanNovu[]" value="Günlük">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="gunluk">Günlük</label>

                    <input type="checkbox" class="btn-check" id="otaq" autocomplete="off" name="elanNovu[]" value="Otaq yoldaşı">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="otaq">Otaq yoldaşı</label>

                    <input type="checkbox" class="btn-check" id="kompleks" autocomplete="off" name="elanNovu[]" value="Komplekslər">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="kompleks">Komplekslər</label>
                </div>
                <!-- Əmlak növləri -->
                <p class="fw-bold">Əmlak növləri</p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <input type="checkbox" class="btn-check" id="emlak_menzil" autocomplete="off" name="emlakNovu[]" value="Mənzil">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="emlak_menzil">
                        <i class="bi bi-building"></i> Mənzil
                    </label>

                    <input type="checkbox" class="btn-check" id="emlak_bagevi" autocomplete="off" name="emlakNovu[]" value="Bağ evi">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="emlak_bagevi">
                        <i class="bi bi-tree"></i> Bağ evi
                    </label>

                    <input type="checkbox" class="btn-check" id="emlak_qaraj" autocomplete="off" name="emlakNovu[]" value="Qaraj">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="emlak_qaraj">
                        <i class="bi bi-house-door"></i> Qaraj
                    </label>

                    <input type="checkbox" class="btn-check" id="emlak_ofis" autocomplete="off" name="emlakNovu[]" value="Ofis">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="emlak_ofis">
                        <i class="bi bi-buildings"></i> Ofis
                    </label>

                    <input type="checkbox" class="btn-check" id="emlak_torpaq" autocomplete="off" name="emlakNovu[]" value="Torpaq">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="emlak_torpaq">
                        <i class="bi bi-flower3"></i> Torpaq
                    </label>

                    <input type="checkbox" class="btn-check" id="emlak_obyekt" autocomplete="off" name="emlakNovu[]" value="Obyekt">
                    <label class="btn btn-outline-secondary rounded-4 px-4 d-flex align-items-center gap-2" for="emlak_obyekt">
                        <i class="bi bi-box"></i> Obyekt
                    </label>
                </div>
                <!-- Qiymet -->
                <p class="fw-bold">Qiymet</p>
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <input type="text" class="form-control w-auto" placeholder="Min">
                    <span>-</span>
                    <input type="text" class="form-control w-auto" placeholder="Max">
                </div>
                <!-- Otaq -->
                <p class="fw-bold">Otaq</p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <input type="checkbox" class="btn-check" id="otaq1" autocomplete="off" name="otaq[]" value="1">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="otaq1">1</label>

                    <input type="checkbox" class="btn-check" id="otaq2" autocomplete="off" name="otaq[]" value="2">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="otaq2">2</label>

                    <input type="checkbox" class="btn-check" id="otaq3" autocomplete="off" name="otaq[]" value="3">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="otaq3">3</label>

                    <input type="checkbox" class="btn-check" id="otaq4" autocomplete="off" name="otaq[]" value="4">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="otaq4">4</label>

                    <input type="checkbox" class="btn-check" id="otaq5plus" autocomplete="off" name="otaq[]" value="5+">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="otaq5plus">5+</label>
                </div>
                <!-- Təmir növü -->
                <p class="fw-bold">Təmir növü</p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <input type="checkbox" class="btn-check" id="temir_ferqi" autocomplete="off" name="temir[]" value="Fərqi yoxdur">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="temir_ferqi">Fərqi yoxdur</label>

                    <input type="checkbox" class="btn-check" id="temirli" autocomplete="off" name="temir[]" value="Təmirli">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="temirli">Təmirli</label>

                    <input type="checkbox" class="btn-check" id="temirsiz" autocomplete="off" name="temir[]" value="Təmirisiz">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="temirsiz">Təmirisiz</label>
                </div>
                <!-- Mərtəbə -->
                <p class="fw-bold">Mərtəbə</p>
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <input type="text" class="form-control w-auto" placeholder="Min">
                    <span>-</span>
                    <input type="text" class="form-control w-auto" placeholder="Max">
                    <input type="checkbox" class="btn-check" id="mertebe_birinci" autocomplete="off" name="mertebeIstisna[]" value="Birinci mərtəbə olmasın">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="mertebe_birinci">
                        Birinci mərtəbə olmasın
                    </label>

                    <input type="checkbox" class="btn-check" id="mertebe_yuxari" autocomplete="off" name="mertebeIstisna[]" value="Ən yuxarı mərtəbə olmasın">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="mertebe_yuxari">
                        Ən yuxarı mərtəbə olmasın
                    </label>
                </div>
                <!-- Xüsusiyyətlər -->
                <p class="fw-bold">Xüsusiyyətlər</p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <input type="checkbox" class="btn-check" id="x_lift" autocomplete="off" name="xususiyyetler[]" value="Lift">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_lift">Lift</label>

                    <input type="checkbox" class="btn-check" id="x_parkinq" autocomplete="off" name="xususiyyetler[]" value="Parkinq">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_parkinq">Parkinq</label>

                    <input type="checkbox" class="btn-check" id="x_tehlukesizlik" autocomplete="off" name="xususiyyetler[]" value="Təhlükəsizlik">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_tehlukesizlik">Təhlükəsizlik</label>

                    <input type="checkbox" class="btn-check" id="x_mebel" autocomplete="off" name="xususiyyetler[]" value="Mebel">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_mebel">Mebel</label>

                    <input type="checkbox" class="btn-check" id="x_istilik" autocomplete="off" name="xususiyyetler[]" value="İstilik sistemi">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_istilik">İstilik sistemi</label>

                    <input type="checkbox" class="btn-check" id="x_soyutma" autocomplete="off" name="xususiyyetler[]" value="Soyutma sistemi">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_soyutma">Soyutma sistemi</label>

                    <input type="checkbox" class="btn-check" id="x_qabyuyan" autocomplete="off" name="xususiyyetler[]" value="Qabyuyan maşın">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_qabyuyan">Qabyuyan maşın</label>

                    <input type="checkbox" class="btn-check" id="x_paltaryuyan" autocomplete="off" name="xususiyyetler[]" value="Paltaryuyan maşın">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_paltaryuyan">Paltaryuyan maşın</label>

                    <input type="checkbox" class="btn-check" id="x_quruducu" autocomplete="off" name="xususiyyetler[]" value="Quruducu maşın">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="x_quruducu">Quruducu maşın</label>
                </div>
                <!-- Sırala -->
                <p class="fw-bold">Sırala</p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <input type="radio" class="btn-check" id="sirala_kohne" name="sirala" autocomplete="off" value="Yenidən köhnəyə">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="sirala_kohne">Yenidən köhnəyə</label>

                    <input type="radio" class="btn-check" id="sirala_ucuz" name="sirala" autocomplete="off" value="Ucuzdan bahaya">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="sirala_ucuz">Ucuzdan bahaya</label>

                    <input type="radio" class="btn-check" id="sirala_baha" name="sirala" autocomplete="off" value="Bahadan ucuza">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="sirala_baha">Bahadan ucuza</label>
                </div>
                <!-- Elanı yerləşdirən -->
                <p class="fw-bold">Elanı yerləşdirən</p>
                <div class="d-flex flex-wrap gap-3 mb-4">

                    <input type="checkbox" class="btn-check" id="yer_ferqi" autocomplete="off" name="yerlesdiren[]" value="Fərqi yoxdur">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="yer_ferqi">Fərqi yoxdur</label>

                    <input type="checkbox" class="btn-check" id="yer_mulkiyyetci" autocomplete="off" name="yerlesdiren[]" value="Mülkiyyətçi">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="yer_mulkiyyetci">Mülkiyyətçi</label>

                    <input type="checkbox" class="btn-check" id="yer_vasiteci" autocomplete="off" name="yerlesdiren[]" value="Vasitəçi">
                    <label class="btn btn-outline-secondary rounded-5 px-4 d-flex align-items-center gap-2" for="yer_vasiteci">Vasitəçi</label>
                </div>
            </div>

            <div class="modal-footer justify-content-between border-top">
                <a href="#" class="text-muted small" onclick="resetFilters()">
                    <i class="bi bi-arrow-clockwise"></i> Filtirləri sıfırla
                </a>
                <button class="btn btn-info text-white px-4">Axtar</button>
            </div>
        </div>
    </div>
</div>

<script>
   // Filtre sıfırlama 
    function resetFilters() {
        document.querySelectorAll('#filterModal input[type=checkbox]').forEach(el => el.checked = false);
        document.querySelectorAll('#filterModal input[type=radio]').forEach(el => el.checked = false);
        document.querySelectorAll('#filterModal input[type=text]').forEach(el => el.value = '');
    }
</script>