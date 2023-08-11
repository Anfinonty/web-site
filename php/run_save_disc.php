<?php  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; 
  if (!file_exists($SELF_USER_FOLDER_NAME)) { //no username
    $redirect_url="https://".$_SERVER['HTTP_HOST'];
    header('Location: '.$redirect_url); //go back to home
  }

  //Recharge Session
  $user_details=htmlspecialchars(strval(file_get_contents($SELF_USER_SESSION)));
  $user_details_arr=explode(",",$user_details);

  $user_x=$user_details_arr[0];
  $user_y=$user_details_arr[1];
  $time_expire=time()+"1800"; //30 minutes
  $user_name=$user_details_arr[3];

  $fp=fopen($SELF_USER_SESSION,"w");
  fwrite($fp,$user_x.",".$user_y.",".$time_expire.",".$user_name);
  fclose($fp);
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
<?php 
  $file_download_href=$user_name."/WEB_SITE_DISC_".$user_name.".zip";     
  if (!file_exists($SAVED_DISCS_DIR."/".$file_download_href)) {
    echo "<h1 id='exists'> Disc is being Copied... </h1><p>(refresh if loading below didn't load)</p>";
    $copying_size=GetConvertedFilesize(GetDirectorySize($USER_SAVED_DISCS_DIR));
    $source_size=GetConvertedFilesize(GetDirectorySize($SELF_USER_FOLDER_NAME));
    echo "{$copying_size} / {$source_size}";
  } else {
    echo "<h1 id> Disc has been Copied Successfully </h1>";
    echo "<a href='/global/{SavedDiscs}/".$file_download_href."'> Download </a>";
  }
?>
  <br><br>
  <p>You can leave and return to this page later.</p>
  <script>
    LiveReload=function() {
      location.reload();
    }

    if (document.getElementById("exists")!==null) {
      setInterval(LiveReload,5000);
    }
  </script>
</body>
</html>


