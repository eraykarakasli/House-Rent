<?php
// ✅ Oturum kontrolü ve veritabanı bağlantısı
session_start();
include __DIR__ . '/config.php';

// ✅ Form POST ile geldiyse işlem başlat
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        header("Location: /login.php");
        exit;
    }

    // ✅ Formdan gelen verileri güvenli bir şekilde al
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
    $features = isset($_POST['features']) ? json_encode($_POST['features'], JSON_UNESCAPED_UNICODE) : json_encode([], JSON_UNESCAPED_UNICODE);
    $city = $_POST['city'] ?? '';
    $district = $_POST['district'] ?? '';
    $neighborhood = $_POST['neighborhood'] ?? '';

    $status = 'pending';

    // ✅ Resim yükleme işlemi
    $image_paths = [];
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

    try {
        $stmt = $baglanti->prepare("INSERT INTO ads (user_id, title, category, operation_type, building_condition, area, land_area, certificate, mortgage, renovated, floor, room_count, price, description, city, district, neighborhood, address, latitude, longitude, features, images, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $user_id, $title, $category, $operation_type, $building_condition,
            $area, $land_area, $certificate, $mortgage, $renovated,
            $floor, $room_count, $price, $description,
            $city, $district, $neighborhood,
            $address, $latitude, $longitude,
            $features, json_encode($image_paths), $status
        ]);

        header("Location: /pages/profile/profileads.php?status=created");
        exit;
    } catch (PDOException $e) {
        echo "Xəta baş verdi: " . $e->getMessage();
    }
} else {
    header("Location: /");
    exit;
}
?>
