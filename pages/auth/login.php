<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../../assets/icon.png" type="image/x-icon">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Ev10 - Giriş</title>
</head>

<body class="container p-2" style="min-height: 100vh;">
  <!-- Header -->
  <nav class="navbar-expand-lg mt-4" style="min-height: 100px;">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/index.php">
      <img src="../../../assets/icon.png" alt="Logo" width="32">
      <span class="fw-bold text-primary">ev10</span>
    </a>
  </nav>
  <!-- Form alanı -->
  <div class="d-flex align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 col-xl-5">
          <div class="card shadow border-0 rounded-4 p-4">
            <div class="card-body">

              <!-- Başlık -->
              <h2 class="text-center fw-bold mb-4">Giriş Yap</h2>

              <!-- Form -->
              <form>
                <!-- E-posta -->
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="E-posta adresi">
                </div>

                <!-- Şifre -->
                <div class="mb-3 input-group">
                  <input type="password" class="form-control" placeholder="Şifre">
                  <span class="input-group-text"><i class="bi bi-eye-slash"></i></span>
                </div>

                <!-- Beni hatırla ve şifre unut -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label small" for="remember">Beni hatırla</label>
                  </div>
                  <a href="#" class="small text-decoration-none text-primary">Şifremi unuttum</a>
                </div>

                <!-- Giriş butonu -->
                <div class="d-grid mb-3">
                  <button class="btn btn-primary">Giriş Yap</button>
                </div>

                <!-- veya -->
                <div class="text-center mb-3 text-muted small">
                  veya
                </div>

                <!-- Sosyal ile giriş -->
                <div class="d-grid gap-2 mb-3">
                  <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-google"></i> Google ile giriş yap
                  </button>
                  <button type="button" class="btn btn-outline-dark d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-apple"></i> Apple ile giriş yap
                  </button>
                </div>

                <!-- Kayıt yönlendirmesi -->
                <div class="text-center small">
                  Henüz hesabınız yok mu? <a href="register.php" class="text-decoration-none text-primary fw-semibold">Kayıt ol</a>
                </div>
              </form>

            </div>
          </div>

          <!-- Alt bilgi -->
          <p class="text-center mt-4 small text-muted">
            Bu site reCAPTCHA ile korunmaktadır. <a href="#" class="text-decoration-none">Gizlilik Politikası</a> ve <a href="#" class="text-decoration-none">Kullanım Şartları</a> geçerlidir.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>