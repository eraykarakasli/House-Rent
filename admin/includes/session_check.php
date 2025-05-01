<?php
// Admin oturumunu kullanıcı oturumlarından ayırmak için özel bir isim belirliyoruz
session_name('admin_session');
session_start();

// Giriş yapılmamışsa admin login sayfasına yönlendir
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
