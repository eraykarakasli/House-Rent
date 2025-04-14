<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toggle Menü</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-5">

  <!-- Buton -->
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
    Menü Aç / Kapat
  </button>

  <!-- Menü -->
  <div class="collapse mt-3" id="menu">
    <div class="card card-body">
      Bu açılır menüdür. Butona tekrar basınca kapanır.
    </div>
  </div>

</body>
</html>
