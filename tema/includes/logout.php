<?php
session_start();

// Oturumu sıfırla
session_unset();
session_destroy();

// Çerezleri sil
setcookie('user_id', '', time() - 3600, "/");
setcookie('user_name', '', time() - 3600, "/");

// Giriş sayfasına yönlendir
header("Location: /index.php");
exit;
