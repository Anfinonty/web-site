<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";?>

<?php
?>

<!DOCTYPE HTML>
<html>
<head>
<title>View Chat</title>
  <script>
    function resizeIframe(iframe) {
      const iframeDoc = iframe.contentWindow.document;
/*
  // Ensure content isn't adding padding/margin
      iframeDoc.body.style.margin = '0';
      iframeDoc.body.style.padding = '0';

  // Get the height of one line
      const lineHeight = parseFloat(getComputedStyle(iframeDoc.body).lineHeight) || 20;

  // Apply it to the iframe
      iframe.style.height = `${lineHeight}px`;
      iframe.style.width = '100%';
*/
      iframe.style.height = (iframeDoc.body.scrollHeight)+ 'px';
      iframe.style.width = 100 + '%';

      //append default style
      //const styleTag = iframeDoc.createElement('style');
      //styleTag.innerHTML = "* {color: white;white-space:pre-wrap;margin:0;padding:0;line-height:1;}";
      //iframeDoc.head.appendChild(styleTag);
    }
  </script>
  <!--<link rel="stylesheet" href="<?php echo $_GET['target_folder'];?>/folder_style.css"></link>-->
</head>
<body id="view_chat">
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

          //segregate username, pfp and time posted from chat_dialogue
          $chat_username=$file_text_arr[0];
	  $chat_time=$file_text_arr[1];
          $_chat=str_replace($chat_username,"",$file_text);
	  $_chat=str_replace($chat_time,"",$_chat);
	  $user_folder=$GLOBAL_FOLDER."/".$chat_username;

	  //printing
	  echo "<table class='user_chat_box'><tbody>";
	  if (is_dir($user_folder)) {
           //Draw folder icon image
            for ($z=0;$z<7;$z++) {
              if ($z<6) {
                $chat_icon_ext="";
                switch ($z) {
                  case 0;
                    $chat_icon_ext="gif";
                    break;
                  case 1;
                    $chat_icon_ext="apng";
                    break;
                  case 2;
                    $chat_icon_ext="png";
                    break;
                  case 3;
                    $chat_icon_ext="jpg";
                    break;
                  case 4;
                    $chat_icon_ext="jpeg";
                    break;
                  case 5;
                    $chat_icon_ext="bmp";
                    break;
                }
                if (file_exists($user_folder."/chat_icon.".$chat_icon_ext)) {
                  if (filesize($user_folder."/chat_icon.".$chat_icon_ext)<1000000) { //allow if below 1mb 
		    $_td_start="<tr><td rowspan=2><img class='special_folder_icon' src='/global/".$chat_username."/chat_icon.";
            	    $_td_end="'></img></td>";
		    echo $_td_start.$chat_icon_ext.$_td_end;
                    break;
                  }
                }
              } else { //default icon
                echo "<tr><td rowspan=2><img class='special_folder_icon' src='/images/spider.bmp'></img></td>";
              }
            }
	    echo "<td><a href='https://spiderspeed.site/global/".$chat_username."'>".$chat_username."</a> [".$chat_time."]</td></tr>";
	  } else {
            echo "<tr><td rowspan=2><img class='special_folder_icon' src='/images/spider.bmp'></img></td>";
	    echo "<td>".$chat_username." [".$chat_time."]</td></tr>";
	  }
	  //echo "<tr><td class='user_chat_box'><pre class='user_chat_box_dialogue'>".TheFilter($_chat).$_end."</pre></td></tr>";
          echo "<tr><td class='user_chat_box'><iframe class='user_chat_box_dialogue'  onload='resizeIframe(this)' frameBorder='0' src='https://spiderspeed.site/php/view_one_chat.php?filename=".$file."'></iframe></td></tr>";
          //echo "<tr><td class='user_chat_box'><iframe class='user_chat_box_dialogue' src='https://spiderspeed.site/global/{GlobalChat}/".$file."'></iframe></td></tr>";
	  echo "</tbody></table>";
	}
      }

?>

  <?php
  //overrides global style injections, unsure if it works in old browsers
  if (file_exists($SELF_USER_FOLDER_NAME."/style.css")) {
    echo "<link rel='stylesheet' href='/global/".$SELF_USER_NAME."/style.css'>";
  } else {
    echo "<link rel='stylesheet' href='/style/dstyle_".getNormalizedValue($SELF_USER_NAME).".css'>";
  }
  ?>


  <div id="view_chat_footer"></div>
</body>
</html>
