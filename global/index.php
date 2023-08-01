<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; $uploaded_file="uploaded_file";?>

<html>
<head>
  <title>Site Content</title>
</head>
<body>
  <h2>Site Content</h2>
  <div id='showfiletree'>
  <?php
    echo "Total Size: ".GetConvertedFilesize(GetDirectorySize($GLOBAL_FOLDER))."<br><br>";
    PrintDir($GLOBAL_FOLDER,0,0);
  ?>
    <br>
  </div>
  <h2>DVD of The Day</h2>
  <div id='showfiletree'>
  <?php
    PrintDir($DVD_DIR,0,0);
  ?>
  </div>
</body>
</html>
