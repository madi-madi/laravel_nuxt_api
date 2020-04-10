//   Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAMcYbGKCqRtJLaaj9b28L1jVhYQU9s3XU",
  authDomain: "laravel6-94e18.firebaseapp.com",
  databaseURL: "https://laravel6-94e18.firebaseio.com",
  projectId: "laravel6-94e18",
  storageBucket: "laravel6-94e18.appspot.com",
  messagingSenderId: "614333744074",
  appId: "1:614333744074:web:b9ba12ebf69dc9979b8533",
  measurementId: "G-BJTSZ8ZWJZ"
  };
//   Initialize Firebase
firebase.initializeApp(firebaseConfig);
// var ref = firebase.database().ref().child("test");
    const messaging = firebase.messaging();
    messaging.usePublicVapidKey("BFumj570XhSp4YPrcKptYFSzkCh9VNRPCRnp-5Jg3x4W7NSEKnOok7izTiQcmeGmVYNtVgAanCW4Gar1Wxv-6mA");

    messaging.requestPermission()
    .then(function(){
        console.log('genrated no permission');
        return messaging.getToken();
    })
    .then(function(token){

        console.log(token);
    })
    .catch(function(error){
        console.log("error");
        console.log(error);
    });
    // messaging.usePublicVapidKey("BFumj570XhSp4YPrcKptYFSzkCh9VNRPCRnp-5Jg3x4W7NSEKnOok7izTiQcmeGmVYNtVgAanCW4Gar1Wxv-6mA");
//     messaging.onMessage((payload) => {
//   console.log( payload);
//   // ...
// });