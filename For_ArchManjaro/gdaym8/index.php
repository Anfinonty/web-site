<?php 
  /*($date = date('m/d/Y h:i:s a', time());

  echo "Gday m8!! This website is powered by apache, docker and php!! :DD<br>";
  echo "Did you enjoy the Pendulum concert? I sure did!! XDDD<br>";
  echo "The time now is: {$date}";*/

include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; DrawNavBar(); ?>
<html>
<!-- Head -->
<head>
  <!--<title>G'day Again M8! Welcome To My Web-site :D</title>-->
  <!--<title>G'day M8! Welcome To My Web-site :D</title>-->
  <!--<title>G'day Again M8! :D</title>-->
  <title>G'day M8! :D</title>
  <script src="script/myScript.js"></script>
  <style>
    #chathere {
      border:2px solid;
      word-wrap: break-word;
      overflow-x: auto;
      max-width: 100%;
      /*overflow-y: auto;
      max-height: 480px;*/
    }
  </style>
</head>




<!-- Body -->
<body>
  <!-- Touchscreen Buttons For Movement of Live Peerrs Avatar -->
  <div id="axis_click_buttons" hidden="">
  <form method="post" target="nfresh" style="display:inline;">
    <?php       
      /*for ($y=0;$y<$GR_HEIGHT;$y+=$CURSOR_GAP) {
        for ($x=0;$x<$GR_WIDTH;$x+=$CURSOR_GAP) {
          $name='btnAxisClick'."_x".$x."_y".$y;
          echo '<input type="submit" id='.$name,' name='.$name.' value="." onmouseover="afk_timer=0;this.click();">';
        }
      }*/
    ?>
  </form>
  </div>



  <!-- Webpage @ Greeting -->
  <div id="default_chatroom_greet">
  <!--<h1 id="header">G'day Again M8!</h1>-->
  <h1 id="header">G'day M8!</h1>

    <?php
//      echo "Hello World! Welcome to ".$SERVER_IP_ADDRESS."! <br>";
// Hello Changes

//Hello World! Welcome to the http://gdaym8.site:591 web-site! :D<br> 
    ?>
    Hello World! Welcome to the http://gdaym8.site web-site! :D<br> 
    <br>Say Something or Hear from Other Peers! <br>
  </div>



  <!-- For Page Refresh Without Page Reload -->
  <iframe name="nfresh" style="display:none;"></iframe>


  <!-- for live peers -->
  <div id="users_onscreen" hidden></div>



  <!-- Buttons For Actions Update Chat, Flip Chat, Live Chat and Live Peers -->
  <span id="chatbox_actions">
    <!--<button onclick="UpdateChat(1,0)">Hear</button>-->
    <button onclick="document.getElementById('chathere').contentWindow.location.reload()">Hear</button>
    <!--<button onclick="ViewOrder(0,1,flip,document.getElementById('txthere').textContent,0)">Flip</button>-->
    <!--<button id="live_chat_btn" onclick="LiveChatButton(this)">ON Live Chat (HIGH DATA USAGE)</button>-->
    <!--<button id="live_peers_btn" onclick="LivePeersButton(this)">ON Peers (HIGH DATA USAGE)</button>-->
    <button id="cleartxt" onclick="ClearTxtButton()">Clear</button>
  </span>



  <!-- OnScreen Buttons For Peers Avata Movement -->
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
  <?php //echo "<a href='#footer'>Dive Down</a><br>"; ?>

  <?php
    //test
    //echo "test file write";
    //$fp=fopen($GLOBAL_CHAT_DIR."/".time().".txt","a"); //open in write mode
    //fwrite($fp, "hello world");
    //fclose($fp);


    //Posting
    if (isset($_POST['btnSubmit'])){
      //user credentials
      $date_time_now=gmdate("Y/m/d H:i:s");
      $user_post_msg=$_POST["txthere"];
      //$enter="\n";
      //$user_post_msg=preg_replace("/{$enter}/i","<br>",$user_post_msg);
      //$user_post_msg=str_replace("#e#","<br>",$user_post_msg);    
      $user_post_msg=ChatShortcuts($user_post_msg);

      //$txt_user_ip_address=GetUsernameFromIpAddress($USER_IP_ADDRESS);
      //if (file_exists($SELF_USER_FOLDER_NAME)) {
	//$txt_user_ip_address="/".GetUsernameFromIpAddress($USER_IP_ADDRESS);
      //}

      $user_msg="[$date_time_now][$SELF_USER_NAME] $user_post_msg \r";//ensures no incomplete html overflow

      if (strlen($user_post_msg)>0) {//not blank
        //$fp=fopen($CHAT_DIR,"a"); //open in append mode
        $fp=fopen($GLOBAL_CHAT_DIR."/".time().".txt","a"); //open in write mode
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
  <div>
  <iframe id='chathere' height=400px width=100% sandbox='allow-scripts allow-same-origin' src='/php/view_chat.php'>
  </iframe>
  </div>
  
  <!--<div id="footer"><a href="#default_server_header">Back to Top</a></div> -->


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
        if (isset($_POST['btnXPlus']) && $p_x<$GR_WIDTH) {$p_x=$p_x+"32";}
        if (isset($_POST['btnXMinus']) && $p_x>0) {$p_x=$p_x-"32";}
        if (isset($_POST['btnYMinus']) && $p_y>0) {$p_y=$p_y-"32";}
        if (isset($_POST['btnYPlus']) && $p_y<$GR_HEIGHT) {$p_y=$p_y+"32";}

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



//Cursor!! (Legacy)
  /*for ($y=0;$y<$GR_HEIGHT;$y+=$CURSOR_GAP) {
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
  }*/
  ?>

</body>
</html>

