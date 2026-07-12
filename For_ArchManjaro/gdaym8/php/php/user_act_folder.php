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


   //File Create (GOTO)
   if (isset($_POST['create_file'])) {
     header("Location: user_edit_file.php?edit_file=".$_POST["new_filename_txt"]);
     //echo "<br>file created<br>";
     //header("Location: user_edit_file.php?edit_file=/index.html");
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
<body class="main_body">
<div class="main_body_background"></div>
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
    $extensions= array("html","js","css","txt","pdf","mp3","ogg","flac","wav","mid","gif","png","apng","bmp","jpg","jpeg","mkv","mp4","mpg","mpeg","mov","webm","webp","zip","7z", "exe");
    echo "Files Allowed: ";
    for ($i=0;$i<sizeof($extensions);$i++) {
      echo $extensions[$i].", ";
    }
  ?>
  <form method="post" enctype="multipart/form-data" id="form3" action="/php/user_act_folder.php">
    <input list="available_folders" type="text" id="txthere3" name="txthere3" maxlength="128" placeholder="Enter Existing Folder"> <input type="submit" name="submit_files" value="Upload File(s)"/><br>
    <input type="file" id="files" name="files[]" multiple directory="" moxkitdirectory="">
  </form>

  <br>
  <form method="post" id="form6" action="/php/user_act_folder.php">
    Files allowed: html, js, css<br>
    <input type="text" placeholder="Enter New or Existing File" list="available_files" id="new_filename_txt" name="new_filename_txt">
    <input type="submit" name="create_file" value="Edit or Create File">
  </form>

  <form method="post" id="form5" action="/php/user_act_folder.php">
    <input type="text" placeholder="Enter Existing File" list="available_files" id="src_filename_txt" name="src_filename_txt">
    <input type="text" placeholder="Rename File (No Extension)" list="available_files" id="dest_filename_txt" name="dest_filename_txt">
    <input list="available_folders" placeholder="Enter Existing Folder" type="text" id="dest_foldername_txt" name="dest_foldername_txt" maxlength="128">
    <input type="submit" name="move_file" value="Move or Rename File">
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
        echo "Space [".round($self_size/"1048576",3)."M / ".round($MAX_STORAGE/"1048576",3)."M]<br>";
        echo "Folders [".$USER_TOTAL_FOLDER_NUM."/".$USER_MAX_FOLDER_NUM."]<br><br>";
        echo $PROTIPS[0]."<br>";
        echo $PROTIPS[1]."<br>";
        echo $PROTIPS[2]."<br>";
        echo $PROTIPS[3]."<br>";
        //echo $PROTIPS[4]."<br><br>";
        //PrintDir($SELF_USER_FOLDER_NAME,0,0);
    ?>
  <!--<iframe width="100%" height="100%" src="https://spiderspeed.site:592/php/view_folder.php?target_folder=/global/<?php echo $SELF_USER_NAME;?>"></iframe>-->
  <iframe width="100%" height="100%" src="https://spiderspeed.site/php/view_folder.php?target_folder=/global/<?php echo $SELF_USER_NAME;?>"></iframe>
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

          //$file_ext=strtolower(end(explode('.',$_FILES['files']['name'][$i]))); //lwrcase
	  $filename = $_FILES['files']['name'][$i];
	  $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

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

    //FILE Move
    //https://stackoverflow.com/questions/4898534/php-copy-file-without-changing-the-last-modified-date
    if(isset($_POST['move_file'])) {
      $back="\.\.";
      //get filename
      $source_filename=$SELF_USER_FOLDER_NAME."/".preg_replace("/{$back}/i","_",$_POST["src_filename_txt"]);

      //get true src filename
      $true_source_filename_arr=explode("/",$source_filename);
      $true_source_filename=end($true_source_filename_arr);
      $file_extension_arr=explode(".",$true_source_filename);
      $file_extension=end($file_extension_arr);
      array_pop($file_extension_arr);
      $tsrc_filename_noext=implode(".",$file_extension_arr);


      //get dest filename
      $dest_filename=preg_replace("/{$back}/i","_",$_POST["dest_filename_txt"]);
      $true_dest_filename=$dest_filename;

      //get dest foldername
      $dest_foldername=$SELF_USER_FOLDER_NAME."/".preg_replace("/{$back}/i","_",$_POST["dest_foldername_txt"]);

      if (empty($_POST["dest_filename_txt"]) || strlen($_POST["dest_filename_txt"])==0) { //filename is empty, only move directory, no renaming
        $dest_filename=$tsrc_filename_noext; //no renaming, same name
	$true_dest_filename=$dest_filename;
      }

      if (empty($_POST["dest_foldername_txt"]) || strlen($_POST["dest_foldername_txt"])==0) { //if directory is empty, only rename file
	array_pop($true_source_filename_arr); //rebuild source dir, no file.ext
	$dest_foldername = implode("/",$true_source_filename_arr); //no change in dir, only rename
      }

      //compound dest foldername + filename
      $dest_filename=$dest_foldername."/".$dest_filename.".".$file_extension;
      if (!file_exists($dest_filename)) {
        // Get original modification time
        $modTime = filemtime($source_filename);

        // Copy the file to the new location
        if (!empty($_POST["src_filename_txt"]) &&
	    (!empty($_POST["dest_filename_txt"]) || !empty($_POST["dest_foldername_txt"])
	  )) {
	  if (isValidFilename($true_dest_filename)) {
            if (copy($source_filename,$dest_filename)) {
              // Apply the original modification time to the new file
  	      if (touch($dest_filename, $modTime)) {
                // Delete the original file
                unlink($source_filename);
	        echo "<br>File has been successfully moved or renamed! :D<br>";
	      } else {
	        echo "<br>File moving or renaming was unsuccessful :( (touch failed) <br>";
	      }
            } else {
              echo "<br>File moving or renaming was unsuccessful :( (copy failed)<br>";
	      echo "source filename:".$source_filename."<br>";
  	      echo "dest filename:".$dest_filename."<br>";
            }
          } else {
           echo "<br>File moving or renaming was unsuccessfull :( (Invalid File Name)<br>";
          }
        }
      } else {
        echo "<br>File moving or renaming was unsuccessfull :( (Filename Already Exists)<br>";
      }

      $redirect_url="https://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";
      header('Location: '.$redirect_url); //go back to home
    }

    //FILE Delete
    if (isset($_POST['delete2'])){
      $back="\.\.";
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
