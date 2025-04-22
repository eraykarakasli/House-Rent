<?php
include './includes/session_check.php';
include './includes/config.php';
include './includes/header.php';
include './includes/sidebar.php';
?>

<div class="container-fluid my-4 px-4">
    <h4 class="mb-4"><i class="bi bi-bar-chart-line me-2"></i>Panel İstatistikləri</h4>

    <!-- Satır 1: İstatistik Kartları -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Ümumi Üzv Sayı</h6>
                <h3 class="text-primary fw-bold">123</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Yayında olan İlanlar</h6>
                <h3 class="text-success fw-bold">45</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Onay Bekleyen İlanlar</h6>
                <h3 class="text-warning fw-bold">7</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm text-center py-4 rounded-4 bg-light">
                <h6 class="text-muted">Blog Sayısı</h6>
                <h3 class="text-dark fw-bold">32</h3>
            </div>
        </div>
    </div>

    <!-- Satır 2: Grafik -->
    <div class="row">
        <div class="col-12">
            <h5 class="mb-3"><i class="bi bi-pin-angle-fill text-danger me-2"></i>Kategoriyə görə İlan Sayısı</h5>
            <div class="card shadow-sm rounded-4 p-4">
                <canvas id="categoryChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js script -->
<script>
    const ctx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ev', 'Ofis', 'Torpaq', 'Obyekt', 'Villa'],
            datasets: [{
                label: 'İlan Sayısı',
                data: [12, 8, 5, 3, 7],
                backgroundColor: '#0d6efd',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>

<?php include './includes/footer.php'; ?>
