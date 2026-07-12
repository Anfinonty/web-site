
<?php //include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";?>
<?php
  //pre requisite stuff
    session_start();
    $SESSION_USERNAME = $_SESSION["username"];
    $SELF_USER_NAME=$SESSION_USERNAME;
    $SELF_USER_FOLDER_NAME=$GLOBAL_FOLDER."/".$SELF_USER_NAME;

    $GLOBAL_FOLDER=$_SERVER['DOCUMENT_ROOT']."/global";
    /**/$GLOBAL_CHAT_DIR=$GLOBAL_FOLDER."/{GlobalChat}";

    function getNormalizedValue($input) {
      if (strlen($input) === 0) {
        return null; // Handle empty string
      }

      $firstChar = substr($input, 0, 1);     // Step 1: Get first character
      $ascii = ord($firstChar);              // Step 2: Convert to ASCII
      $normalized = $ascii % 11;             // Step 3: Normalize to 0–10

      return $normalized;
    }

  //replaces first instance only
    function replace_first_instance($text, $search, $replace) {
      $pos = strpos($text, $search);
      if ($pos !== false) {
        return substr_replace($text, $replace, $pos, strlen($search));
      }
      return $text;
    }
    //
    //
     if (file_exists($SELF_USER_FOLDER_NAME."/style.css")) {
       echo "<link rel='stylesheet' href='/global/".$SELF_USER_NAME."/style.css'>";
     } else {
       echo "<link rel='stylesheet' href='/style/dstyle_".getNormalizedValue($SELF_USER_NAME).".css'>";
     }

  //
  //
  //
  //
  //Read content from file
  $url_filename=$_GET["filename"];
  $realChatPath=realpath($GLOBAL_CHAT_DIR.'/'.$url_filename);
  $realBase=realpath($GLOBAL_CHAT_DIR);

  //echo $realBase."<br>";
  //echo $realChatPath."<br>";
  //check if dir exists if not dont do anything
    if ($realChatPath === false || strpos($realChatPath,$realBase)!=0) {
     //retreat
     echo "Error";
     //$redirect_url="https://".$_SERVER['HTTP_HOST'];
     //header('Location: '.$redirect_url); //go back to home
     //exit;
    } else {

      //Split Name,Time Posted and Posted Message -- only get psoted message
	$file_text=strval(file_get_contents($GLOBAL_CHAT_DIR."/".$url_filename)) ?? "";
        $file_text_arr=explode("\n",$file_text);

      //segregate username, pfp and time posted from chat_dialogue
        $chat_username=$file_text_arr[0]."\n";
        $chat_time=$file_text_arr[1]."\n";
       // $_chat=str_replace($chat_username,"",$file_text);
       // $_chat=str_replace($chat_time,"",$_chat);
        $_chat = replace_first_instance($file_text,$chat_username,"");
        $_chat = replace_first_instance($_chat,$chat_time,"");
        //$_chat = replace_first_instance($_chat,"\n","");
       //$user_folder=$GLOBAL_FOLDER."/".$chat_username;


        //$_chat = $file_text;
        //echo as html haha
        echo "<div class='user_chat_box_dialogue'>".$_chat."</div>";
    }
?>
