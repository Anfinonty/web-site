<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>
<?php
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
?>

<!DOCTYPE HTML>
<html>
<head>
  <script>
    function GoToRunSaveDisc() {
      location.href="run_save_disc.php";
    }
  </script>
  <title>Saving Disc Page</title>
  <style>
  body {
    text-align: center;
  }
  </style>
</head>
<body>

  <!-- For Page Refresh Without Page Reload -->
  <iframe name="nfresh" style="display:none;"></iframe>


  <?php
  $file_download_href=$user_name."/WEB_SITE_DISC_".$user_name.".zip";     
  $file_exists=false;
  $default_btn_msg="Click To Save";
  if (file_exists($SAVED_DISCS_DIR."/".$file_download_href)) {
    $file_exists=true;
  }

  if(!$file_exists) {
    echo "<h1>Begin Copying...</h1>";
  } else {
    echo "<h1>Current Disc Already Copied. Are you sure you want to Re-Copy?</h1> <h2>Current Unsaved Disc will be Deleted.</h2>";
    $default_btn_msg="Yes";
  }
  ?>
    <form method="post" style='display:inline;' id="form1" name="form1" target="nfresh">
    <?php 
        echo "<input type='submit' id='btnSubmit' name='btnSubmit' value='".$default_btn_msg."' style='font-size:32px;' onclick=GoToRunSaveDisc()>"; 
    ?>
    </form>



  <?php
  if (!$file_exists) {
    echo "<script>document.getElementById('btnSubmit').click();</script>";
  } else {
    echo "{$S}{$S}{$S}{$S}<button style='font-size:32px;' onclick=GoToRunSaveDisc()>No</button>";
  }
  ?>


</body>
</html>


<?php
  //Save Folder To Zip https://www.geeksforgeeks.org/how-to-zip-a-directory-in-php/
  //https://www.php.net/manual/en/ziparchive.addemptydir.php
  function ZipFolder($pathdir,$current_folder,$zip) {
    $_pathdir=$pathdir."/".$current_folder; //outside of zip
    $_pathdir=preg_replace('/\/+/i','/',$_pathdir); //change 2+ slashes into 1 slash
    $current_folder=preg_replace('/\/+/i','/',$current_folder);
    $dir=opendir($_pathdir);
    while ($_file = readdir($dir)) {
      if (is_file($_pathdir."/".$_file)) {
        //$saved_file_name=preg_replace("/\//i",">",$current_folder).">".$_file; //legacy
        $saved_file_name=$_file;
        $zip -> addFile($_pathdir."/".$_file, $current_folder."/".$saved_file_name);
      } else if (is_dir($_pathdir."/".$_file)) {
        if ($_file!="." && $_file!="..") {
          $new_folder=$current_folder."/".$_file;
          $zip -> addEmptyDir($new_folder);
          ZipFolder($pathdir,$new_folder,$zip);
        }
      }
    }
  }

  //Recharge Session
  if (isset($_POST['btnSubmit'])){

    $user_details=htmlspecialchars(strval(file_get_contents($SELF_USER_SESSION)));
    $user_details_arr=explode(",",$user_details);

    $user_x=$user_details_arr[0];
    $user_y=$user_details_arr[1];
    $time_expire=time()+"1800"; //30 minutes
    $user_name=$user_details_arr[3];

    $fp=fopen($SELF_USER_SESSION,"w");
    fwrite($fp,$user_x.",".$user_y.",".$time_expire.",".$user_name);
    fclose($fp);

  //delete past save and make a new one
    PrintDir($USER_SAVED_DISCS_DIR,-1,0);

    mkdir($USER_SAVED_DISCS_DIR,0777,true);
    $pathdir = $SELF_USER_FOLDER_NAME."/"; //outside of zip
    $zipcreated = $USER_SAVED_DISCS_DIR."/WEB_SITE_DISC_".$SELF_USER_NAME.".zip";
    $zip = new ZipArchive;
    if(GetDirectorySize($USER_SAVED_DISCS_DIR)==0 && $zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
      //$redirect_url="/global/{SavedDiscs}/".$user_name."/WEB_SITE_DISC_".$user_name.".zip";
      //$redirect_url="run_save_disc.php";
      //header('Location: '.$redirect_url);
      ZipFolder($pathdir,"",$zip);
      $zip ->close();
    } else {
      $redirect_url="/php/save_disc.php";
      header('Location: '.$redirect_url); //go back to home
    }
  }
?>


