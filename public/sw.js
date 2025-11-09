// Service Worker Dinonaktifkan Sementara
self.addEventListener("install", function (event) {
    console.log("Service Worker: Disabled for debugging");
    self.skipWaiting();
});

self.addEventListener("activate", function (event) {
    console.log("Service Worker: Activated but disabled");
    event.waitUntil(self.clients.claim());
});

self.addEventListener("fetch", function (event) {
    // Bypass service worker untuk semua request
    return;
});
