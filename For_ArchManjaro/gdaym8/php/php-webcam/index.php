<html>
<head>
<script>
function update() {
  document.getElementById('myiframe').src="live_webcam.php";
}

setInterval(update,250);
</script>
</head>
<body>
<iframe width="100%" height="100%" id='myiframe'></iframe>
<iframe src="recording_page.php"></iframe>
</body>
</html>
