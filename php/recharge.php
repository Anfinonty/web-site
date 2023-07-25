<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";?>
<?php
  $user_details=htmlspecialchars(strval(file_get_contents($SELF_USER_SESSION)));
  $user_details_arr=explode(",",$user_details);

  $user_x=$user_details_arr[0];
  $user_y=$user_details_arr[1];
  $time_expire=time()+"1800"; //30 minutes
  //$time_expire=time()+"180000"; //3000 minutes
  $user_name=$user_details_arr[3];

  $fp=fopen($SELF_USER_SESSION,"w");
  fwrite($fp,$user_x.",".$user_y.",".$time_expire.",".$user_name);
  fclose($fp);

  $redirect_url="http://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
  header('Location: '.$redirect_url); //go back to home
?>

