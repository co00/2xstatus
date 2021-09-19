<!DOCTYPE html>
<html lang="zxx">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>2x Status</title>

    <link rel="icon" href="<?=STATUS_ASSETS?>img/mini_logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>css/bootstrap.min.css" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/themefy_icon/themify-icons.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/niceselect/css/nice-select.css" />
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/owl_carousel/css/owl.carousel.css" />
    <!-- gijgo css -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/gijgo/gijgo.min.css" />
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/tagsinput/tagsinput.css" />

    <!-- date picker -->
     <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/datepicker/date-picker.css" />

     <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/vectormap-home/vectormap-2.0.2.css" />
     
     <!-- scrollabe  -->
     <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/scroll/scrollable.css" />
    <!-- datatable CSS -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/datatable/css/buttons.dataTables.min.css" />
    <!-- text editor css -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/text_editor/summernote-bs4.css" />
    <!-- morris css -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/morris/morris.css">
    <!-- metarial icon css -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>vendors/material_icon/material-icons.css" />

    <!-- menu css  -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>css/metisMenu.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>css/style.css" />
    <link rel="stylesheet" href="<?=STATUS_ASSETS?>css/colors/default.css" id="colorSkinCSS">


<style type="text/css">
    
    #sidebar_menu .active .nav_title span{
        color:#F65365 !important;
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

.hidden{
    display: none;
}



#snackbar1 {
    /*visibility: hidden; */
    min-width: 250px;
    background-color: #333;
    color: #fff;
    text-align: left;
    border-radius: 2px;
    padding: 16px;
    position: absolute;
    z-index: 1; 
    left: 80%;
    bottom: 80%;
}

#hello {
    /*visibility: hidden; */
    min-width: 250px;
    background-color: #333;
    color: #fff;
    text-align: left;
    border-radius: 2px;
    padding: 16px;
    position: absolute;
    z-index: 1; 
    left: 80%;
}
  

/*.show-bar {
    visibility: visible !important;
    animation: fadein 0.5s, fadeout 0.5s 4.5s;
}*/

  
/* when the Snackbar Appears */
@keyframes fadein {
    from {
        bottom: 0;
        opacity: 0;
    }
    to {
        bottom: 30px;
        opacity: 1;
    }
}
  
/* when the Snackbar Disappears
   from the Screen */
@keyframes fadeout {
    from {
        bottom: 30px;
        opacity: 1;
    }
    to {
        bottom: 0;
        opacity: 0;
    }
}
</style>

</head>
<body class="crm_body_bg">

  <div id="snackbar1">Some text some message..</div>

  <h1 id="hello">Some text some message..</h1>

<div class="loader hidden">
    <div class="loading"></div>
</div>

    <?php $this->load->view(STATUS_VIEW.'sidebar'); ?>

    <section class="main_content dashboard_part large_header_bg">