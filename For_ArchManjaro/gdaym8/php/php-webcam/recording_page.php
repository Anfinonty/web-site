<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="js-webcam/script.js" defer></script>
</head>
<body>
<!-- For Page Refresh Without Page Reload -->
<iframe name="nfresh" style="display:none;"></iframe>

<video id="myvideo"></video>
<canvas id="mycanvas"></canvas>

<form style="display:none" id="myform" method="post" target="nfresh">
  <input type="submit" name="btnSubmit" id="btnSubmit"/>
  <input name="b64data" id="my64"/>
</form>

<?php
  if (isset($_POST['btnSubmit'])) {
    //copy("hello.txt","hello2.txt");
    file_put_contents("hello.txt",$_POST['b64data']);
  }
?>



</body>
</html>
