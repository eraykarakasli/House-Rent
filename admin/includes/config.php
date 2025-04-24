<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ev10";

try {
    $baglanti = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bağlantı xətası: " . $e->getMessage());
}
?>
