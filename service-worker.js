// Minimal service worker -- mobile var "Add to Home Screen" installable banavण्यासाठी lagto.
// Data कधीही offline cache honar nahi (attendance live database var आधारित असल्यामुळे),
// फक्त pass-through fetch वापरतोय.

self.addEventListener('install', function (event) {
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', function (event) {
    event.respondWith(fetch(event.request));
});
