<?php
ob_start();
session_name('user_session');
session_start();
include '../../tema/includes/config.php';
function isUserBanned($id, $db)
{
  $stmt = $db->prepare("SELECT is_banned FROM users WHERE id = ?");
  $stmt->execute([$id]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return isset($result['is_banned']) && $result['is_banned'] == 1;
}

if (
  (isset($_SESSION['user_id']) && isUserBanned($_SESSION['user_id'], $baglanti)) ||
  (isset($_COOKIE['user_id']) && isUserBanned($_COOKIE['user_id'], $baglanti))
) {
  // Banlıysa çerezleri temizle ve oturumu bitir
  setcookie('user_id', '', time() - 3600, "/");
  setcookie('user_name', '', time() - 3600, "/");
  session_unset();
  session_destroy();

  header("Location: login.php?banned=1");
  exit;
}



// site_settings tablosundan ayarları çek
$settingStmt = $baglanti->query("SELECT * FROM site_settings LIMIT 1");
$settings = $settingStmt->fetch(PDO::FETCH_ASSOC);

$message = '';
if (isset($_GET['banned']) && $_GET['banned'] == 1) {
  $message = '<div class="alert alert-danger">Bu hesab bloklanmışdır. Administratorla əlaqə saxlayın.</div>';
}

// Cookie ile login kontrolü
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
  $_SESSION['user_id'] = $_COOKIE['user_id'];
  $_SESSION['user_name'] = $_COOKIE['user_name'];
  header("Location: index.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $remember = isset($_POST['remember']);

  if ($email && $password) {
    $stmt = $baglanti->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['is_banned']) {
      $message = '<div class="alert alert-danger">Bu hesab bloklanmışdır. Administratorla əlaqə saxlayın.</div>';
    } elseif ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['first_name'];

      if ($remember) {
        setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
        setcookie('user_name', $user['first_name'], time() + (86400 * 30), "/");
      }

      header("Location: /index.php");
      exit;
    } else {
      $message = '<div class="alert alert-danger">E-poçt və ya parol yalnışdır.</div>';
    }
  } else {
    $message = '<div class="alert alert-warning">Zəhmət olmasa bütün sahələri doldurun.</div>';
  }
}
?>

<!DOCTYPE html>
<html lang="az">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="description" content="<?= htmlspecialchars($settings['sayt_haqqinda']) ?>">
  <meta name="keywords" content="ev10, emlak, satlıq, kiraye, bina, <?= htmlspecialchars($settings['sayt_basliq']) ?>">
  <meta name="author" content="<?= htmlspecialchars($settings['sayt_basliq']) ?>">

  <title><?= htmlspecialchars($settings['sayt_basliq']) ?></title>

  <link rel="icon" href="/<?= htmlspecialchars($settings['favicon']) ?>" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="container p-2" style="min-height: 100vh;">
  <nav class="navbar-expand-lg mt-4" style="min-height: 100px;">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/index.php">
      <img src="/<?= htmlspecialchars($settings['logo']) ?>" alt="Logo" width="32">
      <span class="fw-bold text-primary"><?= htmlspecialchars($settings['sayt_basliq']) ?></span>
    </a>
  </nav>

  <div class="d-flex align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 col-xl-5">
          <div class="card shadow border-0 rounded-4 p-4">
            <div class="card-body">
              <h2 class="text-center fw-bold mb-4">Daxil Ol</h2>

              <?= $message ?>

              <form method="POST" novalidate>
                <div class="mb-3">
                  <input type="email" class="form-control" name="email" placeholder="E-poçt ünvanı" required>
                </div>

                <div class="mb-3 input-group">
                  <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Parol" required>
                  <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                  </span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">Məni xatırla</label>
                  </div>
                  <a href="#" class="small text-decoration-none text-primary">Parolunuzu unutmusunuz?</a>
                </div>

                <div class="d-grid mb-3">
                  <button type="submit" class="btn btn-primary">Daxil ol</button>
                </div>

                <div class="text-center small">
                  Hələ hesabınız yoxdur? <a href="register.php" class="text-decoration-none text-primary fw-semibold">Qeydiyyatdan keçin</a>
                </div>
              </form>
            </div>
          </div>

          <p class="text-center mt-4 small text-muted">
            Bu sayt reCAPTCHA ilə qorunur. <a href="#" class="text-decoration-none">Məxfilik Siyasəti</a> və <a href="#" class="text-decoration-none">İstifadə Şərtləri</a> keçərlidir.
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("passwordInput");
    const toggleIcon = document.getElementById("toggleIcon");

    togglePassword.addEventListener("click", function() {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
      toggleIcon.classList.toggle("bi-eye");
      toggleIcon.classList.toggle("bi-eye-slash");
    });
  </script>
</body>

</html>