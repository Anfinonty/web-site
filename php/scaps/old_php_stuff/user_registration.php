<?php include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php"; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <script>
    if ( window.history.replaceState ) { //prevent refresh n submit
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
</head>
<body>
  <h2>Registration (This Page Is Not In Use)</h2>
  <form method="post">
    <div>Registration Code
      <p><input id="inputRegCode" name="inputRegCode" value=""></p>
    </div>

    <div>Username
      <p><input id="inputUsername" name="inputUsername" value=""></p>
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
/*    if (isset($_POST['btnRegSubmit'])){
      //user credentials
      $reg_code=$_POST["inputRegCode"];
      $user_name=$_POST["inputUsername"];
      $user_password=$_POST["inputPassword"];
      $user_retype_password=$_POST["inputRetypePassword"];
      $error=0;
      //Registration Key
      $existing_regkeys_arr=scandir($GLOBAL_FOLDER."/RegistrationKeys");
      $hreg_code=MyHash($reg_code);
      if (in_array($hreg_code.".txt",$existing_regkeys_arr)) {
        echo "<p style='color:green'>Valid Registration Code</p>";
        $is_valid_reg_code=file_get_contents($GLOBAL_FOLDER."/RegistrationKeys/".$hreg_code.".txt");
        if (!$is_valid_reg_code[0]) {
          echo "<p style='color:green'>Available Registration Code</p>";        
        } else {
          echo "<p style='color:red'>This Registration Code is Taken</p>";
          $error=1;
        }
      } else {
        echo "<p style='color:red'>Invalid Registration Code</p>";
        $error=1;
      }

      //Usernames
      $existing_users_arr=scandir($GLOBAL_FOLDER);
      if (!in_array($user_name,$existing_users_arr)) {
        if (0<strlen($user_name) && strlen($user_name)<17) {
          echo "<p style='color:green'>username has valid length</p>";
          $regex_valid_username="/^[A-Za-z0-9_]{1,}$/";
          if (preg_match($regex_valid_username,$user_name)) {
            echo "<p style='color:green'>username is valid</p>";
          } else {
            echo "<p style='color:red'>username must be alphanumeric, and could contain underscores ('_')</p>";
            $error=1;
          }
        } else {
          echo "<p style='color:red'>username must be 1-16 characters long</p>";
          $error=1;
        }
      } else {
        echo "<p style='color:red'>username already exists</p>";
        $error=1;
      }

      //Password
      if ($user_password==$user_retype_password) {
        echo "<p style='color:green'>password match</p>";
        if (7<strlen($user_password) && strlen($user_passowrd)<17) {
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
      if (!$error) {
        echo "<p style='color:blue'>Registration Sucessful!</p>";
        $fp=fopen($GLOBAL_FOLDER."/RegistrationKeys/".$hreg_code.".txt","w");
        fwrite($fp,"1");
        fclose($fp);

        $fp=fopen($GLOBAL_FOLDER."/RegisteredUsers/".$user_name.".txt","w");
        fwrite($fp,MyHash($user_password));
        fclose($fp);

        mkdir($GLOBAL_FOLDER."/".$user_name,0777,true);
      }
    }*/
//
//
  ?>
</body>
</html>
