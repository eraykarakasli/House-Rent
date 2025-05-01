<!-- Overlay for mobile -->
<div id="overlay"></div>

<div class="d-flex">
  <!-- Sidebar -->
  <!-- Sidebar -->
  <div id="sidebar" class="d-flex flex-column justify-between p-3 sidebar">
    <div>
      <h4 class="mb-4">Ev Sistemi</h4>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a href="/admin/dashboard.php" class="nav-link">
            <i class="bi bi-house-door"></i> Ana Səhifə
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/static_pages.php" class="nav-link">
            <i class="bi bi-file-earmark-text"></i> Statik Səhifələr
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/blogs.php" class="nav-link">
            <i class="bi bi-journal-text"></i> Bloglar
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/listings.php" class="nav-link">
            <i class="bi bi-megaphone"></i> Elan Prosesi
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/approved_listings.php" class="nav-link">
            <i class="bi bi-patch-check"></i> Təsdiqlənmiş Elanlar
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/messages.php" class="nav-link">
            <i class="bi bi-envelope-paper"></i> Mesajlar
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/users.php" class="nav-link">
            <i class="bi bi-people-fill"></i> İstifadəçilər
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/complaints.php" class="nav-link">
            <i class="bi bi-exclamation-octagon"></i> Şikayətlər
          </a>
        </li>
      </ul>
    </div>

    <div class="mt-auto">
      <hr class="text-secondary">
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a href="/admin/admin_settings.php" class="nav-link">
            <i class="bi bi-gear"></i> Sayt Ayarları
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/password_update.php" class="nav-link">
            <i class="bi bi-person-circle"></i> Profilim
          </a>
        </li>
        <li class="nav-item">
          <a href="includes/logout.php" class="nav-link">
            <i class="bi bi-box-arrow-right"></i> Çıxış
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-grow-1 position-relative" id="main-content">



  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar toggle -->
<style>
  body.sidebar-open {
    overflow: hidden;
  }

  .sidebar {
    min-width: 250px;
    min-height: 100vh;
    background-color: #212529;
    color: white;
    transition: transform 0.3s ease;
  }

  .sidebar a {
    color: white;
  }



  @media (max-width: 991.98px) {
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1050;
      transform: translateX(-100%);
    }

    .sidebar.active {
      transform: translateX(0);
    }

    #main-content {
      width: 100%;
    }

    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 100vw;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1040;
    }

    #overlay.active {
      display: block;
    }
  }
</style>