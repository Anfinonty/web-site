<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";  DrawNavBar(); ?>
<?php
    session_start();
    //php file upload:
    //https://www.tutorialspoint.com/php/php_file_uploading.htm

    //php folder check size:
    //https://stackoverflow.com/questions/478121/how-to-get-directory-size-in-php

   try {
     $db = new SQLITE3('/var/www/db/mydatabase.sqlite');
     $stmt = $db->prepare("SELECT * FROM mates WHERE username=:username");
     $stmt->bindParam(":username",$_SESSION['username']);
     $result = $stmt->execute();
     $count=0;
     while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
       $count++;
	//echo $row["username"];
     }
     if ($count<1) {
       $redirect_url="https://".$_SERVER['HTTP_HOST'];
       header('Location: '.$redirect_url); //go back to home
       exit;
     }
   } catch (Exception $e) {
     $redirect_url="https://".$_SERVER['HTTP_HOST'];
     header('Location: '.$redirect_url); //go back to home
     exit;
   }

   if (!file_exists($SELF_USER_FOLDER_NAME)) { //no username
     $redirect_url="https://".$_SERVER['HTTP_HOST'];
     header('Location: '.$redirect_url); //go back to home
     exit;
   }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Disc Management</title>
  <script>
    if ( window.history.replaceState ) { //prevent refresh n submit
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
</head>
<body>
  <h2>Disc Management</h2>
  <p>Welcome Back, <?php echo $SELF_USER_NAME?>!</p>

  <datalist id="available_folders">
  <?php
    PrintDir($SELF_USER_FOLDER_NAME,10,0);
    for ($i=0;$i<sizeof($USER_FOLDERS_ARR);$i++) {
      echo "<option>".$USER_FOLDERS_ARR[$i]."</option>";
    }
  ?>
  </datalist>

  <datalist id="available_files">
  <?php
    PrintDir($SELF_USER_FOLDER_NAME,11,0);
    for ($i=0;$i<sizeof($USER_FILES_ARR);$i++) {
      echo "<option>".$USER_FILES_ARR[$i]."</option>";
    }
  ?>
  </datalist>

  <?php  
  PrintDir($SELF_USER_FOLDER_NAME,1,1);

  if ($USER_TOTAL_FOLDER_NUM<$USER_MAX_FOLDER_NUM) {
  echo '
  <br>
  <form method="post" id="form1" action="/php/user_act_folder.php">
    <input type="text" placeholder="Enter New Folder Name" id="txthere" name="txthere" maxlength="128">
    <input type="submit" name="submit" value="Create Folder">
  </form>

  <form method="post" id="form1_1" action="/php/user_act_folder.php">
    <input list="available_folders" placeholder="Enter Existing Folder" type="text" id="txthere0" name="txthere0" maxlength="128">
    <input type="text" id="txthere1" placeholder="Enter New Folder Name" name="txthere1" maxlength="128">
    <input type="submit" name="submit1" value="Create Subfolder">
  </form>
';
  }
  ?>

  <form method="post" id="form2" action="/php/user_act_folder.php">
    <input placeholder="Enter Existing Folder" list="available_folders" type="text" id="txthere2" name="txthere2" maxlength="128">
    <input type="submit" name="delete" value="Delete Folder">
  </form>
  <br>
  <?php
    $extensions= array("html","js","css","txt","mp3","ogg","flac","wav","mid","gif","png","apng","bmp","jpg","jpeg","mkv","mp4","mpg","mpeg","mov","webm","webp","zip");
    echo "Files Allowed: ";
    for ($i=0;$i<sizeof($extensions);$i++) {
      echo $extensions[$i].", ";
    }
  ?>
  <form method="post" enctype="multipart/form-data" id="form3" action="/php/user_act_folder.php">
    <input list="available_folders" type="text" id="txthere3" name="txthere3" maxlength="128" placeholder="Enter Existing Folder"> <input type="submit" name="submit_files" value="Upload File(s)"/><br>
    <input type="file" id="files" name="files[]" multiple directory="" moxkitdirectory="">
  </form>

  <form method="post" id="form4" action="/php/user_act_folder.php">
    Enter (*) to delete similar sounding files; Img* deletes all files starting with "Img"; *.png deletes all files ending with ".png".<br>
    <input type="text" placeholder="Enter Existing File(s)" list="available_files" id="txthere4" name="txthere4">
    <input type="submit" name="delete2" value="Delete File(s)">
  </form>

  <br>
  <div id="showfiletree">
    <?php
        $self_size=GetDirectorySize($SELF_USER_FOLDER_NAME);
        echo "Space [".round($self_size/"1048576",3)."M / ".$MAX_STORAGE/"1048576"."M]<br>";
        echo "Folders [".$USER_TOTAL_FOLDER_NUM."/".$USER_MAX_FOLDER_NUM."]<br><br>";
        echo $PROTIPS[0]."<br>";
        echo $PROTIPS[1]."<br>";
        echo $PROTIPS[2]."<br>";
        echo $PROTIPS[3]."<br>";
        //echo $PROTIPS[4]."<br><br>";
        //PrintDir($SELF_USER_FOLDER_NAME,0,0);
    ?>
  <!--<iframe width="100%" height="100%" src="https://gdaym8.site:592/php/view_folder.php?target_folder=/global/<?php echo $SELF_USER_NAME;?>"></iframe>-->
  <iframe width="100%" height="100%" src="https://gdaym8.site/php/view_folder.php?target_folder=/global/<?php echo $SELF_USER_NAME;?>"></iframe>
  </div>


  <?php    
    //FOLDER Create
    if (isset($_POST['submit'])){
      $set_foldername=str_replace(".","_",$_POST["txthere"]);
      $set_foldername=str_replace("/","_",$set_foldername);      
      if (mkdir($SELF_USER_FOLDER_NAME."/".$set_foldername,0755,true)) {
        echo "<br> Folder Creation Successful! :D <br>";
      } else {
        echo "<br> Folder Creation Unsuccessful :( <br>";
      }
      $redirect_url="https://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
      header('Location: '.$redirect_url); //go back to home
    }

    //SUBFOLDER Create
    if (isset($_POST['submit1'])){
      $set_foldername=str_replace(".","_",$_POST["txthere0"]);
      $set_subfoldername=str_replace(".","_",$_POST["txthere1"]);
      $set_subfoldername=str_replace("/","_",$set_subfoldername);
      if (is_dir($SELF_USER_FOLDER_NAME."/".$set_foldername)) {
        if (mkdir($SELF_USER_FOLDER_NAME."/".$set_foldername."/".$set_subfoldername,0755,true)) {
          echo "<br> Subfolder Creation Successful! :D <br>";
        } else {
          echo "<br> Subfolder Creation Unsuccessful :( <br>";
        }
      } else {        
	echo "<br> Folder Not Found, Check your Spelling :/<br>";    
      }
      $redirect_url="https://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
      header('Location: '.$redirect_url); //go back to home
    }

    //FOLDER Delete
    if (isset($_POST['delete'])){ //prevent eject accidental
      $set_foldername=str_replace(".","_",$_POST["txthere2"]);
      if ($set_foldername!="" && $set_foldername!="/") {
        PrintDir($SELF_USER_FOLDER_NAME."/".$set_foldername,-1,0); //Recursive delete
      }
      $redirect_url="https://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
      header('Location: '.$redirect_url); //go back to home
    }

    //FILE Create
    if(isset($_POST['submit_files'])) {
      $upload_to_folder=str_replace(".","_",$_POST["txthere3"]);
      $errors= array();
      if (is_dir($GLOBAL_FOLDER."/".$SELF_USER_NAME."/".$upload_to_folder) || $upload_to_folder==="") {
        $total_size=$self_size;
        $total_folder_num=$USER_TOTAL_FOLDER_NUM;
        foreach($_FILES['files']['name'] as $i => $name) {
	  $tmp_filename=$_FILES['files']['name'][$i];
          $file_ext=strtolower(end(explode('.',$_FILES['files']['name'][$i]))); //lwrcase
          $file_size=$_FILES['files']['size'][$i];
          if ($total_size+$file_size<$MAX_STORAGE) { //Sizecheck
	    $regex_nosymbols="/([\:\<\>\*\?\"\|\/])/";
	    //$regex_nosymbols="/([\:])/";
            if(in_array($file_ext,$extensions)===true && !preg_match($regex_nosymbols,$tmp_filename)) { //Allow non php extension
              $folders_array=explode(">",$_FILES['files']['name'][$i]);//Check for folder ">", make array of folder names //legacy but im not touching it
              $sizeof_folder_arr=sizeof($folders_array)-1;
              $_f = $GLOBAL_FOLDER."/".$SELF_USER_NAME."/".$upload_to_folder."/";
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
            } else {
              $errors[0]='Non-mentioned files are not allowed :/';
            }
          } else {
            $errors[1]='Upload Exceeded the Storage Limit :/';
          }
        } //End of File Upload Code
        if (empty($errors)==true) { //Errors occured
          echo "<br> File Uploading Successful! :D <br>";
        } else {
          for ($i=0;$i<sizeof($errors);$i++) {echo "<br> ".$errors[$i];}
          echo "<br> Some Errors Occured :/ <br>";
        }
      } else { //Folder not found
        echo "<br> Folder Not Found, Try Again :/ <br>";
      }
      $redirect_url="https://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
      header('Location: '.$redirect_url); //go back to home
    }
    //FILE Delete
    $back="\.\.";
    if (isset($_POST['delete2'])){
      $set_filename=$SELF_USER_FOLDER_NAME."/".preg_replace("/{$back}/i","_",$_POST["txthere4"]);
      foreach (glob($set_filename) as $filename) {
	if (unlink($filename)) {
	  $tmp_filename = str_replace($SELF_USER_FOLDER_NAME,"",$filename);
          echo "<br>".$filename.": File Deletion Successful! :D <br>";
        } else {
          echo "<br> File Deletion Unsuccessful :( <br>";
        }
      }
      $redirect_url="https://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
      header('Location: '.$redirect_url); //go back to home
    }
  ?>
  <?php
    /*for ($i=0;$i<36;$i++) {
      echo "<br>";
    }*/
  ?>
</body>
</html>