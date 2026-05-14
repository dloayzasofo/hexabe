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

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

window.requestPermission = () => {
  console.log('Requesting permission...');
  Notification.requestPermission().then( (permission) => {
    if (permission === 'granted') {
      console.log('Pidiendo el token.');
      //getTokenFirebase();

        navigator.serviceWorker.register('https://hexabe.sofopolis.com/firebase-messaging-sw.js', {scope: "/"}).then((registration) => {
                        
            getToken(messaging, { 
                vapidKey: "BMk_G6cbLCiCsJECzuIFyOB3_DsaUXVHsuOaX_fCwutenYssTNn--REtAH0hrezra__YakRgWm5CtTPtrBDskJQ",
                serviceWorkerRegistration: registration
            }).then((currentToken) => {
                if (currentToken) {
                    console.log("token is: " + currentToken);
                    // Send the token to your server and update the UI if necessary
                    // ...
                } else {
                    // Show permission request UI
                    console.log('No registration token available. Request permission to generate one.');
                    // ...
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err.message);
                // ...
            });

        }).catch((err) => {
            console.log('Service Worker registration failed: ', err);
        });

    }else {
      console.log('Unable to get permission to notify.');
    }
  });
}

/*
function getTokenFirebase() {
    //navigator.serviceWorker.register('/firebase-messaging-sw.js').then((registration) => {
        getToken(messaging, { vapidKey: config_push_notification_vapid }).then((currentToken) => {
            if (currentToken) {
                console.log("token is: " + currentToken);
                // Send the token to your server and update the UI if necessary
                // ...
            } else {
                // Show permission request UI
                console.log('No registration token available. Request permission to generate one.');
                // ...
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err.message);
            // ...
        });
    //});
}
*/

window.addEventListener('load', function() {
    let checkEnablePush = document.getElementById('pushNotification');
    if( checkEnablePush ){
        checkEnablePush.addEventListener('change', function() {
            if (this.checked) {
                window.requestPermission();
            } else {
                console.log('Push notification disabled.');
                // You can also implement logic to delete the token from your server if needed
            }
        });
    }
});