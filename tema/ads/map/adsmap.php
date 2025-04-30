<?php if (isset($_GET['map']) && $_GET['map'] === 'on'): ?>
    <?php
    $category = $_GET['category'] ?? null;

    $listingQuery = "SELECT id, latitude AS lat, longitude AS lng, price, title, address, room_count, area, floor, created_at, images, certificate, mortgage, renovated FROM ads WHERE status = 1 AND latitude IS NOT NULL AND longitude IS NOT NULL";
    $params = [];

    if ($category) {
        $listingQuery .= " AND category = ?";
        $params[] = $category;
    }

    $stmt = $baglanti->prepare($listingQuery);
    $stmt->execute($params);
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Harita kapsayıcısı -->
    <div class="position-relative">
        <!-- Spinner -->
        <div id="mapSpinner" class="position-absolute top-50 start-50 translate-middle">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Yükleniyor...</span>
            </div>
        </div>

        <!-- Harita -->
        <div id="map" style="height: 600px; border-radius: 12px;" class="shadow-sm"></div>

        <!-- Harita kartı -->
        <a id="mapCard" class="position-absolute bottom-0 start-0 m-3 text-decoration-none text-dark" style="z-index: 1000; width: 260px; display: none;" href="#">
            <div class="card h-100 position-relative shadow-sm border-0 rounded-4 overflow-hidden w-100">
                <!-- İlan Resmi -->
                <div class="position-relative" style="height: 200px;">
                    <img id="mapCardImage" src="" alt="İlan Görseli" class="d-block w-100" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 m-2 d-flex gap-1" id="mapCardBadges"></div>
                </div>
                <div class="p-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong class="fs-6" id="mapCardPrice"></strong>
                        <small class="text-muted" id="mapCardDate" style="font-size: 12px;"></small>
                    </div>
                    <p class="text-muted mb-2 small" id="mapCardAddress"><i class="bi bi-geo-alt me-1"></i></p>
                    <div class="d-flex justify-content-between text-muted small">
                        <span id="mapCardRooms"><i class="bi bi-door-open me-1"></i></span>
                        <span id="mapCardArea"><i class="bi bi-aspect-ratio me-1"></i></span>
                        <span id="mapCardFloor"><i class="bi bi-building me-1"></i></span>
                    </div>

                </div>
            </div>
        </a>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        .price-marker {
            background-color: white;
            color: black;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            white-space: nowrap;
            text-align: center;
            min-width: 80px;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price-marker.active {
            background-color: black !important;
            color: white !important;
            border-color: #000 !important;
        }

        #mapCard {
            display: none;
        }

        #mapSpinner {
            z-index: 9999;
        }
    </style>

    <script>
        let map = L.map('map').setView([40.4093, 49.8671], 13);

        map.whenReady(() => {
            const spinner = document.getElementById('mapSpinner');
            if (spinner) spinner.style.display = 'none';
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let listings = <?= json_encode($listings) ?>;
        let markerLayerGroup = L.layerGroup().addTo(map);
        let activeMarkerDiv = null;

        function getPrecision(zoom) {
            if (zoom >= 17) return 0.00001;
            if (zoom >= 15) return 0.00005;
            if (zoom >= 13) return 0.0002;
            return 0.0005;
        }

        function drawMarkers() {
            markerLayerGroup.clearLayers();
            let grouped = [];
            let precision = getPrecision(map.getZoom());

            listings.forEach(function(item) {
                let found = false;
                for (let group of grouped) {
                    if (
                        Math.abs(group.lat - item.lat) < precision &&
                        Math.abs(group.lng - item.lng) < precision
                    ) {
                        group.items.push(item);
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    grouped.push({
                        lat: item.lat,
                        lng: item.lng,
                        items: [item]
                    });
                }
            });

            grouped.forEach(function(group) {
                let html = group.items.length === 1 ?
                    `<div class="price-marker">${group.items[0].price} AZN</div>` :
                    `<div class="price-marker">+${group.items.length}</div>`;

                let icon = L.divIcon({
                    html: html,
                    className: ''
                });
                let marker = L.marker([group.lat, group.lng], {
                    icon
                }).addTo(markerLayerGroup);

                if (group.items.length === 1) {
                    marker.on('click', function(e) {
                        if (activeMarkerDiv) activeMarkerDiv.classList.remove('active');
                        let currentDiv = e.target._icon.querySelector('.price-marker');
                        if (currentDiv) {
                            currentDiv.classList.add('active');
                            activeMarkerDiv = currentDiv;
                        }

                        const ad = group.items[0];
                        const images = ad.images ? JSON.parse(ad.images) : [];
                        const firstImage = images.length > 0 ? "../../tema/" + images[0] : "../../assets/no-image.webp";

                        document.getElementById('mapCardImage').src = firstImage;
                        document.getElementById('mapCardPrice').textContent = `${ad.price} AZN`;
                        document.getElementById('mapCardAddress').innerHTML = `<i class="bi bi-geo-alt me-1"></i>${ad.address}`;
                        document.getElementById('mapCardRooms').innerHTML = `<i class="bi bi-door-open me-1"></i>${ad.room_count} otaq`;
                        document.getElementById('mapCardArea').innerHTML = `<i class="bi bi-aspect-ratio me-1"></i>${ad.area}m²`;
                        document.getElementById('mapCardFloor').innerHTML = `<i class="bi bi-building me-1"></i>${ad.floor}`;
                        document.getElementById('mapCard').href = `../../pages/adsdetail/adsdetail.php?id=${ad.id}`;

                        const badgeContainer = document.getElementById('mapCardBadges');
                        badgeContainer.innerHTML = '';
                        if (ad.certificate == 1) badgeContainer.innerHTML += '<span class="btn btn-success btn-sm rounded-circle p-1" title="Çıxarış var"><i class="bi bi-clipboard-check-fill"></i></span>';
                        if (ad.mortgage == 1) badgeContainer.innerHTML += '<span class="btn btn-warning btn-sm rounded-circle p-1" title="İpoteka var"><i class="bi bi-percent"></i></span>';
                        if (ad.renovated == 1) badgeContainer.innerHTML += '<span class="btn btn-danger btn-sm rounded-circle p-1" title="Təmirli"><i class="bi bi-hammer"></i></span>';

                        const createdAt = new Date(ad.created_at);
                        const day = String(createdAt.getDate()).padStart(2, '0');
                        const month = String(createdAt.getMonth() + 1).padStart(2, '0');
                        const year = createdAt.getFullYear();
                        document.getElementById('mapCardDate').textContent = `${day}.${month}.${year}`;

                        document.getElementById('mapCard').style.display = 'block';
                    });
                }
            });
        }

        drawMarkers();

        map.on('zoomend', function() {
            if (activeMarkerDiv) activeMarkerDiv.classList.remove('active');
            activeMarkerDiv = null;
            drawMarkers();
        });

        map.on('click', function() {
            document.getElementById('mapCard').style.display = 'none';
            if (activeMarkerDiv) activeMarkerDiv.classList.remove('active');
        });
    </script>

<?php endif; ?>