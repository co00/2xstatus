<html>
<head>
    <title>Upload Video</title>

<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link href="<?=ADMIN_ASSETS?>css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style type="text/css">
    .file-drop {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-direction: column;
    width: 100%;
    height: 100%;
    min-height: 180px;
    border-width: 3px;
    border-style: dashed;
    border-color: #cbd5e0;
    background-color: #edf2f7;
    transition: background-color 160ms ease, border-color 400ms ease;
}

.form-design{
    border-radius: 4px; 
    border: 2px solid; 
    border-color: transparent; 
    font-weight: 500; 
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 20%), 0 4px 6px -2px rgb(0 0 0 / 5%);
    font-weight: 500;
}

.button {
    min-width: 170px;
    min-height: 42px;
    padding: 0 14px;
    font-size: 18px;
    color: white;
    background-color: #F1592A;
    border-color: #F1592A;
    position: relative;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    flex: 0 0 auto;
    border-radius: 4px;
    border: 2px solid;
    border-color: transparent;
    font-weight: 500;
    line-height: 1;
    user-select: none;
    touch-action: manipulation;
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 20%), 0 4px 6px -2px rgb(0 0 0 / 5%);
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    transition: background-color 160ms, color 160ms, box-shadow 160ms, border 160ms;
}

@-webkit-keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes pulse {
  50% {
    background: white;
  }
}
@keyframes pulse {
  50% {
    background: white;
  }
}
html, body {
  height: 100%;
}

.loading {
  border-radius: 50%;
  width: 30px;
  height: 30px;
  border: 0.50rem solid rgba(255, 255, 255, 0.2);
  border-top-color: white;
  -webkit-animation: spin 1s infinite linear;
          animation: spin 1s infinite linear;
}

.loading-pulse {
  position: relative;
  width: 6px;
  height: 24px;
  background: rgba(255, 255, 255, 0.2);
  -webkit-animation: pulse 750ms infinite;
          animation: pulse 750ms infinite;
  -webkit-animation-delay: 250ms;
          animation-delay: 250ms;
}
.loading-pulse:before, .loading-pulse:after {
  content: "";
  position: absolute;
  display: block;
  height: 16px;
  width: 6px;
  background: rgba(255, 255, 255, 0.2);
  top: 50%;
  transform: translateY(-50%);
  -webkit-animation: pulse 750ms infinite;
          animation: pulse 750ms infinite;
}
.loading-pulse:before {
  left: -12px;
}
.loading-pulse:after {
  left: 12px;
  -webkit-animation-delay: 500ms;
          animation-delay: 500ms;
}

.loader{
    align-items: center;
    position: fixed;
    z-index: 9999;
    height: 100%;
    background: #000;
    opacity: 0.5;
    width: 100%;
    top: 0;
    margin: 0px;
    padding: 0px;
    left: 0;
    bottom: 0;
    align-items: center;
    display: flex;
    justify-content: space-around;
}
</style>

</head>
<body>

<div class="loader hidden">
    <div class="loading"></div>
</div>

<div class="panel panel-default col-sm-12 file-drop">
  <div class="panel-body" style="width: 100%;">
    
    <form action="javascript:void(0)" enctype="multipart/form-data">

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <select class="form-control form-design" id="category_id">
              <?php if (!empty($category)) { foreach ($category as $key => $value) { ?>
                <option value="<?=$value->id?>"><?=$value->name?></option>
              <?php } } ?>
            </select> 
        </div>

        <div class="col-sm-12 col-md-12">
          <br>
            <input type="text" class="form-control form-design" id="name" placeholder="Enter Name">
        </div>

        <div class="col-sm-12 col-md-12">
          <br>
            <select class="form-control form-design" id="watermark_status">
              <option value="0">Watermark Disable</option>  
              <option value="1">Watermark Enable</option>  
            </select>
        </div>

        <div class="col-sm-12 col-md-12">
            <br>
            <button class="form-control button" onclick="document.getElementById('image').click();"><i class="fa fa-plus-circle" style="font-size: 22px;margin-right: 14px;"></i> Upload Image</button>
        </div>

        <div class="col-sm-12 col-md-12">
            <br>
            <button class="form-control button" onclick="document.getElementById('video').click();" style="background: #47CF73;"><i class="fa fa-plus-circle" style="font-size: 22px;margin-right: 14px;"></i> Upload Video</button>
        </div>

        <!-- <div class="col-sm-12 col-md-12">
            <br>
            <b style="color: #F1592A; font-size: 15px;">Onesignal Notification Sent</b>
        </div> -->

        

        <div class="col-sm-12 col-md-12">
            <br>
            <button class="form-control button submit"   style="background: #46455B;">Submit</button>
        </div>

        <input type="file" id="image" accept="image/*" style="display: none;">
        <input type="file" id="video" accept="video/*" style="display: none;">

        <div class="col-sm-12 col-md-12" style="margin-top: 50px;">
          <div class="imageMessage" style="color: #F1592A; font-weight: bold;"></div>
        </div>

        <div class="col-sm-12 col-md-12" style="margin-top: 50px;">
          <div class="videoMessage" style="color: #F1592A; font-weight: bold;"></div>
        </div>
    </div>

  </div>

   </form>
