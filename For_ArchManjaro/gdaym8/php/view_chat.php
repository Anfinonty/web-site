<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";?>

<?php
?>

<!DOCTYPE HTML>
<html>
<head>
<title>View Chat</title>
  <script> 
  </script>
  <link rel="stylesheet" href="<?php echo $_GET['target_folder'];?>/folder_style.css"></link>
</head>
<body> 
  <div id="view_chat_header"></div>

<?php
      //echo htmlspecialchars(strval(file_get_contents($_SERVER['DOCUMENT_ROOT']."/".$CHAT_DIR)));
      //for each file in folder
      $files = scandir($GLOBAL_CHAT_DIR, 1);
      foreach ($files as $file) {
	if ($file!="." && $file!="..") {
          echo htmlspecialchars(strval(file_get_contents($GLOBAL_CHAT_DIR."/".$file)))."<br>";
	}
      }
?>

  <div id="view_chat_footer"></div>
</body>
</html>
