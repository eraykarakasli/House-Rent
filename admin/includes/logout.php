<?php
session_name('admin_session'); // Admin için özel session adı
session_start();

session_unset();   // admin_session içindeki tüm değişkenleri sil
session_destroy(); // admin_session'ı sonlandır

header("Location: /admin/login.php");
exit;
?>
