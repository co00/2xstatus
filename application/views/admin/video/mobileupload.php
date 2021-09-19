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
    min-height: 300px;
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
          <div class="videoMessage" style="color: #F1592A; font-weight: bold;"></div>
        </div>

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
            <select class="form-control form-design" id="watermark_status">
              <option value="0">Watermark Disable</option>  
              <option value="1">Watermark Enable</option>  
            </select>
        </div>

        <div class="col-sm-12 col-md-12">
            <br>
            <button class="form-control button" onclick="document.getElementById('video').click();" style="background: #47CF73;"><i class="fa fa-plus-circle" style="font-size: 22px;margin-right: 14px;"></i> Upload Video</button>
        </div>

        <div class="col-sm-12 col-md-12">
            <br>
            <button class="form-control button submit"   style="background: #46455B;">Submit</button>
            <br>
        </div>

        <div class="col-sm-8 col-md-8 col-xs-8">
          <br>
            <video id="main-video" controls style="height: 250px; width: 100%;">
              <source type="video/mp4">
            </video>

            <br><br>
            <button class="btn btn-danger" id="get_thum">Get thum</button>
        </div>

        <div class="col-sm-4 col-md-4 col-xs-4">
          <br>
            <img id="imgThum" style="width: 100%;" />

            <a id="get-thumbnail" href="#" style="display: none;"></a>
        </div>

        

        

        <input type="hidden" id="image" style="display: none;">
        <input type="file" id="video" accept="video/*"  style="display: none;">

        <div class="col-sm-12 col-md-12" style="margin-top: 50px;">
          <div class="imageMessage" style="color: #F1592A; font-weight: bold;"></div>
        </div>

        <canvas id="video-canvas" style="display: none;"></canvas>
    </div>

  </div>

   </form>
</div>


<script>
$(document).ready(function(){ 

var _CANVAS = document.querySelector("#video-canvas"),
  _CTX = _CANVAS.getContext("2d"),
  _VIDEO = document.querySelector("#main-video");

  $(document).off('change','#video').on('change','#video',function(e){

        if(['video/mp4'].indexOf(document.querySelector("#video").files[0].type) == -1) {
            alert('Error : Only MP4 format allowed');
            return;
        }

        document.querySelector("#main-video source").setAttribute('src', URL.createObjectURL(document.querySelector("#video").files[0]));

        _VIDEO.load();

        _VIDEO.addEventListener('loadedmetadata', function() { console.log(_VIDEO.duration);

        _CANVAS.width = _VIDEO.videoWidth;
        _CANVAS.height = _VIDEO.videoHeight;
        });

        _CTX.drawImage(_VIDEO, 0, 0, _VIDEO.videoWidth, _VIDEO.videoHeight);

     // document.querySelector("#imgThum").setAttribute('src', _CANVAS.toDataURL());

     setTimeout(function(){ 
        document.querySelector("#get-thumbnail").click();
      }, 1500);

  });

  document.querySelector("#get-thumbnail").addEventListener('click', function() {
    _CTX.drawImage(_VIDEO, 0, 0, _VIDEO.videoWidth, _VIDEO.videoHeight);

  document.querySelector("#imgThum").setAttribute('src', _CANVAS.toDataURL('image/png'));
  document.querySelector("#image").setAttribute('value', _CANVAS.toDataURL('image/png'));
});


  document.querySelector("#get_thum").addEventListener('click', function() {
    document.querySelector("#get-thumbnail").click();
});

  


      $(document).off('click','.submit').on('click','.submit',function(e){
                  e.preventDefault(); 

        $('.loader').removeClass('hidden');
        $('.videoMessage').text('');

        var form_data = new FormData();
            form_data.append("category_id",$('#category_id').val());
            form_data.append("image_thumbnail",$("#image").val());
            form_data.append("video_link",$("#video").prop("files")[0]);
            form_data.append("video_type",1);
            form_data.append("status",1);
            form_data.append("upload_type",'upload');
            form_data.append("watermark_status",$('#watermark_status').val());

        $.ajax({
                url: '<?=BASE_URL_ADMIN?>video/mobileupload/store',
                type:'POST',
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data:form_data,
                success: function(response) {
                    if(response.statuscode ) {
                        $(".loader").addClass('hidden');
                        $('.videoMessage').text(response.message);
                    }else{
                        $(".loader").addClass('hidden');
                        $('.videoMessage').text(response.message);
                    }
                },
                error: function(repsonse){
                    $(".loader").addClass('hidden');
                    $('.videoMessage').text('Something went wrong.');
                }
            });
       
      });


});
    
</script>
</body>
</html>