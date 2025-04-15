<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4">
  <!-- Sol kısım: kategori ve filtreler -->
  <div class="d-flex flex-wrap align-items-center gap-2">
    <!-- Filtrə ikonu -->
    <button class="btn btn-dark d-flex align-items-center gap-2 rounded-4 px-3 py-2">
      <i class="bi bi-sliders"></i>
    </button>

    <!-- Aktiv Kategori (örnek: Gündəlik) -->
    <button class="btn btn-dark rounded-4 fw-semibold px-4 py-2">
      Gündəlik
    </button>

    <!-- Diğer Kategoriler -->
    <button class="btn btn-outline-secondary rounded-4 fw-semibold px-4 py-2">
      Əmlak Növü
    </button>

    <button class="btn btn-outline-secondary rounded-4 fw-semibold px-4 py-2">
      Qiymət
    </button>

    <button class="btn btn-outline-secondary rounded-4 fw-semibold px-4 py-2">
      Otaq
    </button>

    <button class="btn btn-outline-secondary rounded-4 fw-semibold px-4 py-2">
      Bütün filterlər
    </button>
  </div>

  <!-- Sağ kısım: sıralama ve xəritə -->
  <div class="d-flex align-items-center gap-2">
    <!-- Sıralama -->
    <button class="btn btn-outline-secondary rounded-4 px-4 py-2">
      <i class="bi bi-filter"></i> Sırala
    </button>

    <!-- Xəritə buton + toggle -->
    <<div class="d-flex align-items-center gap-2 border rounded-4 px-3 py-2">
      <i class="bi bi-map"></i> Xəritə
      <div class="form-check form-switch m-0">
        <input class="form-check-input" type="checkbox" id="mapToggle" <?= isset($_GET['map']) && $_GET['map'] === 'on' ? 'checked' : '' ?>>
      </div>
  </div>

</div>
</div>
<script>
  document.getElementById('mapToggle').addEventListener('change', function() {
    const params = new URLSearchParams(window.location.search);
    if (this.checked) {
      params.set('map', 'on');
    } else {
      params.delete('map');
    }
    window.location.search = params.toString();
  });
</script>