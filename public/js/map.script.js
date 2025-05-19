    document.addEventListener("DOMContentLoaded", function () {
        // Inicializar el mapa centrado en una ubicación específica
        const map = L.map('map').setView([45.434046, 12.340284], 11);  // Centrado en las coordenadas iniciales

        // Cargar el mapa desde OpenStreetMap sin clave de API
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Definir ubicaciones
        const location1 = [45.434046, 12.340284];    // Primera ubicación
        const location2 = [45.445, 12.350];          // Segunda ubicación

        // Añadir marcadores
        L.marker(location1).addTo(map).bindPopup('Ubicación 1');
        L.marker(location2).addTo(map).bindPopup('Ubicación 2');
    });
