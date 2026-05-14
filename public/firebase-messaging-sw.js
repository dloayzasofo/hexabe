self.addEventListener('push', (event) => {
    console.log('Received a push message', event);
    const notif = event.data.json().notification;
    console.log(event.data.json());
    event.waitUntil(self.registration.showNotification(notif.title, {
        body: notif.body,
        icon: notif.image,
        //badge: notif.badge,
        //tag: notif.tag,
        data: {
            url: notif.url,  
        },
        vibrate: [200, 100, 200],
    }));
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = event.notification.data.url;
    event.waitUntil(clients.openWindow(url));
});