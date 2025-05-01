<?php
session_name('user_session');  // Kullanıcı oturumunu yönetmek için özel session adı
session_name('user_session');
session_start();

// Sadece kullanıcı oturum verilerini sıfırla
session_unset();
session_destroy();

// Varsa kullanıcıya ait çerezleri de sil
setcookie('user_id', '', time() - 3600, "/");
setcookie('user_name', '', time() - 3600, "/");

// Kullanıcıyı giriş sayfasına yönlendir
header("Location: /index.php");
exit;
?>
