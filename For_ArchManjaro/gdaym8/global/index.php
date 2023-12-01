<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; $uploaded_file="uploaded_file"; DrawNavBar(); ?>

<html>
<head>
  <title>Site Content</title>
</head>
<body>
  <h2>Site Content</h2>
  <div id='showfiletree'>
  <?php
    echo "<a href='/php/show_oldchat_index.php'> View Archived Chat </a> ".$S;
    echo "<a href='/php/view_chat.php'> View Current Chat File </a> ".$S;
    echo "<a href='/oldchat/totalchat.txt'> View Archived Chat File </a> ".$S;
    echo "<br>Total Size: ".GetConvertedFilesize(GetDirectorySize($GLOBAL_FOLDER))."<br><br>";
    PrintDir($GLOBAL_FOLDER,0,0);
  ?>
  </div>
  <h2>DVD of The Day</h2>
  <div id='showfiletree'>
  <?php
    PrintDir($DVD_DIR,0,0);
  ?>
  </div>
  <?php
    /*for ($i=0;$i<36;$i++) {
      echo "<br>";
    }*/
  ?>

  <br>Trust Other DVD Slots: <a href="http://w1.gdaym8.site">[1]</a>
  <div id='showfiletree'>
    <iframe width="100%" height="100%" src="https://gdaym8.site:592/php/view_folder.php?target_folder=/dvd">
  </div>
</body>
</html>
