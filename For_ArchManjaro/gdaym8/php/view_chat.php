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

      //11-13-2023: old
      //for each file in folder
      /*$files = scandir($GLOBAL_CHAT_DIR, 1);
      foreach ($files as $file) {
	if ($file!="." && $file!="..") {
          echo htmlspecialchars(strval(file_get_contents($GLOBAL_CHAT_DIR."/".$file)))."<br>";
	}
      }*/


      //new
      $files=scandir($GLOBAL_CHAT_DIR,1);
      $_end="<div class=''></div><div class=\"\"></div></source></audio></b></h2></style></form></button></ul></details></img></iframe></span></a></div>";
      foreach ($files as $file) {
	if ($file!="." && $file!="..") {
          $file_text=strval(file_get_contents($GLOBAL_CHAT_DIR."/".$file)) ?? "";
	  $file_text_arr=explode("\n",$file_text);
          $chat_username=$file_text_arr[0];
	  $chat_time=$file_text_arr[1];
          $_chat=str_replace($chat_username,"",$file_text);
	  $_chat=str_replace($chat_time,"",$_chat);
	  $user_folder=$GLOBAL_FOLDER."/".$chat_username;

	  //printing
	  echo "<table class='user_chat_box'><tbody>";
	  if (is_dir($user_folder)) {
	    $_td_start="<tr><td rowspan=2><img class='special_folder_icon' src='/global/".$chat_username."/chat_icon.";
	    $_td_end="'></img></td>";
	    if (file_exists($user_folder."/chat_icon.gif")) {
	      echo $_td_start."gif".$_td_end;
	    } else if (file_exists($user_folder."/chat_icon.apng")) {
	      echo $_td_start."apng".$_td_end;
	    } else if (file_exists($user_folder."/chat_icon.png")) {
	      echo $_td_start."png".$_td_end;
	    } else if (file_exists($user_folder."/chat_icon.jpg")) {
	      echo $_td_start."jpg".$_td_end;
	    } else if (file_exists($user_folder."/chat_icon.jpeg")) {
	      echo $_td_start."jpeg".$_td_end;
	    } else if (file_exists($user_folder."/chat_icon.bmp")) {
	      echo $_td_start."bmp".$_td_end;
	    } else {
              echo "<tr><td rowspan=2><img class='special_folder_icon' src='/images/spider.bmp'></img></td>";
	    }
	    echo "<td><a href='https://gdaym8.site/global/".$chat_username."'>".$chat_username."</a> [".$chat_time."]</td></tr>";
	  } else {
            echo "<tr><td rowspan=2><img class='special_folder_icon' src='/images/spider.bmp'></img></td>";
	    echo "<td>".$chat_username." [".$chat_time."]</td></tr>";
	  }
	    echo "<tr><td class='user_chat_box'>".TheFilter($_chat).$_end."</td></tr>";

	  echo "</tbody></table>";
	}
      }

?>

  <div id="view_chat_footer"></div>
</body>
</html>
