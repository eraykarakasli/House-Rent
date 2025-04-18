<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../assets/icon.png" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ev10 - Qeydiyyat</title>
</head>

<body class="container p-2" style="min-height: 100vh;">
    <!-- Header -->
    <nav class="navbar-expand-lg mt-4" style="min-height: 100px;">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/index.php">
            <img src="../../../assets/icon.png" alt="Logo" width="32">
            <span class="fw-bold text-primary">ev10</span>
        </a>
    </nav>

    <div class="d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6 col-xl-5">
                    <div class="card shadow border-0 rounded-4 p-4">
                        <div class="card-body">

                            <!-- Başlıq -->
                            <h2 class="text-center fw-bold mb-4">Qeydiyyat</h2>

                            <!-- Form -->
                            <form>
                                <!-- Ad Soyad -->
                                <div class="row g-2 mb-3">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Ad">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Soyad">
                                    </div>
                                </div>
                                <!-- E-poçt -->
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="E-poçt ünvanı">
                                </div>
                                <!-- Telefon nömrəsi -->
                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" placeholder="05xx xxx xx xx" maxlength="13">
                                </div>
                                <!-- Parol -->
                                <div class="mb-3 input-group">
                                    <input type="password" class="form-control" id="passwordInput" placeholder="Parol">
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </span>
                                </div>

                                <!-- Şərtlər -->
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="terms">
                                    <label class="form-check-label small" for="terms">
                                        <a href="#" class="text-decoration-none text-primary">İstifadə şərtləri</a> ilə razıyam.
                                    </label>
                                </div>

                                <!-- Qeydiyyat düyməsi -->
                                <div class="d-grid mb-3">
                                    <button class="btn btn-primary">Hesab yarat</button>
                                </div>

                                <!-- Giriş -->
                                <div class="text-center small">
                                    Artıq hesabınız var? <a href="login.php" class="text-decoration-none text-primary fw-semibold">Daxil olun</a>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- Alt məlumat -->
                    <p class="text-center mt-4 small text-muted">
                        Bu sayt reCAPTCHA ilə qorunur. <a href="#" class="text-decoration-none">Məxfilik Siyasəti</a> və <a href="#" class="text-decoration-none">İstifadə Şərtləri</a> keçərlidir.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("passwordInput");
        const toggleIcon = document.getElementById("toggleIcon");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);

            // İkonu dəyiş
            toggleIcon.classList.toggle("bi-eye");
            toggleIcon.classList.toggle("bi-eye-slash");
        });
    </script>
</body>

</html>
