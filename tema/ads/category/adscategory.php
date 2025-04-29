<div class="d-flex justify-content-end align-items-center gap-2 mt-4">
  <!-- Sağ kısım: sıralama ve xəritə -->
  <div class="d-flex align-items-center gap-2">
    <!-- Sıralama Dropdown -->
    <div class="dropdown">
  <button class="btn btn-outline-secondary rounded-4 px-4 py-2 dropdown-toggle" type="button" id="siralaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-filter"></i> Sırala
  </button>
  <ul class="dropdown-menu shadow-sm rounded-4" aria-labelledby="siralaDropdown">
    <li><a class="dropdown-item" href="#" onclick="setSort('ucuzdan-bahaya')">Ucuzdan bahaya</a></li>
    <li><a class="dropdown-item" href="#" onclick="setSort('bahadan-ucuza')">Bahadan ucuza</a></li>
  </ul>
</div>

    <!-- Xəritə buton + toggle -->
    <div class="d-flex align-items-center gap-2 border rounded-4 px-3 py-2">
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

  function setSort(sortValue) {
    const params = new URLSearchParams(window.location.search);
    params.set('sort', sortValue); // sort parametresini ayarla
    window.location.search = params.toString(); // tüm parametreleri koruyarak URL'yi güncelle
  }
</script>