<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content bg-black border-0 d-flex align-items-center justify-content-center">
      <div class="modal-body p-0">
        <div id="modalCarousel" class="carousel slide w-100" data-bs-ride="false">
          <div class="carousel-inner">
            <?php foreach ($images as $index => $img): ?>
              <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="../../tema/<?= htmlspecialchars($img) ?>" class="modal-carousel-img" alt="...">
              </div>
            <?php endforeach; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

<style>
 .modal-carousel-img {
    max-height: 90vh;
    max-width: 100%;
    object-fit: contain;
    display: block;
    margin-left: auto;
    margin-right: auto;
    background-color: #000;
}

</style>