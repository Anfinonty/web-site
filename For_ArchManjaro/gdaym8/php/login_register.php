<?php
//kick out logged in user
  if (!is_null($_SESSION["username"] ?? null)) {
    header("Location: user_act_folder.php");
    exit;
  }

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require("PHPMailer/src/Exception.php");
  require("PHPMailer/src/PHPMailer.php");
  require("PHPMailer/src/SMTP.php");


  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
  DrawNavBar();
//login
  if (isset($_POST["btnSubmitLogin"])) {
    echo "<h1>Log In Status: <br></h1>";
    //echo $USER_SESSION_DIR."<br>";
    $user_name=$_POST["inputUsername"];
    $user_password=$_POST["inputPassword"];
    $error=0;

    try {
      $db = new SQLITE3('/var/www/db/mydatabase.sqlite');

      //$stmt = $db->prepare('SELECT * FROM mates');
      //$stmt->bindParam(":username",$user_name);
      //$stmt->bindParam(":email",$user_name);

      $stmt = $db->prepare('SELECT * FROM mates WHERE username=:username OR email=:email');
      $stmt->bindParam(":username",$user_name);
      $stmt->bindParam(":email",$user_name);
      $result = $stmt->execute();
      $fetched_username = -1;
      $hashed_password = -1;

      $count=0;
      while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
	$count++;
	if ($count==1) {
	  $fetched_username=$row["username"];
	  $hashed_password=$row["password"];
	}
	//echo $row["username"]." -- ".$row["password"];
      }

      //echo $fetched_username." :: ".$hashed_password;

      if ($count>0 && $hashed_password!=-1 && $fetched_username!=-1) {
	if (!password_verify($user_password,$hashed_password)) {
	  $error=1;
	}
      } else {
	$error=1;
      }

      if ($error==0) { //logged in, go to act folder
	$_SESSION["username"]=$fetched_username;
	echo "<p> Welcome, ".$_SESSION["username"]."</p>";
	mkdir($GLOBAL_FOLDER."/".$fetched_username,0755,true);
	header("Location: user_act_folder.php");
	exit;
      } else {
	echo "<p style='color:red'> Incorrect Username or Password </p>";
      }
    } catch (Exception $e) {
      echo "<br>Error X_x<br>";
      echo $e->getMessage();
    }

    //$error=0;
    //echo $user_name.":".$user_password;

