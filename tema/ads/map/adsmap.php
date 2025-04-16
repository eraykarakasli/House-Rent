<?php if (isset($_GET['map']) && $_GET['map'] === 'on'): ?>

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
    <?php include "mapcarousel.php" ?>
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

    // Leaflet harita tamamen yüklendiğinde spinner'ı gizle
    map.whenReady(() => {
        const spinner = document.getElementById('mapSpinner');
        if (spinner) spinner.style.display = 'none';
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // PHP'den gelen ilanlar
    let listings = <?= json_encode([
        ['lat' => 40.4093, 'lng' => 49.8671, 'price' => '335k AZN', 'title' => '8 Noyabr'],
        ['lat' => 40.4094, 'lng' => 49.8672, 'price' => '340k AZN', 'title' => '8 Noyabr 2'],
        ['lat' => 40.4255, 'lng' => 49.8760, 'price' => '250k AZN', 'title' => 'Xətai'],
        ['lat' => 40.3890, 'lng' => 49.8520, 'price' => '199k AZN', 'title' => 'Masazır'],
        ['lat' => 40.3892, 'lng' => 49.8520, 'price' => '559k AZN', 'title' => 'Masazır3'],
        ['lat' => 40.3892, 'lng' => 49.8521, 'price' => '559k AZN', 'title' => 'Masazır5'],
    ]) ?>;

    let markerLayerGroup = L.layerGroup().addTo(map);
    let activeMarkerDiv = null;

    function getPrecision(zoom) {
        return zoom >= 15 ? 0.00001 : zoom >= 14 ? 0.00005 : 0.0002;
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
                `<div class="price-marker">${group.items[0].price}</div>` :
                `<div class="price-marker">+${group.items.length}</div>`;

            let icon = L.divIcon({ html: html, className: '' });

            let marker = L.marker([group.lat, group.lng], { icon }).addTo(markerLayerGroup);

            if (group.items.length === 1) {
                marker.on('click', function(e) {
                    if (activeMarkerDiv) activeMarkerDiv.classList.remove('active');
                    let currentDiv = e.target._icon.querySelector('.price-marker');
                    if (currentDiv) {
                        currentDiv.classList.add('active');
                        activeMarkerDiv = currentDiv;
                    }
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
