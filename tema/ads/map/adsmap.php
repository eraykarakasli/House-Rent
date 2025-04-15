<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Harita kapsayıcısı -->
<div id="map" style="height: 600px; border-radius: 12px;" class="shadow-sm"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    .price-marker {
        background-color: white;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        white-space: nowrap;
        text-align: center;
        min-width: 80px;
    }
</style>


<script>
    var map = L.map('map').setView([40.4093, 49.8671], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // PHP'den gelen ilanlar
    var listings = <?= json_encode([
        ['lat' => 40.4093, 'lng' => 49.8671, 'price' => '335k AZN', 'title' => '8 Noyabr'],
        ['lat' => 40.4255, 'lng' => 49.8760, 'price' => '250k AZN', 'title' => 'Xətai'],
        ['lat' => 40.3890, 'lng' => 49.8520, 'price' => '199k AZN', 'title' => 'Masazır'],
        ['lat' => 40.3892, 'lng' => 49.8520, 'price' => '559k AZN', 'title' => 'Masazır3'],
    ]) ?>;

    // Gruplama hassasiyeti
    var precision = 0.0002;

    // Konum gruplarını oluştur
    var grouped = [];

    listings.forEach(function(item) {
        // Yakın bir grup var mı kontrol et
        var foundGroup = false;

        for (var i = 0; i < grouped.length; i++) {
            var g = grouped[i];
            var distLat = Math.abs(g.lat - item.lat);
            var distLng = Math.abs(g.lng - item.lng);

            if (distLat < precision && distLng < precision) {
                g.items.push(item);
                foundGroup = true;
                break;
            }
        }

        // Eğer grup yoksa yeni grup oluştur
        if (!foundGroup) {
            grouped.push({
                lat: item.lat,
                lng: item.lng,
                items: [item]
            });
        }
    });

    // Grupları haritaya ekle
    grouped.forEach(function(group) {
        var html;
        if (group.items.length === 1) {
            html = `<div class="price-marker">${group.items[0].price}</div>`;
        } else {
            html = `<div class="price-marker">+${group.items.length}</div>`;
        }

        var icon = L.divIcon({
            className: '',
            html: html
        });

        var popupHtml = group.items.map(i => `<strong>${i.price}</strong><br>${i.title}`).join('<hr>');

        L.marker([group.lat, group.lng], {
                icon: icon
            })
            .addTo(map)
            .bindPopup(popupHtml);
    });
</script>
