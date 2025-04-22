<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$message = '';
if (isset($_POST['update'])) {
    $username = $_SESSION['admin_username'];
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // Yeni şifreler uyuşmuyor mu?
    if ($new !== $confirm) {
        $message = "<div class='alert alert-warning'>Yeni şifrələr uyğun gəlmir.</div>";
    } else {
        // Mevcut kullanıcıyı veritabanından çek
        $stmt = $baglanti->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($old, $user['password'])) {
            $newHashed = password_hash($new, PASSWORD_DEFAULT);
            $update = $baglanti->prepare("UPDATE admin_users SET password = ? WHERE username = ?");
            $update->execute([$newHashed, $username]);
            $message = "<div class='alert alert-success'>✅ Şifrə uğurla yeniləndi.</div>";
        } else {
            $message = "<div class='alert alert-danger'>❌ Köhnə şifrə yalnışdır.</div>";
        }
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow border-0">
            <div class="card-body p-4 text-center">
                <!-- Profil İkonu -->
                <div class="mb-3">
                    <i class="bi bi-person-circle" style="font-size: 4rem; color: #0d6efd;"></i>
                </div>

                <h4 class="card-title mb-3"><i class="bi bi-shield-lock"></i> Şifrəni Dəyiş</h4>

                <?php if (!empty($message)) echo $message; ?>

                <form method="post" class="text-start">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Köhnə Şifrə</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Köhnə şifrəni daxil et" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Yeni Şifrə</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Yeni şifrəni daxil et" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Yeni Şifrə (Təkrar)</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Yeni şifrəni təkrar daxil et" required>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-check-circle me-1"></i> Şifrəni Yenilə
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>
