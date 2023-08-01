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
  <h2>Login</h2>
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
    if (isset($_POST['btnLoginSubmit'])) {
      $user_name=$_POST["inputUsername"];
      $user_password=$_POST["inputPassword"];
      $error=0;
      if (file_exists($REG_USERS_DIR."/".$user_name.".txt")) {
        $get_read_pw=htmlspecialchars(strval(file_get_contents($REG_USERS_DIR."/".$user_name.".txt")));
	$read_pw_arr=explode(",",$get_read_pw);
	$read_pw=$read_pw_arr[1];
        $hpw=MyHash2($user_password);
        if ($read_pw!==$hpw) {
          $error=1;
	  $hpw=MyHash($user_password);
	  if ($read_pw!==$hpw) {
            $error=1;
	  } else {
	    $error=0;
	  }
        }
      } else {
        $error=1;
      }
      if ($error) {
        echo "<p style='color:red'>Incorrect username or password :/</p>";
      } else {
        $time_expire=time()+"1800"; //30 minutes
        $fp=fopen($SELF_USER_SESSION,"w");
        fwrite($fp,"0,0,".$time_expire.",".$user_name); //cause of log in
        fclose($fp);

        $redirect_url="/php/user_act_folder.php"; //goto user act folder
        header('Location: '.$redirect_url); //go back to home
      }
    }
  ?>
</body>
</html>
