
<!-- Şikayet Modalı -->
<div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="complaintModalLabel">Şikayət et</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bağla"></button>
      </div>
      <form method="post" action="/tema/includes/complaint_process.php">
        <div class="modal-body">
          
          <input type="hidden" name="ad_id" value="<?= htmlspecialchars($ad['id']) ?>">

          <div class="mb-3">
            <label for="reason" class="form-label">Şikayətin səbəbi</label>
            <select class="form-select" id="reason" name="reason" required>
              <option value="">Seçin...</option>
              <option value="Artıq satılıb və ya icarəyə verilib.">Artıq satılıb və ya icarəyə verilib.</option>
              <option value="Başqa əmlaka aid şəkillərdən istifadə olunub.">Başqa əmlaka aid şəkillərdən istifadə olunub.</option>
              <option value="Əmlak baxış keçirilmədən beh istəyir.">Əmlak baxış keçirilmədən beh istəyir.</option>
              <option value="Əmlak haqqında məlumatlar düzgün qeyd olunmayıb.">Əmlak haqqında məlumatlar düzgün qeyd olunmayıb.</option>
              <option value="Qiymət düzgün göstərilməyib.">Qiymət düzgün göstərilməyib.</option>
              <option value="Digər">Digər</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Şikayət təsviri (opsiyonel)</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Mətn yaz..."></textarea>
          </div>

        </div>
        <div class="modal-footer border-0">
          <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Göndər</button>
        </div>
      </form>
    </div>
  </div>
</div>
