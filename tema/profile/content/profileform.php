<?php
// Bu dosya profileform.php
include $_SERVER['DOCUMENT_ROOT'] . '/tema/includes/session_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/tema/includes/config.php';

$user_id = $_SESSION['user_id'];
$stmt = $baglanti->prepare("SELECT first_name, last_name, phone, email, profile_photo FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="col-md-8 col-lg-9">
    <!-- Sağ Panel: Profilim -->
    <div class="row shadow-sm border rounded-4 p-4">
        <h4 class="fw-semibold">Profilim</h4>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
        <div class="alert alert-success mt-3">Profil uğurla güncəlləndi.</div>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
        <div class="alert alert-danger mt-3">Zəhmət olmasa bütün sahələri doldurun.</div>
    <?php endif; ?>


    <div class="row g-4 mt-2 shadow-sm border rounded-4 p-4">
        <!-- Profil Resmi Alanı -->
        <div class="col-md-5">
            <div class="bg-light rounded-4 d-flex flex-column justify-content-center align-items-center py-5" style="height: 100%;">
                <?php if (!empty($user['profile_photo'])): ?>
                    <img id="profilePreview" src="<?= htmlspecialchars($user['profile_photo']) ?>" class="rounded-circle mb-3" width="100" height="100" alt="Profil">
                <?php else: ?>
                    <img id="profilePreview" src="../../assets/proifle.png" class="rounded-circle mb-3" width="100" height="100" alt="Profil">
                <?php endif; ?>
                <small class="text-muted">Profil şəkli yüklə</small>
                <label class="btn btn-light text-primary mt-2 px-4 py-2 rounded-pill" style="background-color: #eafaff; cursor: pointer;">
                    Şəkil seç
                    <input type="file" name="profile_photo" form="profileForm" id="profilePhotoInput" hidden>
                </label>
            </div>
        </div>

        <!-- Profil Bilgi Alanı -->
        <div class="col-md-7">
            <form method="post" action="/tema/includes/update_profile.php" enctype="multipart/form-data" id="profileForm">
                <div class="mb-3">
                    <label class="form-label">Ad</label>
                    <input type="text" class="form-control rounded-pill" name="first_name" placeholder="Ad" value="<?= htmlspecialchars($user['first_name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Soyad</label>
                    <input type="text" class="form-control rounded-pill" name="last_name" placeholder="Soyad" value="<?= htmlspecialchars($user['last_name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefon nömrəsi</label>
                    <input type="tel" class="form-control rounded-pill" name="phone" placeholder="Telefon nömrəsini əlavə et" value="<?= htmlspecialchars($user['phone']) ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label">E-poçt ünvanı</label>
                    <input type="email" class="form-control rounded-pill" name="email" placeholder="E-poçt ünvanı" value="<?= htmlspecialchars($user['email']) ?>">
                </div>

                <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #00a6c1;">
                    Yadda saxla
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById("profilePhotoInput").addEventListener("change", function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("profilePreview").src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>