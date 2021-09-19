<html>
<head>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>


var fallbackToStore = function() {
  window.location.replace('https://play.google.com/store/apps/details?id=com.studio.fullscreen.videostatus.hindistatus');
};
var openApp = function() {
  window.location.replace('intent://app/2xstatus.000webhostapp.com/');
};
var triggerAppOpen = function() {
  openApp();
  setTimeout(fallbackToStore, 700);
};

triggerAppOpen();

</script>
</head>
<body>

</body>

</html>