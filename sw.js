const CACHE='ebazar-v1';

const FILES=[
    '/',
];

self.addEventListener('install',e=>{

    e.waitUntil(

        caches.open(CACHE)
            .then(cache=>cache.addAll(FILES))

    );

});

self.addEventListener('fetch',event=>{

    event.respondWith(

        caches.match(event.request)
            .then(response=>{

                return response || fetch(event.request);

            })

    );

});