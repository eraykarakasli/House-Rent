<?php
// ✓ Oturum kontrolü ve veritabanı bağlantısı
session_name('user_session');
session_start();
include __DIR__ . '/config.php';

// ✓ Form POST ile geldiyse işlem başlat
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        header("Location: /login.php");
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo "Elan ID tapılmadı.";
        exit;
    }

    // ✓ Formdan gelen verileri al
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? '';
    $operation_type = $_POST['operation_type'] ?? '';
    $building_condition = $_POST['building_condition'] ?? '';
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
    $city = $_POST['city'] ?? '';
    $district = $_POST['district'] ?? '';
    $neighborhood = $_POST['neighborhood'] ?? '';
    $features = isset($_POST['features']) ? json_encode($_POST['features'], JSON_UNESCAPED_UNICODE) : json_encode([], JSON_UNESCAPED_UNICODE);

    $removed_images = $_POST['removed_images'] ?? [];
    $removed_images = is_array($removed_images) ? $removed_images : [];

    // ✓ Mevcut ilan verisini kontrol et
    $stmt = $baglanti->prepare("SELECT * FROM ads WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->execute([$id, $user_id]);
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ad) {
        echo "Elan tapılmadı ve ya silinib.";
        exit;
    }

    // ✓ Görsel yükleme
    $upload_dir = __DIR__ . '/../assets/uploads/ads/';
    $image_paths = json_decode($ad['images'], true) ?? [];

    // Eski resimlerden silinenleri kaldır
    $image_paths = array_filter($image_paths, fn($img) => !in_array($img, $removed_images));

    // Yeni resimleri ekle
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

    try {
        $stmt = $baglanti->prepare("UPDATE ads SET title = ?, category = ?, operation_type = ?, building_condition = ?, area = ?, land_area = ?, certificate = ?, mortgage = ?, renovated = ?, floor = ?, room_count = ?, price = ?, description = ?, city = ?, district = ?, neighborhood = ?, address = ?, latitude = ?, longitude = ?, features = ?, images = ?, status = 0 WHERE id = ? AND user_id = ?");

        $stmt->execute([
            $title, $category, $operation_type, $building_condition,
            $area, $land_area, $certificate, $mortgage, $renovated,
            $floor, $room_count, $price, $description,
            $city, $district, $neighborhood, $address,
            $latitude, $longitude, $features, json_encode(array_values($image_paths)),
            $id, $user_id
        ]);

        header("Location: /pages/profile/profileads.php?status=updated");
        exit;

    } catch (PDOException $e) {
        echo "Xəta baş verdi: " . $e->getMessage();
    }
} else {
    header("Location: /");
    exit;
}
?>
