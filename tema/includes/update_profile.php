<?php
include 'session_check.php'; 
include 'config.php'; 

$user_id = $_SESSION['user_id'];

// Formdan gelen veriler
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);

// Boş alan kontrolü
if (empty($first_name) || empty($last_name) || empty($phone) || empty($email)) {
    header("Location: /pages/profile/profile.php?error=empty");
    exit;
}

// Mevcut profil fotoğrafını veritabanından al
$stmt = $baglanti->prepare("SELECT profile_photo FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$old_photo = $stmt->fetchColumn();

// Profil şəkli yükleme kontrolü
$profile_photo_path = $old_photo; // varsayılan olarak eskisini koru
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/profiles/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
    $filename = 'profile_' . $user_id . '_' . time() . '.' . $ext;
    $target_path = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_path)) {
        // Eski fotoğraf varsa ve dosya mevcutsa sil
        if (!empty($old_photo)) {
            $old_path = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($old_photo, '/');
            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }

        // Yeni fotoğrafın göreli yolunu kaydet
        $profile_photo_path = '/assets/uploads/profiles/' . $filename;
    }
}

try {
    if ($profile_photo_path !== $old_photo) {
        $stmt = $baglanti->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, email = ?, profile_photo = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $phone, $email, $profile_photo_path, $user_id]);
    } else {
        $stmt = $baglanti->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, email = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $phone, $email, $user_id]);
    }

    header("Location: /pages/profile/profile.php?status=updated");
    exit;
} catch (PDOException $e) {
    echo "Xəta baş verdi: " . $e->getMessage();
}