// Get Registration Code
  } else if (isset($_POST["btnSubmitGetCode"])) {
    echo "<h1>Registration Code Status:</h1>";
    $user_email=$_POST["inputGetCodeEmail"];
    $user_password=$_POST["inputGetCodePassword"];
    $user_retype_password=$_POST["inputGetCodeRetypePassword"];
    $error=0;

    //email
    $regex_valid_email="/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/";
      //if () {
        //echo "<p style='color:red'>Email already in use</p>";
        //$error=1;
      //} else {
    if (preg_match($regex_valid_email,$user_email)) {
      echo "<p style='color:green'>Valid email entered</p>";
    } else {
      echo "<p style='color:red'>Invalid email entered</p>";
      $error=1;
    }
      //}

    //Password
    if ($user_password==$user_retype_password) {
      echo "<p style='color:green'>password match</p>";
      if (7<strlen($user_password) && strlen($user_password)<17) {
        echo "<p style='color:green'>password has valid length</p>";
        $regex_valid_password="/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
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

    if ($error==0) {
      $reg_code=GenRandString(16);

      try {
        $db = new SQLITE3('/var/www/db/mydatabase.sqlite');

        //======Actual User Database :D
        // $db->exec("DROP TABLE mates");
   	// $db->exec("CREATE TABLE mates (username STRING VARCHAR(16) UNIQUE NOT NULL, nickname STRING VARCHAR(64), email STRING VARCHAR(320) UNIQUE NOT NULL, password STRING VARCHAR(255) NOT NULL)");
   	// $db->exec("INSERT INTO mates (username,nickname,email,password) VALUES ('skyturtle','sky','alienboi2726@gmail.com','idklol')");

      //======Registration Token Commands
        //$db->exec("DROP TABLE registration_token");
        //$db->exec("CREATE TABLE registration_token (email STRING VARCHAR(320) UNIQUE NOT NULL, reg_code STRING VARCHAR(255) NOT NULL, password STRING VARCHAR(255) NOT NULL, expiry_time INT NOT NULL)");

        //Remove all old tokens
        $stmt = $db->prepare("DELETE FROM registration_token WHERE expiry_time<:time");
        $time_now=time();
        $stmt->bindParam(":time",$time_now);
        $result = $stmt->execute();

        $expiry_time = time()+120;


        $hash_reg_code = password_hash($reg_code,PASSWORD_DEFAULT);
        $hash_password = password_hash($user_password,PASSWORD_DEFAULT);


        //check if email already exists in mates db
        $stmt = $db->prepare("SELECT email FROM mates WHERE email=:email");
        $stmt->bindParam(":email",$email);
        $result = $stmt->execute();
        $count=0;
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
          $count++;
        }

        if ($count>0) { //Error: user is already registered in the database
          echo "<p style='color:red'>This email is already registered in the database, try another email</p>";
        } else { //Add to database
          //check if email aready exists
          $stmt = $db->prepare("SELECT email FROM registration_token WHERE email=:email");
          $stmt->bindParam(":email",$user_email);
          $result = $stmt->execute();

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

	//Send email
      	  $mail = new PHPMailer(true);
      	  $mail->IsSMTP();
      	  $mail->Host='smtp.gmail.com';
      	  $mail->SMTPAuth=true;
      	  $mail->Username="my_email.com";
      	  $mail->Password="my_email_password";
      	  $mail->SMTPSecure="ssl";
      	  $mail->Port=465;

      	  $mail->setFrom("johndoe627862@gmail.com");
      	  //$mail->setFrom("Fey");

      	  $mail->addAddress($user_email);

      	  $mail->isHTML(true);

      	  $mail->Subject="G'day M8! Here's your Registration Code! :D";

      	  $mail->Body="Fey: G'day M8! Here's your Registration Code! Enter it in the Registration Section within 2 minutes to Register your Account: ".$reg_code;

          if ($mail->Send()) {
          //$mail->send();
            echo "<p style='color:green'>Code has been sent to your E-mail! :D</p>";
          } else {
            echo "<p style='color:red'>Failed to Send E-mail,, D:<p>";
          }
        }


      } catch (Exception $e) {
        echo "<br>Error X_x<br>";
        echo $e->getMessage();
      }
    }

// Register
  } else if (isset($_POST["btnSubmitRegister"])) {
    echo "<h1>Register Status:</h1>";

  //user credentials
    $reg_code=$_POST["inputRegCode"];
    $user_email=$_POST["inputRegEmail"];
    $user_name=$_POST["inputRegUsername"];
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
	  $hashed_password=$row['password'];
	}
      }

      if ($count>0) { //email exists
	echo "<p style='color:green'>Email is found</p>";

    	//RegCode
        if (password_verify($reg_code,$hashed_reg_code)) { // if reg code is same as get_reg_code
          echo "<p style='color:green'>registration code is valid</p>";
        } else { //reg code is not valid
          echo "<p style='color:red'>Incorrect Registration Code</p>";
          $error=1;
        }

        //Usernames in mates
        if (0<strlen($user_name) && strlen($user_name)<17) {
          echo "<p style='color:green'>username has valid length</p>";
          $regex_valid_username="/^[A-Za-z0-9_]{1,16}$/";
          if (preg_match($regex_valid_username,$user_name)) {
            echo "<p style='color:green'>username is valid</p>";

	    //check if username already exists 1
      	    $stmt = $db->prepare('SELECT username FROM mates WHERE username=:username');
      	    $stmt->bindParam(":username",$user_name);
      	    $result = $stmt->execute();

      	    $_count=0;
      	    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
              $_count++;
      	    }

	    //check if username already exists 2
	    /*if (is_dir($GLOBAL_FOLDER."/".$username)) {
	      $_count++;
            }*/

	    if ($_count==0) {
	      echo "<p style='color:green'>username is unique</p>";
	    } else {
	      echo "<p style='color:red'>username already exists, please try another</p>";
	      $error=1;
            }
          } else {
            echo "<p style='color:red'>username must be alphanumeric, and could contain underscores ('_')</p>";
            $error=1;
          }
        } else {
          echo "<p style='color:red'>username must be 1-16 characters long</p>";
          $error=1;
        }

        //Password
        if (password_verify($user_password,$hashed_password)) {
          echo "<p style='color:green'>Password match</p>";
        } else {
          echo "<p style='color:red'>Incorrect password</p>";
          $error=1;
      	}

        //Add to Registered Users
   	if ($error==0) {
     	  echo "<p style='color:blue'>Registration Successful!</p>";
     	  //Add to mates db
   	  $stmt = $db->prepare("INSERT INTO mates (username,nickname,email,password) VALUES (:username,'',:email,:password)");
      	  $stmt->bindParam(":username",$user_name);
      	  $stmt->bindParam(":email",$user_email);
      	  $stmt->bindParam(":password",$hashed_password);
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

  echo "<a href='login_register_form.php'>Back to Join Page</a>";
?>
