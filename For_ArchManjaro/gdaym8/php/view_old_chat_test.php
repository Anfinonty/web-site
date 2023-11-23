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
      echo "Old Chat: <br><br>";
      //new
      //$files=scandir("../oldchat/totalchat.txt",1);
       $file_text=strval(file_get_contents("../oldchat/totalchat.txt"));
       echo TheFilter($file_text);

?>

  <div id="view_chat_footer"></div>
</body>
</html>
