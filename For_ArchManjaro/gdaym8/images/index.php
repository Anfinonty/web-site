
<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; DrawNavBar(); ?>

<html>
<head>
  <title>images backrooms</title>
</head>
<body class="main_body">
<div class="main_body_background"></div>
  <h2>Images</h2>
  <div id='showfiletree'>
  <?php
    PrintDir($_SERVER['DOCUMENT_ROOT']."/images",0,0);
  ?>
  </div>
</body>
</html>
