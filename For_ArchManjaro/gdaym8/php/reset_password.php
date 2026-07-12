

<?php
//kick out logged in user
  if (!is_null($_SESSION["username"] ?? null)) {
    header("Location: user_act_folder.php");
    exit;
  }


//Check input captcha
  if (isset($_POST["btnSubmitReqRestPassword"]) || isset($_POST["btnSubmitResetPassword"])) {
//captcha check
    $entered_captcha=$_POST["captcha"];
    if (password_verify($entered_captcha,$_SESSION["captcha"])) {
      //do nothing, correct captcha
    } else {
      echo "Captcha is incorrect D:";
      header("Location: reset_password_form.php");
      exit;
    }
  }

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require("PHPMailer/src/Exception.php");
  require("PHPMailer/src/PHPMailer.php");
  require("PHPMailer/src/SMTP.php");


  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
  DrawNavBar();

  //send email for reset password
  if (isset($_POST["btnSubmitReqResetPassword"])) {
    echo "<h1>Reset Password Request Code Status:</h1>";
    $user_email=$_POST["inputEmail"];
    $error=0;

    //email
    $regex_valid_email="/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/";
    if (preg_match($regex_valid_email,$user_email)) {
      echo "<p style='color:green'>Valid email entered</p>";
    } else {
      echo "<p style='color:red'>Invalid email entered</p>";
      $error=1;
    }

    if ($error==0) {
      $reg_code=GenRandString(16);

      try {
        $db = new SQLITE3('/var/www/db/mydatabase.sqlite');

        //Remove all old tokens
        $stmt = $db->prepare("DELETE FROM registration_token WHERE expiry_time<:time");
        $time_now=time();
        $stmt->bindParam(":time",$time_now);
        $result = $stmt->execute();

        $expiry_time = time()+60*5;
        $hash_reg_code = password_hash($reg_code,PASSWORD_DEFAULT);

        //check if email already exists in mates db
        $stmt = $db->prepare("SELECT email FROM mates WHERE email=:email");
        $stmt->bindParam(":email",$user_email);
        $result = $stmt->execute();
        $count=0;
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
          $count++;
        }

        if ($count==1) { //email found in database!
    	//Send email
      	  $mail = new PHPMailer(true);
      	  $mail->IsSMTP();
      	  $mail->Host='smtp.gmail.com';
      	  $mail->SMTPAuth=true;
      	  $mail->Username="johndoe62786@gmail.com";
      	  $mail->Password="jztnskxeqiubsfyk";
      	  $mail->SMTPSecure="ssl";
      	  $mail->Port=465;

      	  $mail->setFrom("johndoe627862@gmail.com");

      	  $mail->addAddress($user_email);

      	  $mail->isHTML(true);

      	  $mail->Subject="G'day M8! Here's your Password Reset Request Code! :D";

      	  $mail->Body="Fey: G'day M8! Here's your Password Reset Request Code! Enter it in the Reset Password Section within 5 minutes to Change your Password: ".$reg_code;

          if ($mail->Send()) {
          //$mail->send();
            echo "<p style='color:green'>Password Reset Request Code has been sent to your E-mail! :D</p>";
          } else {
            echo "<p style='color:red'>Failed to Send E-mail,, D:<p>";
          }


          //update registration_token db
          //check if email aready exists
          $stmt = $db->prepare("SELECT email FROM registration_token WHERE email=:email");
          $stmt->bindParam(":email",$user_email);
          $result = $stmt->execute();

          $hash_password = password_hash( GenRandString(2048) ,PASSWORD_DEFAULT);
            

          $count=0;
          while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $count++;
          }

          if ($count>0) { //email already exists
            $stmt = $db->prepare("UPDATE registration_token SET reg_code=:reg_code,password=:password,expiry_time=:expiry_time WHERE email=:email");
          } else { //new email
            $stmt = $db->prepare("INSERT INTO registration_token(email, reg_code, password, expiry_time) VALUES (:email,:reg_code,:password,:expiry_time)");
          }

          $stmt->bindParam(":email",$user_email);
          $stmt->bindParam(":reg_code",$hash_reg_code);
          $stmt->bindParam(":password",$hash_password);
          $stmt->bindParam(":expiry_time",$expiry_time);
          $result = $stmt -> execute();



        } else {
          //email not found
          //echo "<p style='color:red'>Error X_x<p>";
          echo "<p style='color:red'>Email not found X_x</p>";
        }


      } catch (Exception $e) {
        echo "<br>Error X_x<br>";
        echo $e->getMessage();
      }
    }

  // Reset Password True
  } else if (isset($_POST["btnSubmitResetPassword"])) {
    echo "<h1>Reset Password Status:</h1>";

  //user credentials
    $reg_code=$_POST["inputRegCode"];
    $user_email=$_POST["inputRegEmail"];
    $user_password=$_POST["inputRegPassword"];
    $error=0;
    $hashed_password=-1;
    $hashed_reg_code=-1;

    //Email
    try {
      $db = new SQLITE3('/var/www/db/mydatabase.sqlite');

      //Remove all old tokens
      $stmt = $db->prepare("DELETE FROM registration_token WHERE expiry_time<:time");
      $time_now=time();
      $stmt->bindParam(":time",$time_now);
      $result = $stmt->execute();

      //fetch details from registration_token table based on email
      $stmt = $db->prepare('SELECT * FROM registration_token WHERE email=:email');
      $stmt->bindParam(":email",$user_email);
      $result = $stmt->execute();

      $count=0;
      while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $count++;
	    if ($count==1) {
	      $hashed_reg_code=$row['reg_code'];
          $hashed_password=password_hash($user_password,PASSWORD_DEFAULT);
	    }
      }

      if ($count==1) { //email exists
    	//RegCode
        if (password_verify($reg_code,$hashed_reg_code)) { // if reg code is same as get_reg_code
          echo "<p style='color:green'>registration code is valid</p>";
        } else { //reg code is not valid
          echo "<p style='color:red'>Incorrect Registration Code</p>";
          $error=1;
        }
        //Change password
       	if ($error==0) {
     	  echo "<p style='color:blue'>Password change Successful! You can now log in with your new password. </p>";
	  echo "<a href='login_register_form.php'>Back to Login Page</a>";

          //change password based on existing email
          $stmt = $db->prepare("UPDATE mates SET password=:password WHERE email=:email");
          $stmt->bindParam(":email",$user_email);
          $stmt->bindParam(":password",$hashed_password);
      	  $result = $stmt->execute();

          //Delete from registration token based on email
          $stmt = $db->prepare("DELETE FROM registration_token WHERE email=:email");
      	  $stmt->bindParam(":email",$user_email);
      	  $result = $stmt->execute();
        }
      } else {
        echo "<p style='color:red'>Email not found: incorrect email entered or code is expired</p>";
        $error=1;
      }
    } catch (Exception $e) {
      echo "<br>Error X_x<br>";
      echo $e->getMessage();
    }

//none, return to login/register
  } else {
    header("Location: login_register_form.php");
    exit;
  }
  echo "<a href='reset_password_form.php'>Back to Reset Password Page</a>";

?>

