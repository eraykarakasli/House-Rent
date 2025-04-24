<?php
session_start();

// Oturum varsa veya çerezle otomatik giriş yapılmışsa → anasayfaya yönlendir
if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
    header("Location: /index.php");
    exit;
}
include '../../tema/includes/config.php';

$message = '';
$firstName = '';
$lastName = '';
$email = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $termsAccepted = isset($_POST['terms']) ? 1 : 0;

    if ($firstName && $lastName && $email && $phone && $password && $termsAccepted) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = '<div class="alert alert-warning">Düzgün e-poçt ünvanı daxil edin.</div>';
        } elseif (!preg_match('/^05\d{9}$/', $phone)) {
            $message = '<div class="alert alert-warning">Telefon nömrəsi düzgün formatda deyil (05xx xxx xx xx).</div>';
        } elseif (strlen($password) < 6) {
            $message = '<div class="alert alert-warning">Parol ən az 6 simvol olmalıdır.</div>';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password, terms_accepted) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword, $termsAccepted]);
                $message = '<div class="alert alert-success">Qeydiyyat uğurla tamamlandı!</div>';
                // Temizle
                $firstName = $lastName = $email = $phone = '';
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $message = '<div class="alert alert-danger">Bu e-poçt ünvanı ilə artıq qeydiyyat var.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Xəta baş verdi: ' . $e->getMessage() . '</div>';
                }
            }
        }
    } else {
        $message = '<div class="alert alert-warning">Zəhmət olmasa bütün sahələri doldurun və şərtləri qəbul edin.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../assets/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Ev10 - Qeydiyyat</title>
</head>

<body class="container p-2" style="min-height: 100vh;">
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
                            <h2 class="text-center fw-bold mb-4">Qeydiyyat</h2>

                            <?= $message ?>

                            <form method="POST" novalidate id="registerForm">
                                <div class="row g-2 mb-3">
                                    <div class="col">
                                        <input type="text" class="form-control" name="first_name" placeholder="Ad" value="<?= htmlspecialchars($firstName) ?>" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="last_name" placeholder="Soyad" value="<?= htmlspecialchars($lastName) ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="E-poçt ünvanı" value="<?= htmlspecialchars($email) ?>" required>
                                </div>
                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" name="phone" id="phoneInput" placeholder="05xx xxx xx xx" maxlength="13" value="<?= htmlspecialchars($phone) ?>" required>
                                </div>
                                <div class="mb-3 input-group">
                                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Parol" required>
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </span>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" value="1" required>
                                    <label class="form-check-label small" for="terms">
                                        <a href="#" class="text-decoration-none text-primary">İstifadə şərtləri</a> ilə razıyam.
                                    </label>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">Hesab yarat</button>
                                </div>

                                <div class="text-center small">
                                    Artıq hesabınız var? <a href="login.php" class="text-decoration-none text-primary fw-semibold">Daxil olun</a>
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

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            toggleIcon.classList.toggle("bi-eye");
            toggleIcon.classList.toggle("bi-eye-slash");
        });

        document.getElementById("phoneInput").addEventListener("input", function () {
            this.value = this.value.replace(/[^\d]/g, '');
        });

        document.getElementById("registerForm").addEventListener("submit", function (e) {
            const email = document.querySelector('input[name="email"]').value.trim();
            const phone = document.querySelector('input[name="phone"]').value.trim();

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^05\d{9}$/;

            let errors = [];

            if (!emailRegex.test(email)) {
                errors.push("Zəhmət olmasa düzgün e-poçt ünvanı daxil edin.");
            }

            if (!phoneRegex.test(phone)) {
                errors.push("Telefon nömrəsi düzgün formatda deyil (05xx xxx xx xx).");
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join("\n"));
            }
        });
    </script>
</body>
</html>
