<?php
session_start();
session_destroy(); // Tüm oturum verilerini siler
header("Location: /admin/login.php"); // Kullanıcıyı login sayfasına yönlendir
exit; // Kodun devam etmemesi için güvenli çıkış
?>
