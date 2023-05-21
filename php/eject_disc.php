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


    if (file_exists($GLOBAL_FOLDER."/".$SELF_USER_NAME.".zip")) {
      unlink($GLOBAL_FOLDER."/".$SELF_USER_NAME.".zip");
    }

    //remove own folder
    PrintDir($SELF_USER_FOLDER_NAME,-1,0);

    //redirect to home
    $redirect_url="http://".$_SERVER['HTTP_HOST'];;
    header('Location: '.$redirect_url); //go back to home
  ?>
</body>
</html>
