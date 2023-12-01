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
  <script src="script/globalChatScript.js"></script>
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
  <script>
    function ScrollDown() {
      var a=new Audio("/audio/paper_flip.mp3");
      var e =  document.getElementById('chathere');
      var e_height = parseInt(e.height.replace("%",""));
      e.height="".concat((e_height+35),"%");
      a.play()
      scrollTo(0,10000000);
    }

    function ScrollUp() {
      var a=new Audio("/audio/paper_flip_reverse.mp3");
      var e =  document.getElementById('chathere');
      var e_height = parseInt(e.height.replace("%",""));
      if (e_height>69) {
        e.height="".concat((e_height-35),"%");
        a.play()
      }
      scrollTo(0,10000000);
    }

    function TraverseChat(down) {
      const txt = "https://gdaym8.site/php/view_chat.php";
      e = document.getElementById("chathere");
      var a=new Audio("/audio/page-down-whoosh.mp3");
      var a2=new Audio("/audio/page-up-whoosh.mp3");

      if (down) {
        scrollTo(0,10000000);
        e.src = txt.concat('#view_chat_footer');
        a.play();
      } else {
        scrollTo(0,0);
        e.src = txt.concat('#view_chat_header');
        a2.play();
      }
    }
  </script>
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
  </span>



  <!-- OnScreen Buttons For Peers Avata Movement -->
  <form method="post" id="formaxis" name="formaxis" target="nfresh" style="display:inline;">
    <input hidden type="submit" id="btnXMinus" name="btnXMinus" onmouseover="afk_timer=0;this.click();" value="<">
    <input hidden type="submit" id="btnYMinus" name="btnYMinus" onmouseover="afk_timer=0;this.click();" value="^">
    <input hidden type="submit" id="btnYPlus" name="btnYPlus" onmouseover="afk_timer=0;this.click();" value="V">
    <input hidden type="submit" id="btnXPlus" name="btnXPlus" onmouseover="afk_timer=0;this.click();" value=">">
  </form>

  <iframe height=15% width=100% src='/php/post_message_form.php'></iframe>
  <!--<a href='#footer'>Dive Down</a><br>-->
  <button onclick='TraverseChat(0)'>↖</button>
  <button onclick='TraverseChat(1)'>↓</button>
  <button onclick='ScrollDown()'>+</button>
  <button onclick='ScrollUp()'>-</button>

  <br>
  <div style='display:inline;margin:0;' id='timeUTC'></div>
  <div>
  <iframe id='chathere' height=55% width=100% sandbox='allow-scripts allow-same-origin' src='/php/view_chat.php'>
  </iframe>
  </div>

  <button onclick='TraverseChat(1)'>↓</button>
  <button onclick='TraverseChat(0)'>↖</button>

  <button onclick='ScrollDown()'>+</button>
  <button onclick='ScrollUp()'>-</button>

  <div id="footer" hidden><div>
  <!--<div id="footer"><a href="#default_server_header">Back to Top</a></div> -->

</body>
</html>

