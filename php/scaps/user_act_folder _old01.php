<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";?>
<?php
  if (!file_exists($SELF_USER_FOLDER_NAME)) { //no username
    $redirect_url="http://".$_SERVER['HTTP_HOST'];
    header('Location: '.$redirect_url); //go back to home
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
    //php file upload:
    //https://www.tutorialspoint.com/php/php_file_uploading.htm

    //php folder check size:
    //https://stackoverflow.com/questions/478121/how-to-get-directory-size-in-php
  </script>
</head>
<body>
  <h2>Disc Management</h2>
  <p>Welcome Back, <?php echo $SELF_USER_NAME?>!</p>
  <?php  
  PrintDir($SELF_USER_FOLDER_NAME,1,1);
  if ($USER_TOTAL_FOLDER_NUM<$USER_MAX_FOLDER_NUM) {
  echo '
  <br>
  <form method="post" id="form1">
    <input type="text" id="txthere" name="txthere" maxlength="128">
    <input type="submit" name="submit" value="Create Folder">
  </form>

  <form method="post" id="form1_1">
    <input type="text" id="txthere0" name="txthere0" maxlength="128">
    <input type="text" id="txthere1" name="txthere1" maxlength="128">
    <input type="submit" name="submit1" value="Create Subfolder">
  </form>
';
  }
  ?>
  <form method="post" id="form2">
    <input type="text" id="txthere2" name="txthere2" maxlength="128">
    <input type="submit" name="delete" value="Delete Folder">
  </form>
  <br>
  <?php
    $extensions= array("php");
    echo "Files Not Allowed: ";
    for ($i=0;$i<sizeof($extensions);$i++) {
      echo $extensions[$i].", ";
    }
  ?>
  <form method="post" enctype="multipart/form-data" id="form3">
    <input type="text" id="txthere3" name="txthere3" maxlength="128"> <input type="submit" name="submit_files" value="Upload To Folder"/><br>
    <input type="file" id="files" name="files[]" multiple directory="" moxkitdirectory="">
  </form>

  <form method="post" id="form4">
    <input type="text" id="txthere4" name="txthere4">
    <input type="submit" name="delete2" value="Delete File">
  </form>


  <br>
  <div id="showfiletree">
    <?php PrintDir($SELF_USER_FOLDER_NAME,0,0);?>
  </div>
  <?php
    echo "<br>"; 
    echo $PROTIPS[0]."<br>";
    echo $PROTIPS[1]."<br>";
    echo $PROTIPS[2]."<br>";
  ?>

  <?php
    $self_size=GetDirectorySize($SELF_USER_FOLDER_NAME);
    $target_file_size=0;
    
    //FOLDER Create
    if (isset($_POST['submit'])){
      $set_foldername=str_replace(".","_",$_POST["txthere"]);
      $set_foldername=str_replace("/","_",$set_foldername);      
      if (mkdir($SELF_USER_FOLDER_NAME."/".$set_foldername,0777,true)) {
        echo "<br> Folder Creation Successful! :D <br>";
      } else {
        echo "<br> Folder Creation Unsuccessful :( <br>";
      }
    }

    //SUBFOLDER Create
    if (isset($_POST['submit1'])){
      $set_foldername=str_replace(".","_",$_POST["txthere0"]);
      $set_subfoldername=str_replace(".","_",$_POST["txthere1"]);
      $set_subfoldername=str_replace("/","_",$set_subfoldername);
      if (is_dir($SELF_USER_FOLDER_NAME."/".$set_foldername)) {
        if (mkdir($SELF_USER_FOLDER_NAME."/".$set_foldername."/".$set_subfoldername,0777,true)) {
          echo "<br> Subfolder Creation Successful! :D <br>";
        } else {
          echo "<br> Subfolder Creation Unsuccessful :( <br>";
        }
      } else {
        echo "<br> Folder Not Found, Check your Spelling :/<br>";    
      }
    }

    //FOLDER Delete
    if (isset($_POST['delete'])){
      $set_foldername=str_replace(".","_",$_POST["txthere2"]);
      PrintDir($SELF_USER_FOLDER_NAME."/".$set_foldername,-1,0);
    }

    //FILE Create
    if(isset($_POST['submit_files'])) {
      $upload_to_folder=str_replace(".","_",$_POST["txthere3"]);
      $errors= array();
      if (is_dir($GLOBAL_FOLDER."/".$SELF_USER_NAME."/".$upload_to_folder) || $upload_to_folder==="") {
        /*$file_name = $_FILES['files']['name'];
        $file_size = $_FILES['files']['size'];
        $file_tmp =  $_FILES['files']['tmp_name'];
        $file_type = $_FILES['files']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['files']['name']))); //lwrcase        
        */

        $total_size=$self_size;
        //$total_folder_num=$USER_TOTAL_FOLDER_NUM;
        foreach($_FILES['files']['name'] as $i => $name) {
          $file_ext=strtolower(end(explode('.',$_FILES['files']['name'][$i]))); //lwrcase
          $file_size=$_FILES['files']['size'][$i];
          if ($total_size+$file_size<$MAX_STORAGE) { //Sizecheck
            if(in_array($file_ext,$extensions)===false) { //Allow non php extension
              $folders_array=explode(">",$_FILES['files']['name'][$i]);//Check for folder ">", make array of folder names
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
              //echo "..:".preg_replace("/\/+/i","/",$_f.$folders_array[$sizeof_folder_arr])."<br>";
//              move_uploaded_file($_FILES['files']['tmp_name'][$i],preg_replace("/\/+/i","/",$_f.$_FILES['files']['name'][$i]));
              move_uploaded_file($_FILES['files']['tmp_name'][$i],preg_replace("/\/+/i","/",$_f.$folders_array[$sizeof_folder_arr]));
              $total_size+=$file_size;
            } else {
              $errors[0]='PHP files are not allowed :/';
            }
          } else {
            $errors[1]='Upload Exceeded the Storage Limit :/';
          }
        }
      }
        /*if(in_array($file_ext,$extensions)===true){
          $errors[0]="This file extension isn't allowed :/";
        }

        if($self_size+$file_size>$MAX_STORAGE) {
          $errors[1]='Upload Exceeded the Storage Limit :/';
        }*/

        /*if(empty($errors)==true) {
          echo "<br> File Uploading Successful! :D <br>";
          //move_uploaded_file($file_tmp,$upload_to_folder."/".$file_name);
          /*
          //Read file content
          if ($file_ext=="html") {
            $tmp_ufile=$upload_to_folder."/".$file_name;
            $tmp_ufile_contents=strval(file_get_contents($tmp_ufile));
            $tmp_ufile_contents=TheFilter($tmp_ufile_contents);

         //Write File content
            $html_file=fopen($tmp_ufile,"w");
            fwrite($html_file,$tmp_ufile_contents);
            fclose($html_file);
          }
        } else {
        /*echo '
  <div>
    <ul>
      <li>Sent file: '.$_FILES[$uploaded_file]['name'].
     '<li>File size: '.$_FILES[$uploaded_file]['size'].
     '<li>File type: '.$_FILES[$uploaded_file]['type'].
    '</ul>
  <div>';*/
          /*echo "<br> ".$errors[0];
          echo "<br> ".$errors[1];
          echo "<br> Some Errors Occured :/ <br>";
        }
        clearstatcache();
      } else {
        echo "<br> Folder Not Found, Try Again :/ <br>";
      }*/
    }

    //FILE Delete
    $back="\.\.";
    if (isset($_POST['delete2'])){
      $set_filename=$SELF_USER_FOLDER_NAME."/".preg_replace("/{$back}/i","_",$_POST["txthere4"]);
      $target_file_size=filesize($set_filename);
      if (unlink($set_filename)) {
        echo "<br> File Deletion Successful! :D <br>";
      } else {
        $target_file_size=0;
        echo "<br> File Deletion Unsuccessful :( <br>";
      }
    }

    echo "<br>";    
    if (isset($_POST['delete2'])){ //File Deletion
      echo "Space [".($self_size-$target_file_size)/"1024000"."M / ".$MAX_STORAGE/"1024000"."M]<br>";
    } else {
      echo "Space [".round(($self_size+$_FILES['files']['size'])/"1024000",3)."M / ".$MAX_STORAGE/"1024000"."M]<br>";
    }
    echo "Folders [".$USER_TOTAL_FOLDER_NUM."/".$USER_MAX_FOLDER_NUM."]<br>";
  ?>
</body>
</html>
