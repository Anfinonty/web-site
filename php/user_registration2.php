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
  <h2>Registration</h2>
  <form method="post">
    <div>Registration Code
      <p><input id="inputRegCode" name="inputRegCode" value=""></p>
    </div>

    <div>Email
      <p><input id="inputEmail" name="inputEmail" value=""></p>
    </div>

    <div>Username
      <p><input id="inputUsername" name="inputUsername" value=""></p>
    </div>

    <div>Password
      <p><input id="inputPassword" name="inputPassword" value=""></p>
    </div>

    <div>
      <p><input type="submit" id="btnRegSubmit" name="btnRegSubmit" value="Submit"></p>
    </div>
  </form>
  <?php
      //Posting
    if (isset($_POST['btnRegSubmit'])) {
      //user credentials
      $reg_code=MyHash2($_POST["inputRegCode"]);
      $user_email=MyHash2($_POST["inputEmail"]);
      $user_name=$_POST["inputUsername"];
      $user_password=MyHash2($_POST["inputPassword"]);
      $error=0;
      $saved_password=-1;
      $saved_reg_code=-1;

      //Email
      $reg_user_filename=$REG_Q_DIR."/".$user_email.".txt";	//if email.txt exists in RegQ
      if (file_exists($reg_user_filename)) {
        $reg_user_details=htmlspecialchars(strval(file_get_contents($reg_user_filename)));
        $reg_user_details_arr=explode(",",$reg_user_details);
	$saved_reg_code=$reg_user_details_arr[0]; //get reg code
	$saved_password=$reg_user_details_arr[1];	//get password
      } else {
        echo "<p style='color:red'>Email not found</p>";
        $error=1;
      }

      //RegCode
      if ($saved_reg_code==-1) {//if reg code isnt -1
        echo "<p style='color:red'>Email not found</p>";
        $error=1;	
      } else { //otherwise
	if ($reg_code==$saved_reg_code) { // if reg code is same as get_reg_code
          echo "<p style='color:green'>registration code is valid</p>";	
	} else {//reg code is not valid
	  echo $reg_code;
	  echo "<br>";
	  echo $saved_reg_code;
	  echo "<br>";
          echo "<p style='color:red'>Incorrect Registration Code</p>";
          $error=1;
	}
      }

      //Usernames
      $existing_users_arr=scandir($GLOBAL_FOLDER);
      if (!in_array($user_name,$existing_users_arr)) {
        if (0<strlen($user_name) && strlen($user_name)<17) {
          echo "<p style='color:green'>username has valid length</p>";
          $regex_valid_username="/^[A-Za-z0-9_]{1,16}$/";
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
      }

      //Password
      if ($saved_password==-1) {
        echo "<p style='color:red'>Email not found</p>";
        $error=1;	
      } else {
        if ($user_password==$saved_password) {
          echo "<p style='color:green'>Password match</p>";
        } else {
          echo "<p style='color:red'>Incorrect password</p>";
          $error=1;
        }
      }

      //Add to Registered Users
      if (!$error) {
        echo "<p style='color:blue'>Registration Successful!</p>";
	//Write username to Registered Users
        $fp=fopen($REG_USERS_DIR."/".$user_name.".txt","w");
        fwrite($fp,$user_email.",".$user_password);
        fclose($fp);
	
	//Write user email to Registered Emails
        $fp=fopen($REG_EMAILS_DIR."/".$user_email.".txt","w");
        fwrite($fp,$user_name);
        fclose($fp);

	unlink($REG_Q_DIR."/".$user_email.".txt"); //Delete from RegQ

        mkdir($GLOBAL_FOLDER."/".$user_name,0777,true); //create folder based on username
      }
    }
//
//
  ?>
</body>
</html>