<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";  DrawNavBar(); ?>
<?php
   session_start();
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

  $url_filename=$_GET["edit_file"];
  $true_filename=$SELF_USER_FOLDER_NAME."/".$url_filename;

  $realBase=realpath($SELF_USER_FOLDER_NAME);
  $realUserPath=realpath($true_filename);

  //get url pop last part
  $true_dirname_arr=explode("/",$true_filename);
  array_pop($true_dirname_arr);
  $true_dirname=implode("/",$true_dirname_arr);
  $realDirPath=realpath($true_dirname);


  $read_file_txt="";

  //only allow .html .css and .js
  function isAllowedExtension($filename) {
    $allowed = ['html', 'css', 'js'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowed);
  }

  if (isAllowedExtension($true_filename)) { //check if html css or js
    if ($realUserPath === false || strpos($realUserPath, $realBase)!==0) {
     if ($realDirPath === false || strpos($realDirPath, $realBase)!==0) {
        echo "file not found<br>";
        header('Location: user_act_folder.php');
        exit;
      } else { //new file
        $read_file_txt="This is Sample Text, feel free to edit it!";
      }
    } else { //is within base path
      if (file_exists($true_filename)) {
        $read_file_txt=file_get_contents($true_filename);
      }
    }
  } else {
    echo "invalid file type<br>";
    header('Location: user_act_folder.php');
    exit;
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Disc Management - Editing</title>
  <script>
    if ( window.history.replaceState ) { //prevent refresh n submit
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
</head>
<body class="main_body">
<div class="main_body_background"></div>
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
  ?>

  <br>
<form method="post" id="form1" name="form1" action="/php/user_edit_file.php?edit_file=<?php echo $url_filename;?>">
  <table width="100%" height="80%" class="folder_header_span folder_header_table">
    <tr style="height:5%;">
      <td width="45%"><input type="submit" id="btnSubmit" name="btnSubmit" value="Update">
	<?php
	//Read exsiting file from url
	 //action onpress button
	  if (isset($_POST["btnSubmit"])) {
	    $read_file_txt=$_POST["text_editor"];
	    $fp=fopen($true_filename,"w"); //open in write mode
	    if (fwrite($fp, $read_file_txt)) {
	      echo "(updated!) ".date("Y-m-d H:i:s");
	    } else {
	      echo "(unsuccessful :( )";
	    }
	    fclose($fp);
	  }
	?>
      </td>
      <td width="45%"><?php echo $url_filename;?></td>
      <td><a href='https://spiderspeed.site/php/user_act_folder.php'>Back</a></td>
    </tr>
    <tr style="height:95%;">
      <td colspan="3">
        <textarea onfocus="TxtHereOnFocus()" onblur="TxtHereOnBlur()" class="text_editor" name="text_editor" style="width:100%; height:100%; background-color:rgba(0,0,0,0.5);color:white">
<?php echo $read_file_txt; ?></textarea>
      </td>
    </tr>
  </table>
</form>

  <br>
  <div id="showfiletree">
  <?php
    $self_size=GetDirectorySize($SELF_USER_FOLDER_NAME);
    echo "Space [".round($self_size/"1048576",3)."M / ".round($MAX_STORAGE/"1048576",3)."M]<br>";
    echo "Folders [".$USER_TOTAL_FOLDER_NUM."/".$USER_MAX_FOLDER_NUM."]<br><br>";
  ?>
  <iframe width="100%" height="100%" src="https://spiderspeed.site/php/view_folder.php?target_folder=/global/<?php echo $SELF_USER_NAME;?>"></iframe>
  </div>

</body>
</html>
