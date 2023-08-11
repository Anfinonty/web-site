<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<!DOCTYPE html>
<html>
<head>
  <title>See you again!</title>
</head>
<body>
  <h2>Ejecting...</h2>
  <?php 
    //suicide session
    if (file_exists($SELF_USER_SESSION)) {
      unlink($SELF_USER_SESSION);
    }

    //remove zip from {SavedDiscs}
    if (file_exists($USER_SAVED_DISCS_DIR."/WEB_SITE_DISC_".$SELF_USER_NAME.".zip")) {
      unlink($USER_SAVED_DISCS_DIR."/WEB_SITE_DISC_".$SELF_USER_NAME.".zip");
    }

    //remove own folder
    //PrintDir($SELF_USER_FOLDER_NAME,-1,0); //legacy


    //remove own folder from {SavedDiscs}
    if (is_dir($USER_SAVED_DISCS_DIR)) {
      PrintDir($USER_SAVED_DISCS_DIR,-1,0); 
    }

    //redirect to home
    $redirect_url="http://".$_SERVER['HTTP_HOST'];;
    header('Location: '.$redirect_url); //go back to home
  ?>
</body>
</html>
