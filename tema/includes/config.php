<?php
$host = 'localhost';
$dbname = 'ev10'; // Veritabanı adını kendi sistemine göre güncelle
$username = 'root';
$password = ''; // XAMPP kullanıyorsan genelde boş olur

try {
    $baglanti = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}
?>
