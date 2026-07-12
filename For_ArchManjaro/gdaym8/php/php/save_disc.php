<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

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


   $busyFile    = $SAVED_DISCS_DIR."/0busy.txt";
   $printtext = '';
   if (!file_exists($busyFile)) {
    // Create busy.txt immediately
    $printtext = '<h2>Progress Saved.</h2>';

    file_put_contents($busyFile, "busy");

  //remove zip from {SavedDiscs}
    $archivePath= $SAVED_DISCS_DIR."/SPIDERSPEED_DISC_".$SELF_USER_NAME.".zip";
    $sourcePath=$SELF_USER_FOLDER_NAME;
    if (file_exists($archivePath)) {
      unlink($archivePath);
    }

  //Create .zip in {SavedDiscs}
    $command = sprintf("7z a -tzip -mx=1 -mmt=on %s %s", escapeshellarg($archivePath), escapeshellarg($sourcePath));

  // Executes in the background, freeing up the webpage immediately
  //exec("($command) > /dev/null 2>&1 &");
  // Run everything in background: zip → delete busy.txt
    exec("( $command ; rm -f " . escapeshellarg($busyFile) . " ) > /dev/null 2>&1 &");
  } else {
    $printtext = '<h2>Process is busy. Try Again Later.</h2>';
  }

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Disc Saved</title>
  <style>
    body {
      text-align: center;
    }
  </style>
  <script> 
    //document.getElementById("default_server_header").hidden=true;
  </script>
</head>
<body class="main_body">
<div class="main_body_background"></div>
<h1>Are you sure you want to Eject and Log Out?</h1>
<?php
  echo $printtext;
?>

<a href="user_act_folder.php">&nbspBack&nbsp</a>&nbsp
<a href="eject_disc.php">&nbspEject&nbsp</a>
</body>
</html>
