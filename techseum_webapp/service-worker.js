const paginaOffline = "offline.html";

self.addEventListener('install', function(e) {
 e.waitUntil(
   caches.open('Offline').then(function(cache) {
     return cache.addAll([
      'favicon.ico',
      'res/192x192.png',
      'res/bg_2_1920x1080.png',
      'style/allstyles.css',
      'style/home.css',
      'manifest.json',
       paginaOffline
     ]);
   })
 );
});

self.addEventListener('fetch', (event) => {
    // Rispondiamo solo a una richiesta per una pagina web
    if (event.request.mode === 'navigate') {
        event.respondWith((async () => {
            try {
                // Prova a usare la preloadResponse
                const preloadResponse = await event.preloadResponse;
                if (preloadResponse) {
                    return preloadResponse;
                }

                const networkResponse = await fetch(event.request);
                return networkResponse;
            } catch (error) {
                // Qualcosa è andato storto; probabilmente sei offline!
                console.log('Restituisco la pagina offline', error);

                const cache = await caches.open('Offline');
                const cachedResponse = await cache.match(paginaOffline);
                return cachedResponse;
            }
        })());
    }
});

self.addEventListener('push', function(event) {
  console.log('[Service Worker] Push Received.');
  console.log(`[Service Worker] Push had this data: "${event.data.text()}"`);

  const title = 'Appunti';
  const options = {
    body: 'Sei offline!',
    icon: 'res/favicon.ico',
    badge: 'res/logo_iconato.png'
  };

  event.waitUntil(self.registration.showNotification(title, options));
});