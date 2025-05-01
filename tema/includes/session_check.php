<?php
// Oturum başlamadıysa başlat
if (session_status() === PHP_SESSION_NONE) {
    session_name('user_session');
    session_start();
}

include_once __DIR__ . '/config.php';

// forceLogout fonksiyonu tekrar tanımlanmasın diye koruma
if (!function_exists('forceLogout')) {
    function forceLogout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        setcookie('user_id', '', time() - 3600, '/');
        setcookie('user_name', '', time() - 3600, '/');
        header("Location: /pages/auth/login.php");
        exit;
    }
}

// Kullanıcı oturumda değilse login sayfasına yönlendir
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: /pages/auth/login.php");
    exit;
}

// Cookie varsa ve session yoksa session'a yaz
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['user_name'] = $_COOKIE['user_name'];
}

// Ban kontrolü
$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    $stmt = $baglanti->prepare("SELECT is_banned FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['is_banned']) {
        forceLogout();
    }
}
