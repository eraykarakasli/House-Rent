<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Sayılar
$user_count = $baglanti->query("SELECT COUNT(*) FROM users")->fetchColumn();
$active_ads = $baglanti->query("SELECT COUNT(*) FROM ads WHERE status = 1")->fetchColumn();
$pending_ads = $baglanti->query("SELECT COUNT(*) FROM ads WHERE status = 0")->fetchColumn();
$blog_count = $baglanti->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
$complaint_count = $baglanti->query("SELECT COUNT(*) FROM complaints")->fetchColumn();
$message_count = $baglanti->query("SELECT COUNT(*) FROM messages")->fetchColumn();

$today_ads = $baglanti->query("SELECT COUNT(*) FROM ads WHERE DATE(created_at) = CURDATE()")->fetchColumn();
$top_ad_stmt = $baglanti->query("SELECT id, title, view_count FROM ads ORDER BY view_count DESC LIMIT 1");
$top_ad = $top_ad_stmt->fetch(PDO::FETCH_ASSOC);

$category_stmt = $baglanti->query("SELECT category, COUNT(*) as count FROM ads GROUP BY category");
$categories = [];
$counts = [];
while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[] = ucfirst($row['category']);
    $counts[] = $row['count'];
}
?>

<style>
    .scrollable-content {
        max-height: calc(100vh - 60px);
        overflow-y: auto;
        padding-right: 8px;
    }

    @media (max-width: 768px) {
        .scrollable-content {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
</style>

<div class="container-fluid my-4 px-4 scrollable-content">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <!-- Toggle Butonu -->
            <button class="btn btn-outline-dark d-lg-none me-3" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="mb-0"><i class="bi bi-bar-chart-line me-2"></i> Panel İstatistikləri</h4>
        </div>
    </div>


    <div class="row g-4 mb-4">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Ümumi Üzv Sayı</h6>
                <h3 class="text-primary fw-bold"><?= $user_count ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Yayındakı Elanlar</h6>
                <h3 class="text-success fw-bold"><?= $active_ads ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Təsdiq Gözləyir</h6>
                <h3 class="text-warning fw-bold"><?= $pending_ads ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Blog Sayısı</h6>
                <h3 class="text-dark fw-bold"><?= $blog_count ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Bugünkü Elanlar</h6>
                <h3 class="text-secondary fw-bold"><?= $today_ads ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Ən çox baxılan elan</h6>
                <a class="text-info fw-bold small d-block" href="/pages/adsdetail/adsdetail.php?id=<?= $top_ad['id'] ?>" target="_blank">
                    <?= htmlspecialchars($top_ad['title']) ?>
                </a>
                <div class="text-muted small"><?= $top_ad['view_count'] ?> baxış</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Şikayət Sayısı</h6>
                <h3 class="text-danger fw-bold"><?= $complaint_count ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Mesaj Sayısı</h6>
                <h3 class="text-info fw-bold"><?= $message_count ?></h3>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3"><i class="bi bi-pin-angle-fill text-danger me-2"></i>Kategoriyə görə Elan Sayısı</h5>
            <div class="card shadow-sm rounded-4 p-4">
                <canvas id="categoryChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">📌 Son 5 Elan</h6>
                <ul class="list-group list-group-flush">
                    <?php
                    $last_ads = $baglanti->query("SELECT id, title, created_at FROM ads ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($last_ads as $ad): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="/pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>" target="_blank">#<?= $ad['id'] ?> - <?= htmlspecialchars($ad['title']) ?></a>
                            <small class="text-muted"><?= date('d.m.Y', strtotime($ad['created_at'])) ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">💬 Son 5 Mesaj</h6>
                <ul class="list-group list-group-flush">
                    <?php
                    $last_msgs = $baglanti->query("SELECT subject, created_at FROM messages ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($last_msgs as $msg): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($msg['subject']) ?>
                            <small class="text-muted"><?= date('d.m.Y', strtotime($msg['created_at'])) ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">🚩 Son 5 Şikayət</h6>
                <ul class="list-group list-group-flush">
                    <?php
                    $last_complaints = $baglanti->query("SELECT ad_id, reason, created_at FROM complaints ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($last_complaints as $c): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>#<?= $c['ad_id'] ?>:</strong> <?= htmlspecialchars($c['reason']) ?></span>
                            <small class="text-muted"><?= date('d.m.Y', strtotime($c['created_at'])) ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">⏱ Son Girişlər</h6>
                <ul class="list-group list-group-flush">
                    <?php
                    $last_users = $baglanti->query("SELECT first_name, email, created_at FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($last_users as $u): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 70%;">
                                <?= htmlspecialchars($u['first_name']) ?> (<?= htmlspecialchars($u['email']) ?>)
                            </div>
                            <small class="text-muted"><?= date('d.m.Y', strtotime($u['created_at'])) ?></small>
                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">🔥 Ən çox baxılan 5 elan</h6>
                <ul class="list-group list-group-flush">
                    <?php
                    $popular_ads = $baglanti->query("SELECT id, title, view_count FROM ads ORDER BY view_count DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($popular_ads as $ad): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="/pages/adsdetail/adsdetail.php?id=<?= $ad['id'] ?>" target="_blank">#<?= $ad['id'] ?> - <?= htmlspecialchars($ad['title']) ?></a>
                            <span class="badge bg-primary rounded-pill"><?= $ad['view_count'] ?> baxış</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($categories) ?>,
            datasets: [{
                label: 'Elan Sayısı',
                data: <?= json_encode($counts) ?>,
                backgroundColor: '#0d6efd',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

<?php include './includes/footer.php'; ?>