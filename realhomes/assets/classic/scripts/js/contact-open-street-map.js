/**
 * Javascript to handle open street map for property single page.
 */
jQuery(function ($) {
    'use strict';

    if (typeof contactMapData !== "undefined") {

        if (contactMapData.lat && contactMapData.lng) {

            var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });

            var mapCenter = L.latLng(contactMapData.lat, contactMapData.lng);
            var mapZoom = 14;

            if (contactMapData.zoom) {
                mapZoom = contactMapData.zoom
            }

            var mapOptions = {
                center: mapCenter, zoom: mapZoom
            };

            var contactMap = L.map('map_canvas', mapOptions);
            contactMap.scrollWheelZoom.disable();
            contactMap.addLayer(tileLayer);

            L.marker(mapCenter).addTo(contactMap);

        }

    }

});