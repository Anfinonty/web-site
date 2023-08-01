<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Get Registration Code</title>
  <script>
    if ( window.history.replaceState ) { //prevent refresh n submit
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
</head>
<body>
  <h2>Get Registration Code</h2>
  <form method="post">
    <div>Email
      <p><input id="inputEmail" name="inputEmail" value=""></p>
    </div>

    <div>Password
      <p><input id="inputPassword" name="inputPassword" value=""></p>
    </div>

    <div>Retype Password
      <p><input id="inputRetypePassword" name="inputRetypePassword" value=""></p>
    </div>

    <div>
      <p><input type="submit" id="btnRegSubmit" name="btnRegSubmit" value="Submit"></p>
    </div>
  </form>
  <?php
      //Posting
    if (isset($_POST['btnRegSubmit'])){
      //user credentials
      $user_email=$_POST["inputEmail"];
      $user_password=$_POST["inputPassword"];
      $user_retype_password=$_POST["inputRetypePassword"];
      $error=0;

      //Email
      $existing_users_email_arr=scandir($REG_EMAILS_DIR);
      $regex_valid_email="/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
      if (in_array(MyHash($user_email).".txt",$existing_users_email_arr) ||
	  in_array(MyHash2($user_email).".txt",$existing_users_email_arr)
	) {
        echo "<p style='color:red'>Email already in use</p>";
        $error=1;
      } else {
	if (preg_match($regex_valid_email,$user_email)) {
          echo "<p style='color:green'>valid email</p>";
        } else {
          echo "<p style='color:red'>invalid email</p>";
          $error=1;
        }
      }

      //Password
      if ($user_password==$user_retype_password) {
        echo "<p style='color:green'>password match</p>";
        if (7<strlen($user_password) && strlen($user_password)<17) {
          echo "<p style='color:green'>password has valid length</p>";
          $regex_valid_password="/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";//https://uibakery.io/regex-library/password-regex-php
          if (preg_match($regex_valid_password,$user_password)) {
            echo "<p style='color:green'>valid password</p>";
          } else {
            echo "<p style='color:red'>password must contain uppercase, lowercase, numerical and special characters</p>";
            $error=1;
          }
        } else {
          echo "<p style='color:red'>password must be 8-16 characters long</p>";
          $error=1;
        }
      } else {
        echo "<p style='color:red'>password doesnt match</p>";
        $error=1;
      }

      //action
      if (!file_exists($REG_Q_DIR."/in_progress.txt")) {
        if (!$error) {
          echo "<p style='color:blue'>Email Sent!</p>";
    	  $RegCode=GenRandString(16); //Generate Random code 16 digit with special characters, upcase, lowcase, numbers

          $fp=fopen($REG_Q_DIR."/in_progress.txt","w"); //deleted last after email sent, prevents program from starting new until finished
          fclose($fp);

          $fp=fopen($REG_Q_DIR."/registerQ.txt","w"); //deleted first quickly, saved to memory
          fwrite($fp,$user_email.",".$RegCode);
          fclose($fp);

          $fp=fopen($REG_Q_DIR."/".MyHash2($user_email).".txt","w");
          fwrite($fp,MyHash2($RegCode).",".MyHash2($user_password));
          fclose($fp);
       }
     } else {
       echo "<p style='color:red'>Server is busy!! D: Try again in a few minutes </p>";
     }
  }
//
//
  ?>
</body>
</html>