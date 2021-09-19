<html>
<head>
    <title>upload image to firebase</title>
</head>
<body>
<center>
    <form enctype="multipart/form-data">
        <label>select image : </label>
        <input type="file" id="image" accept="image/*"><br><br>
        <button type="button" onclick="upload()">Upload</button>
    </form>
</center>






<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#config-web-app -->

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyCsjPQ8IncAf1NPoziHO-M_MOqziEdP2SM",
        authDomain: "xstatus-b4223.firebaseapp.com",
        projectId: "xstatus-b4223",
        storageBucket: "xstatus-b4223.appspot.com",
        messagingSenderId: "847446853664",
        appId: "1:847446853664:web:4bd14e5ddfbb3454f15445",
        measurementId: "G-V339RKE0F8"
    };
    // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
      firebase.analytics();
</script>
<script type="text/javascript">
    function upload() {
    //get your select image
    var image=document.getElementById("image").files[0];
    //now get your image name
    var imageName=image.name;
    //firebase  storage reference
    //it is the path where yyour image will store
    var storageRef=firebase.storage().ref('images/'+imageName);
    //upload image to selected storage reference

    var uploadTask=storageRef.put(image);

    uploadTask.on('state_changed',function (snapshot) {
        //observe state change events such as progress , pause ,resume
        //get task progress by including the number of bytes uploaded and total
        //number of bytes
        var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
        console.log("upload is " + progress +" done");
    },function (error) {
        //handle error here
        console.log(error.message);
    },function () {
       //handle successful uploads on complete

        uploadTask.snapshot.ref.getDownloadURL().then(function (downlaodURL) {
            //get your upload image url here...
            console.log(downlaodURL);
        });
    });
}
</script>
</body>
</html>