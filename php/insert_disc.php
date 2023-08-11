<?php 
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; 
  if (file_exists($SELF_USER_FOLDER_NAME)) {//User is logged in
    $redirect_url="http://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
    header('Location: '.$redirect_url); //go back to home
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>&nbsp</title>
  <script>
    if ( window.history.replaceState ) { //prevent refresh n submit
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
</head>
<body>
  <form method="post" enctype="multipart/form-data">
    <h2>Insert Disc (Page is not in use)</h2>
    <input type="submit" id="btnRegSubmit" name="btnRegSubmit" value="[^]">
    <input id="inputUsername" name="inputUsername" placeholder="Enter Your Name">&nbsp<input type="file" name="files[]" id="files" multiple directory="" webkitdirectory="" moxkitdirectory="">
  </form>
  <br>
  <div style='font-style:italic;'>
    Disc must be ≤1GB and have no .php files.
  </div>

  <?php /*
    //Posting
    if (isset($_POST['btnRegSubmit'])){
      //user credentials
      $user_name=$_POST["inputUsername"];
      $error=0;

      //Usernames
      $existing_users_arr=scandir($GLOBAL_FOLDER);
      if (!in_array($user_name,$existing_users_arr)) {
        if (0<strlen($user_name) && strlen($user_name)<17) {
          echo "<p style='color:green'>username has valid length</p>";
          $regex_valid_username="/^[A-Za-z0-9_]{1,}$/";
          if (preg_match($regex_valid_username,$user_name)) {
            echo "<p style='color:green'>username is valid</p>";
          } else {
            echo "<p style='color:red'>username must be alphanumeric, and could contain underscores ('_')</p>";
            $error=1;
          }
        } else {
          echo "<p style='color:red'>username must be 1-16 characters long</p>";
          $error=1;
        }
      } else {
        echo "<p style='color:red'>username already exists</p>";
        $error=1;
      }

      $extensions= array("php");

      //action
      if (!$error) {
      //Create User Folder
        mkdir($GLOBAL_FOLDER."/".$user_name,0755,true);
      //Folder upload
       $total_size=0;
        $total_folder_num=0;
        foreach($_FILES['files']['name'] as $i => $name) {
          $file_ext=strtolower(end(explode('.',$_FILES['files']['name'][$i]))); //lwrcase
          $file_size=$_FILES['files']['size'][$i];
          if ($total_size+$file_size<$MAX_STORAGE) { //Sizecheck
            if(in_array($file_ext,$extensions)===false) { //Allow non php extension
              $folders_array=explode(">",$_FILES['files']['name'][$i]);//Check for folder ">", make array of folder names
              $sizeof_folder_arr=sizeof($folders_array)-1;
              $_f = $GLOBAL_FOLDER."/".$user_name."/";
              if ($total_folder_num<$USER_MAX_FOLDER_NUM) { //if folders not maxxed out
                for ($j=0;$j<$sizeof_folder_arr;$j++) {//for each foldername in array                
                  if ($total_folder_num<$USER_MAX_FOLDER_NUM) {
                    $_f = $_f.$folders_array[$j]."/";
                    if (!file_exists($_f)) {
                      mkdir($_f,0755,true);
                      $total_folder_num+=1;
                    }
                  }
                }
              }
              move_uploaded_file($_FILES['files']['tmp_name'][$i],preg_replace("/\/+/i","/",$_f.$folders_array[$sizeof_folder_arr]));
              $total_size+=$file_size;
            }
          }
        }
      //Create Session
        $time_expire=time()+"1800000"; //30 minutes
        $fp=fopen($SELF_USER_SESSION,"w");
        fwrite($fp,"0,0,".$time_expire.",".$user_name);
        fclose($fp);

        $redirect_url="http://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
        header('Location: '.$redirect_url); //go back to home
      }*/
    }
//
//
  ?>
</body>
</html>

