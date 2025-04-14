<div class="container mt-2 ">
  <div class="bg-white shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-3">
    <!-- Arama Kutusu -->
    <input type="text" class="form-control border-0 flex-grow-1" placeholder="Şəhər, Metro, Kompleks, Ünvan ..." />

    <!-- Qiymət Dropdown -->
    <div class="dropdown position-relative">
      <button class="btn btn-white fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Qiymət
      </button>

      <!-- Qiymet input -->
      <div class="collapse position-absolute z-5 form-control dropdown-menu" style="min-width: 250px;">
        <div class="d-flex gap-2 p-2 align-items-center">
          <span class="d-flex gap-2 align-items-center fw-bold text-secondary border rounded px-2 py-1" style="font-size: 12px;">
            <input type="text"
              inputmode="numeric"
              pattern="[0-9]*"
              class="form-control border-0 shadow-none p-0"
              placeholder="Min"
              oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            AZN
          </span>-
          <span class="d-flex gap-2 align-items-center fw-bold text-secondary border rounded px-2 py-1" style="font-size: 12px;">
            <input type="text"
              inputmode="numeric"
              pattern="[0-9]*"
              class="form-control border-0 shadow-none p-0"
              placeholder="Max"
              oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            AZN
          </span>
        </div>
      </div>
    </div>
    <!-- Otaq Dropdown -->
    <div class="dropdown">
      <button class="btn btn-white fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Otaq
      </button>
      <div class="dropdown-menu">
        <div class="d-flex align-items-center">
          <span><a class="dropdown-item rounded-3" href="#">1</a></span>|
          <span><a class="dropdown-item rounded-3" href="#">2</a></span>|
          <span><a class="dropdown-item rounded-3" href="#">3</a></span>|
          <span><a class="dropdown-item rounded-3" href="#">4</a></span>|
          <span><a class="dropdown-item rounded-3" href="#">5+</a></span>
        </div>
      </div>

    </div>


    <!-- Filter Link -->
    <a href="#" data-bs-toggle="modal" data-bs-target="#filterModal" class="btn fw-bold text-dark">
      Filterlər
    </a>



    <?php include "filterpopup.php"; ?>

    <!-- Arama Butonu -->
    <button class="btn btn-info text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
      <i class="bi bi-search"></i>
    </button>
  </div>
</div>