<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";  DrawNavBar(); ?>

<!DOCTYPE html>
<html>
<head>
  <title>See you again!</title>
</head>
<body>
  <h2>Ejecting...</h2>
  <?php 

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

    //kill session
    session_destroy(); //logout user



    //redirect to home
    $redirect_url="http://".$_SERVER['HTTP_HOST'];;
    header('Location: '.$redirect_url); //go back to home
  ?>
</body>
</html>
