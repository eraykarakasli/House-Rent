<div class="col-md-8 col-lg-9">
    <!-- Başlıq -->
    <div class="row shadow-sm border rounded-4 p-4 mb-4">
        <h4 class="fw-semibold mb-0">İdarəçi ilə Əlaqə</h4>
    </div>

    <!-- Bildirişlər -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success rounded-4">
            Mesajınız uğurla göndərildi!
        </div>
    <?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-danger rounded-4">
            Zəhmət olmasa bütün sahələri doldurun!
        </div>
    <?php endif; ?>

    <!-- Mesaj Göndərmə Formu -->
    <div class="row shadow-sm border rounded-4 p-4">
        <form method="post" action="../../tema/profile/content/send_message.php" class="w-100">
            <div class="mb-3">
                <label for="subject" class="form-label">Mövzu</label>
                <input type="text" class="form-control rounded-pill" id="subject" name="subject" placeholder="Mövzunu daxil edin" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Mesajınız</label>
                <textarea class="form-control rounded-4" id="message" name="message" rows="6" placeholder="Mesajınızı buraya yazın..." required></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #00a6c1;">
                    <i class="bi bi-send me-2"></i> Göndər
                </button>
            </div>
        </form>
    </div>
</div>
