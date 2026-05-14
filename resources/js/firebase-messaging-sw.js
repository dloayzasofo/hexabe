import { initializeApp } from "firebase/app";
import { getMessaging, getToken } from "firebase/messaging";

const firebaseConfig = {
  apiKey: "AIzaSyDnoESSREzpXYaGmozBwhfBM-ZJSrgjl0A",
  authDomain: "hexabe-89665.firebaseapp.com",
  projectId: "hexabe-89665",
  storageBucket: "hexabe-89665.firebasestorage.app",
  messagingSenderId: "286270715444",
  appId: "1:286270715444:web:0b558ee31553a6992bbc61",
  measurementId: "G-E2BTDR3VYQ"
};

self.addEventListener('push', (event) => {
    console.log('Received a push message', event);
    /*
    const notif = event.data.json().notification;

    event.waitUntil(self.ServiceWorkerRegistration.showNotification(notif.title, {
        body: notif.body,
        icon: notif.image,
        //badge: notif.badge,
        //tag: notif.tag,
        data: {
            url: notif.url,  
        },
        vibrate: [200, 100, 200],
    }));
    */
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = event.notification.data.url;
    event.waitUntil(clients.openWindow(url));
});