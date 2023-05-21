<?php
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; 

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

  //Save Folder To Zip https://www.geeksforgeeks.org/how-to-zip-a-directory-in-php/
  //https://www.php.net/manual/en/ziparchive.addemptydir.php

  function ZipFolder($pathdir,$current_folder,$zip) {
    $_pathdir=$pathdir."/".$current_folder;
    $_pathdir=preg_replace('/\/+/i','/',$_pathdir);
    $current_folder=preg_replace('/\/+/i','/',$current_folder);
    $dir=opendir($_pathdir);
    while ($_file = readdir($dir)) {
      if (is_file($_pathdir."/".$_file)) {
        $saved_file_name=preg_replace("/\//i",">",$current_folder).">".$_file;
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

  $pathdir = $SELF_USER_FOLDER_NAME."/";
  $zipcreated = $GLOBAL_FOLDER."/WEB_SITE_DISC_".$user_name.".zip";
  $zip = new ZipArchive;
  if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
    ZipFolder($pathdir,"",$zip);
    $zip ->close();
    $redirect_url="http://".$_SERVER['HTTP_HOST']."/global/"."WEB_SITE_DISC_".$user_name.".zip";
    header('Location: '.$redirect_url);
  } else {
    $redirect_url="http://".$_SERVER['HTTP_HOST']."/php/save_disc.php";
    header('Location: '.$redirect_url); //go back to home
  }
?>
