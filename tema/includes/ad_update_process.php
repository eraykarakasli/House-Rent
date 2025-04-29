<?php
session_start();
include __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $ad_id = (int) ($_POST['id'] ?? 0);

    if (!$user_id || !$ad_id) {
        header("Location: /login.php");
        exit;
    }

    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE id = ? AND user_id = ?");
    $stmt->execute([$ad_id, $user_id]);
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ad) {
        header("Location: /pages/profile/profileads.php?edit=notfound");
        exit;
    }

    // Verileri al
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? '';
    $area = (int) ($_POST['area'] ?? 0);
    $land_area = isset($_POST['land_area']) ? (int) $_POST['land_area'] : null;
    $certificate = isset($_POST['certificate']) ? (int) $_POST['certificate'] : 0;
    $mortgage = isset($_POST['mortgage']) ? (int) $_POST['mortgage'] : 0;
    $renovated = isset($_POST['renovated']) ? (int) $_POST['renovated'] : 0;
    $floor = $_POST['floor'] ?? '';
    $room_count = (int) ($_POST['room_count'] ?? 0);
    $price = (int) ($_POST['price'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';
    $features = isset($_POST['features']) ? json_encode($_POST['features'], JSON_UNESCAPED_UNICODE) : json_encode([], JSON_UNESCAPED_UNICODE);

    // Mevcut görseller
    $image_paths = json_decode($ad['images'], true) ?? [];

    // ⛔ Silinmesi istenen görseller
    $removed_images = $_POST['removed_images'] ?? [];

    if (!empty($removed_images)) {
        foreach ($removed_images as $removed) {
            // Dosyayı gerçekten sil
            $filepath = __DIR__ . '/../' . $removed;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        }

        // image_paths dizisinden çıkar
        $image_paths = array_values(array_filter($image_paths, function ($img) use ($removed_images) {
            return !in_array($img, $removed_images);
        }));
    }

    // 📷 Yeni yüklenen görselleri işle
    $upload_dir = __DIR__ . '/../assets/uploads/ads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
            $filename = 'ad_' . $user_id . '_' . time() . '_' . $key . '.' . $ext;
            $target_path = $upload_dir . $filename;
            if (move_uploaded_file($tmp_name, $target_path)) {
                $image_paths[] = 'assets/uploads/ads/' . $filename;
            }
        }
    }

    // Veritabanını güncelle
    $stmt = $baglanti->prepare("UPDATE ads SET title=?, category=?, area=?, land_area=?, certificate=?, mortgage=?, renovated=?, floor=?, room_count=?, price=?, description=?, address=?, latitude=?, longitude=?, features=?, images=? WHERE id=? AND user_id=?");
    $stmt->execute([
        $title, $category, $area, $land_area, $certificate, $mortgage, $renovated,
        $floor, $room_count, $price, $description, $address, $latitude, $longitude,
        $features, json_encode($image_paths, JSON_UNESCAPED_UNICODE), $ad_id, $user_id
    ]);

    header("Location: /pages/profile/profileads.php?edit=success");
    exit;
} else {
    header("Location: /");
    exit;
}
