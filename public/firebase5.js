importScripts('https://www.gstatic.com/firebasejs/7.2.0/firebase.js');
importScripts('https://www.gstatic.com/firebasejs/7.2.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.2.0/firebase-messaging.js');
// For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics. 
importScripts('https://www.gstatic.com/firebasejs/7.2.0/firebase-analytics.js');
/* 
// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  'messagingSenderId': '614333744074'
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/itwonders-web-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
}); */

  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyAMcYbGKCqRtJLaaj9b28L1jVhYQU9s3XU",
    authDomain: "laravel6-94e18.firebaseapp.com",
    databaseURL: "https://laravel6-94e18.firebaseio.com",
    projectId: "laravel6-94e18",
    storageBucket: "laravel6-94e18.appspot.com",
    messagingSenderId: "614333744074",
    appId: "1:614333744074:web:b9ba12ebf69dc9979b8533",
    measurementId: "G-BJTSZ8ZWJZ"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  // Retrieve Firebase Messaging object.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
      body: 'Background Message body.',
      icon: '/itwonders-web-logo.png'
    };
  
    return self.registration.showNotification(notificationTitle,
        notificationOptions);
  });