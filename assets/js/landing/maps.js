// Inicializa el mapa en Bogotá, Colombia
var mapa = L.map('mapa').setView([4.7110, -74.0721], 13);

// Agrega la capa de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
}).addTo(mapa);

// Agrega un marcador en Bogotá
L.marker([4.7110, -74.0721]).addTo(mapa)
    .bindPopup('Bogotá, Colombia')
    .openPopup();