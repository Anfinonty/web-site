<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <script>
    if ( window.history.replaceState ) { //prevent refresh n submit
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
</head>
<body>
  <h2>Login (This Page Is Not In Use)</h2>
  <form method="post">
    <div>Username
      <p><input id="inputUsername" name="inputUsername" value=""></p>
    </div>

    <div>Password
      <p><input id="inputPassword" name="inputPassword" value=""></p>
    </div>

    <div>
      <p><input type="submit" id="btnLoginSubmit" name="btnLoginSubmit" value="Submit"></p>
    </div>
  </form>

  <?php
    //echo $USER_SESSION_DIR."<br>";
    /*if (isset($_POST['btnLoginSubmit'])) {
      $user_name=$_POST["inputUsername"];
      $user_password=$_POST["inputPassword"];
      $error=0;
      if (file_exists($GLOBAL_FOLDER."/RegisteredUsers/".$user_name.".txt")) {
        $read_pw=file_get_contents($GLOBAL_FOLDER."/RegisteredUsers/".$user_name.".txt");
        $hpw=MyHash($user_password);
        if ($read_pw!=$hpw) {
          $error=1;
        }
      } else {
        $error=1;
      }
      if ($error) {
        echo "<p style='color:red'>Incorrect username or password :/</p>";
      } else {
        $time_expire=time()+"1800"; //30 minutes
        $fp=fopen($SELF_USER_SESSION,"w");
        fwrite($fp,"0,0,".$time_expire.",".$user_name);
        fclose($fp);

        $redirect_url="http://".$_SERVER['HTTP_HOST']."/php/user_act_folder.php";;
        header('Location: '.$redirect_url); //go back to home
      }
    }*/
  ?>
</body>
</html>