</div>



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
      //firebase.analytics();

window.imageUpload = false;
window.videoUpload = false;
window.imageURL = '';
window.videoURL = '';
$(document).ready(function(){ 

    $(document).off('click','.submit').on('click','.submit',function(e){
                e.preventDefault(); 

    $('.loader').removeClass('hidden');
     
        if ($('#image').get(0).files.length === 0) 
        {
           alert('Image is required.');
           $('.loader').addClass('hidden');
        }else if ($('#video').get(0).files.length === 0){
          alert('Video is required.');
          $('.loader').addClass('hidden');
        }

        else{

            ImageUpload();
        }

    });


    $(document).off('change','#notification').on('change','#notification',function(e){

        if ($(this).val() == 'enable') 
        {
            $('.notification-content').removeClass('hidden');
        }else{
            $('.notification-content').addClass('hidden');
        }

    });

});
    

function ImageUpload()
{
    var image= document.getElementById("image").files[0];
    var imageName = image.name;

    var storageImageRef=firebase.storage().ref('images/<?=date('M-Y')?>/'+imageName);
    var uploadImageTask=storageImageRef.put(image);

      uploadImageTask.on('state_changed',function (snapshot) {
          var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
          $('.imageMessage').text('Image Upload '+parseInt(progress)+'%');
      },function (error) {
          $('.imageMessage').text(error.message);
      },function () {
          uploadImageTask.snapshot.ref.getDownloadURL().then(function (downlaodURL) {
              imageURL = downlaodURL;
              window.imageUpload = true;
              VideoUpload();
          });
      });
}

function VideoUpload()
{
    var video=document.getElementById("video").files[0];
    var videoName = video.name;

      var storageVideoRef=firebase.storage().ref('videos/<?=date('M-Y')?>/'+videoName);
      var uploadVideoTask=storageVideoRef.put(video);

      uploadVideoTask.on('state_changed',function (snapshot) {
          var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
          $('.videoMessage').text('Video Upload '+parseInt(progress)+'%');
      },function (error) {
          $('.videoMessage').text(error.message);
      },function () {
          uploadVideoTask.snapshot.ref.getDownloadURL().then(function (downlaodURL) {
              window.videoURL = downlaodURL;
              window.videoUpload = true;

              if (window.imageUpload && window.videoUpload) 
              {
                 store();
              }
          });
      });
}

function store()
{
    $.ajax({
              url: '<?=BASE_URL_ADMIN?>video/firebaseupload/store',
              type:'POST',
              dataType: 'JSON',
              data:{
                category_id:$('#category_id').val(),
                upload_type:'firebase',
                image_thumbnail:window.imageURL,
                video_link:window.videoURL,
                video_type:'1',
                name:$('#name').val(),
                status:1,
                watermark_status:$('#watermark_status').val()
              },
              success: function(response) {
                  if( response.statuscode ) {
                      $('.imageMessage').text('');
                      $('.videoMessage').text(response.message);

                  }else{
                    $('.videoMessage').text(response.message);
                  }

                  $('.loader').addClass('hidden');
              },
              error: function(repsonse){
                  $('.videoMessage').text(response.message);
              }
          }); 
}
</script>
</body>
</html>