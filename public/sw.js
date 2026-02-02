const CACHE_NAME = 'sira-offline';
const filesToCache = ['/', '/offline.html'];

const preLoad = function () {
    return caches.open(CACHE_NAME).then(function (cache) {
        // caching index and important routes
        return cache.addAll(filesToCache);
    });
};

self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
    // self.skipWaiting();
});

// Détecter quand un évènement de type push est reçu
self.addEventListener("push", function (event) {
    let data = {};

    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data = { body: event.data.text() };
        }
    }

    const title = data.title || 'Sira';
    const options = {
        body: data.body || 'Vous avez une nouvelle notification',
        icon: data.icon || '/pwa-192x192.png',
        badge: '/pwa-192x192.png',
        vibrate: [100, 50, 100],
        data: data.data || {},
        actions: data.actions || [],
        tag: data.tag || 'default',
        renotify: true,
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();

    // Récupérer l'URL depuis les données de la notification
    const url = event.notification.data?.url || '/dashboard';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            // Si une fenêtre est déjà ouverte sur le site, on la focus
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if (client.url.includes(self.location.origin) && 'focus' in client) {
                    client.focus();
                    client.navigate(url);
                    return;
                }
            }
            // Sinon, on ouvre une nouvelle fenêtre
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});

/* self.addEventListener("activate", function (event) {
    clients.claim();
    event.waitUntil(
        (async () => {
            const keys = await caches.keys();
            await Promise.all(
                keys.map((key) => {
                    if (!key.includes("sira-offline")) {
                        return caches.delete(key);
                    }
                })
            );
        })()
    );
}); */

/**
 * Fait une requête réseau et retourne la réponse.
 * Rejette UNIQUEMENT en cas d'erreur réseau (pas de connexion).
 * Les erreurs HTTP (404, 500, etc.) sont des réponses valides et sont retournées normalement.
 */
const fetchFromNetwork = function (request) {
    return fetch(request).then(function (response) {
        // Retourner la réponse même si c'est une 404 ou 500
        // C'est une réponse valide du serveur
        return response;
    });
    // Si fetch() échoue (erreur réseau), la Promise sera rejetée automatiquement
};

const addToCache = function (request) {
    // Only cache http(s) requests
    if (!request.url.startsWith('http')) {
        return Promise.resolve();
    }
    return caches.open("sira-offline").then(function (cache) {
        return fetch(request).then(function (response) {
            // Ne pas cacher les erreurs HTTP
            if (response.ok) {
                return cache.put(request, response.clone());
            }
        }).catch(function () {
            // Ignorer les erreurs de mise en cache
        });
    });
};

/**
 * Retourne une réponse depuis le cache.
 * Si rien n'est trouvé, retourne offline.html.
 */
const returnFromCache = function (request) {
    return caches.open("sira-offline").then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (matching) {
                return matching;
            }
            // Aucune correspondance dans le cache, retourner la page offline
            return cache.match("/offline.html");
        });
    });
};

self.addEventListener("fetch", function (event) {
    // Skip non-GET requests and Livewire requests
    if (event.request.method !== 'GET' ||
        event.request.url.includes('/livewire/') ||
        event.request.url.includes('livewire')) {
        return;
    }

    // Skip API requests - don't serve cached versions for API calls
    if (event.request.url.includes('/api/')) {
        return;
    }

    // Skip OAuth/Auth callbacks - these MUST go directly to the server
    if (event.request.url.includes('/auth/')) {
        return;
    }

    event.respondWith(
        fetchFromNetwork(event.request)
            .catch(function () {
                // Erreur réseau (offline) - servir depuis le cache
                return returnFromCache(event.request);
            })
    );

    // Mettre en cache les requêtes réussies en arrière-plan
    if (event.request.url.startsWith('http')) {
        event.waitUntil(addToCache(event.request));
    }
});
