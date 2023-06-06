<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<html>
<head>
  <!--<title>G'day M8! Welcome To My Web-site :D</title>-->
  <title>G'day M8! :D</title>
  <script src="/script/myScript_view_oldchat.js"></script>
  <style>
    #chathere {
      border:2px solid;
      overflow-y: auto;
      max-height: 480px;
    }
  </style>
</head>

<body>
  <div id="default_chatroom_greet">
  <h1>G'day M8!</h1>
    Hello World! Welcome to the http://gdaym8.site web-site chat-archive! :D<br> 
    <br>Below is the history of embeddings and injection attempts for educational purposes! <br>
  </div>

  <iframe name="nfresh" style="display:none;"></iframe>
  <span id="chatbox_actions">
    <button onclick="ViewOrder(0,1,flip,document.getElementById('txthere').textContent,0)">Flip</button>
  </span>

  <form method="post" id="form1" name="form1" target="nfresh">
    <br>
    <textarea onfocus="TxtHereOnFocus()" onblur="TxtHereOnBlur()" id="txthere" name="txthere" rows="4" cols="80" value="" maxlength="9001"></textarea>
  </form>
  <div style='display:inline;margin:0;' id='timeUTC'></div>
  <div id='chathere' height:400px;>
    <?php
      echo htmlspecialchars(strval(file_get_contents($_SERVER['DOCUMENT_ROOT']."/"."oldchat/totalchat.txt")));
//      echo htmlspecialchars(strval(file_get_contents($_SERVER['DOCUMENT_ROOT']."/".$CHAT_DIR)));
    ?>
  </div>
</body>
</html>
