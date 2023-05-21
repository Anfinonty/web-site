<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<html>
<head>
  <!--<title>G'day M8! Welcome To My Web-site :D</title>-->
  <title>G'day M8! :D</title>
  <script src="script/myScript.js"></script>
  <style>
    #chathere {
      border:2px solid;
      overflow-y: auto;
      max-height: 480px;
    }
  </style>
</head>

<body>
  <div id="axis_click_buttons" hidden="">
  <form method="post" target="nfresh" style="display:inline;">
    <?php 
      for ($y=0;$y<$GR_HEIGHT;$y+=$CURSOR_GAP) {
        for ($x=0;$x<$GR_WIDTH;$x+=$CURSOR_GAP) {
          $name='btnAxisClick'."_x".$x."_y".$y;
          echo '<input type="submit" id='.$name,' name='.$name.' value="." onmouseover="afk_timer=0;this.click();">';
        }
      }
    ?>
  </form>
  </div>

  <div id="default_chatroom_greet">
  <h1>G'day M8!</h1>
    <?php
//      echo "Hello World! Welcome to ".$SERVER_IP_ADDRESS."! <br>";
    ?>
    Hello World! Welcome to the http://gdaym8.site web-site! :D<br> 
    <br>Say Something or Hear from Other Peers! <br>
  </div>

  <iframe name="nfresh" style="display:none;"></iframe>
  <div id="users_onscreen" hidden></div>
  <span id="chatbox_actions">
    <button onclick="UpdateChat(1,0)">Hear</button>
    <button onclick="ViewOrder(0,1,flip,document.getElementById('txthere').textContent,0)">Flip</button>
    <button id="live_chat_btn" onclick="LiveChatButton(this)">ON Live Chat (HIGH DATA USAGE)</button>
    <button id="live_peers_btn" onclick="LivePeersButton(this)">ON Peers (HIGH DATA USAGE)</button>
    <button id="cleartxt" onclick="ClearTxtButton()">Clear</button>
  </span>

  <form method="post" id="formaxis" name="formaxis" target="nfresh" style="display:inline;">
    <input hidden type="submit" id="btnXMinus" name="btnXMinus" onmouseover="afk_timer=0;this.click();" value="<">
    <input hidden type="submit" id="btnYMinus" name="btnYMinus" onmouseover="afk_timer=0;this.click();" value="^">
    <input hidden type="submit" id="btnYPlus" name="btnYPlus" onmouseover="afk_timer=0;this.click();" value="V">
    <input hidden type="submit" id="btnXPlus" name="btnXPlus" onmouseover="afk_timer=0;this.click();" value=">">
  </form>

  <form method="post" id="form1" name="form1" target="nfresh">
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Say Something" onclick="SubmitMsg(this)"><br>
    <textarea onfocus="TxtHereOnFocus()" onblur="TxtHereOnBlur()" id="txthere" name="txthere" rows="4" cols="80" value="" maxlength="9001"></textarea>
  </form>
  <?php
    //Posting
    if (isset($_POST['btnSubmit'])){
      //user credentials
      $date_time_now=gmdate("Y/m/d H:i:s");
      $user_post_msg=$_POST["txthere"];
      $enter="\n";
      $user_post_msg=preg_replace("/{$enter}/i","<br>",$user_post_msg);
      $user_post_msg=str_replace("#e#","<br>",$user_post_msg);    
      $user_post_msg=ChatShortcuts($user_post_msg);

      $txt_user_ip_address=GetUsernameFromIpAddress($USER_IP_ADDRESS);
      if (file_exists($SELF_USER_FOLDER_NAME)) {$txt_user_ip_address="/".GetUsernameFromIpAddress($USER_IP_ADDRESS);}
      $user_msg="[$date_time_now][$txt_user_ip_address] $user_post_msg #e#\n";//ensures no incomplete html overflow

      if (strlen($user_post_msg)>0) {//not blank
        $fp=fopen($CHAT_DIR,"a"); //open in append mode
        if  (fwrite($fp, $user_msg)) {
          echo "Posted!";
        } else {
          echo "Post Unsuccessful :(";
        }
        clearstatcache();
        fclose($fp);
      }
    }
//
//
  ?>
  <div style='display:inline;margin:0;' id='timeUTC'></div>
  <div id='chathere' height:400px;>
    <?php
      echo htmlspecialchars(strval(file_get_contents($_SERVER['DOCUMENT_ROOT']."/".$CHAT_DIR)));
    ?>
  </div>
  <?php
//AXIS MOVEMENT
    if (isset($_POST['btnXPlus']) || 
        isset($_POST['btnYPlus']) || 
        isset($_POST['btnXMinus']) || 
        isset($_POST['btnYMinus'])
       ){
      if (file_exists($SELF_USER_SESSION)) {
        $axis=htmlspecialchars(strval(file_get_contents($SELF_USER_SESSION)));
        $axis_arr=explode(",",$axis);
        $p_x=$axis_arr[0];
        $p_y=$axis_arr[1];
        $time_expire=$axis_arr[2];
        $p_name=GetUsernameFromIpAddress($USER_IP_ADDRESS);
        if (isset($_POST['btnXPlus']) && $p_x<$GR_WIDTH) {$p_x=$p_x+"10";}
        if (isset($_POST['btnXMinus']) && $p_x>0) {$p_x=$p_x-"10";}
        if (isset($_POST['btnYMinus']) && $p_y>0) {$p_y=$p_y-"10";}
        if (isset($_POST['btnYPlus']) && $p_y<$GR_HEIGHT) {$p_y=$p_y+"10";}
        //Write to own file
        $fp=fopen($SELF_USER_SESSION,"w");
        fwrite($fp, $p_x.",".$p_y.",".$time_expire.",".$p_name);
        clearstatcache();
        fclose($fp);
      } else {
        $fp=fopen($SELF_USER_SESSION,"w");
        fwrite($fp, "0,0,".$time_expire.",".$p_name);
        clearstatcache();
        fclose($fp);
      }
    }
//Cursor!!
  for ($y=0;$y<$GR_HEIGHT;$y+=$CURSOR_GAP) {
    for ($x=0;$x<$GR_WIDTH;$x+=$CURSOR_GAP) {
      if (isset($_POST['btnAxisClick'.'_x'.$x.'_y'.$y])) {
        $axis=htmlspecialchars(strval(file_get_contents($SELF_USER_SESSION)));
        $axis_arr=explode(",",$axis);
        $time_expire=$axis_arr[2];
        $p_name=GetUsernameFromIpAddress($USER_IP_ADDRESS);
        if (file_exists($SELF_USER_SESSION)) {
          $fp=fopen($SELF_USER_SESSION,"w");
          fwrite($fp, $x.",".$y.",".$time_expire.",".$p_name);
          clearstatcache();
          fclose($fp);
        } else {
          $fp=fopen($SELF_USER_SESSION,"w");
          fwrite($fp, "0,0,".$time_expire.",".$p_name);
          clearstatcache();
          fclose($fp);
        }
      }
    }
  }
  ?>
</body>
</html>
