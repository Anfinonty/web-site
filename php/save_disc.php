
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; 
?>
<?php
  //Recharge Session
  $user_details=htmlspecialchars(strval(file_get_contents($SELF_USER_SESSION)));
  $user_details_arr=explode(",",$user_details);

  $user_x=$user_details_arr[0];
  $user_y=$user_details_arr[1];
  $time_expire=time()+"1800"; //30 minutes
  $user_name=$user_details_arr[3];
?>

<!DOCTYPE HTML>
<html>
<head>
  <title>Saving Disc Page</title>
  <style>
  body {
    text-align: center;
  }
  </style>
</head>
<body>
<a href="run_save_disc.php"><h1>Click To Save</h1></a>
<h2>DO NOT LEAVE OR ENTER THE WEB SITE FROM A NEW TAB OR BROWSER UNTIL SAVING BEGINS</h2>
</body>
</html>
