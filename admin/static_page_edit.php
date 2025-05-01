<?php
// PHP işlemleri için çıktısız dosyaları önce include et
include './includes/session_check.php';
include './includes/config.php';

// ID kontrolü
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    echo "<div class='alert alert-danger m-4'>Yanlış səhifə ID-si.</div>";
    exit;
}

// Sayfayı veritabanından al
$stmt = $baglanti->prepare("SELECT * FROM static_pages WHERE id = ?");
$stmt->execute([$id]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
    echo "<div class='alert alert-warning m-4'>Səhifə tapılmadı.</div>";
    exit;
}

// Slug oluşturma fonksiyonu
function generateSlug($title, $baglanti, $excludeId = null)
{
    $turkce = ['ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'];
    $ingilizce = ['s','s','i','i','g','g','u','u','o','o','c','c'];
    $title = str_replace($turkce, $ingilizce, $title);
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
    $slug = trim($slug, '-');

    $baseSlug = $slug;
    $i = 1;
    while (true) {
        $query = "SELECT COUNT(*) FROM static_pages WHERE slug = ?";
        $params = [$slug];
        if ($excludeId) {
            $query .= " AND id != ?";
            $params[] = $excludeId;
        }
        $check = $baglanti->prepare($query);
        $check->execute($params);
        if ($check->fetchColumn() == 0) break;
        $slug = $baseSlug . '-' . $i;
        $i++;
    }

    return $slug;
}

// Form gönderildiyse güncelle
if (isset($_POST['update_page'])) {
    $title = trim($_POST['title']);
    $content = $_POST['content'];
    $slug = generateSlug($title, $baglanti, $id);

    $stmt = $baglanti->prepare("UPDATE static_pages SET title = ?, slug = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $slug, $content, $id]);

    header("Location: static_pages.php?status=updated");
    exit;
}

// HTML çıktısı bundan sonra başlasın
include './includes/header.php';
include './includes/sidebar.php';
?>

<!-- Main Content -->
<div class="flex-grow-1 position-relative" id="main-content">
  <div class="container-fluid px-4 my-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
  <div class="d-flex align-items-center">
    <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
      <i class="bi bi-list"></i>
    </button>
    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Statik Səhifəni Düzəlt</h4>
  </div>
</div>
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow-sm rounded-4 p-4 bg-white">
          <form method="post" class="row g-4">
            <div class="col-12">
              <label class="form-label">Səhifə Başlığı</label>
              <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($page['title']) ?>" required>
            </div>

            <div class="col-12">
              <label class="form-label">Səhifə Məzmunu</label>
              <textarea name="content" id="contentEditor" class="form-control" rows="8"><?= htmlspecialchars($page['content']) ?></textarea>
            </div>

            <div class="col-12 text-end">
              <button type="submit" name="update_page" class="btn btn-success">
                <i class="bi bi-check-circle me-1"></i> Yadda Saxla
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> <!-- /#main-content -->

<!-- Summernote -->
<script>
  $(document).ready(function () {
    $('#contentEditor').summernote({
      height: 300,
      placeholder: 'Səhifə məzmununu buraya daxil edin...'
    });
  });
</script>

<?php include './includes/footer.php'; ?>
