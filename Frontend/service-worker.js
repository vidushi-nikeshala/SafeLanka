
const myCache = 'safelanka-v1';

const filesToSave = [
    'offline.html',
    'homepage.css',
    'images/png.png',
    'images/logo2.png'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(myCache)
            .then(cache => {
                console.log('Saving files to the cache...');
                return cache.addAll(filesToSave);
            })
    );
});

self.addEventListener('fetch', event => {
    const myUrl = new URL(event.request.url);

    if (myUrl.pathname.endsWith('.php')) {
        event.respondWith(
            fetch(event.request).catch(() => {
                return caches.match('offline.html');
            })
        );
        return; 
    }

    event.respondWith(
        caches.match(event.request)
            .then(found => {
                return found || fetch(event.request);
            })
    );
});

self.addEventListener('activate', event => {
    const keepList = [myCache];
    
    event.waitUntil(
        caches.keys().then(allBoxes => {
            return Promise.all(
                allBoxes.map(boxName => {
                    if (keepList.indexOf(boxName) === -1) {
                        return caches.delete(boxName);
                    }
                })
            );
        })
    );
});