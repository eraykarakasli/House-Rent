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

    if ($new !== $confirm) {
        $message = "<div class='alert alert-warning'>Yeni şifrələr uyğun gəlmir.</div>";
    } else {
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

<!-- Main Content -->
<div class="flex-grow-1 position-relative" id="main-content">
  <div class="container px-3 px-md-4 my-4">

    <!-- Menü Butonu + Başlık -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
      <div class="d-flex align-items-center">
        <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-0"><i class="bi bi-shield-lock me-2"></i> Şifrəni Dəyiş</h4>
      </div>
    </div>

    <!-- Şifre Değiştir Formu -->
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-person-circle" style="font-size: 3rem; color: #0d6efd;"></i>
            </div>

            <?php if (!empty($message)) echo $message; ?>

            <form method="post" class="row g-3">
              <div class="col-12">
                <label for="old_password" class="form-label">Köhnə Şifrə</label>
                <input type="password" name="old_password" id="old_password" class="form-control" required>
              </div>

              <div class="col-12">
                <label for="new_password" class="form-label">Yeni Şifrə</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
              </div>

              <div class="col-12">
                <label for="confirm_password" class="form-label">Yeni Şifrə (Təkrar)</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
              </div>

              <div class="col-12 mt-3">
                <button type="submit" name="update" class="btn btn-primary w-100">
                  <i class="bi bi-check-circle me-1"></i> Şifrəni Yenilə
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include './includes/footer.php'; ?>
