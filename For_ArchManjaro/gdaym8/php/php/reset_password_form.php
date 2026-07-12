<?php
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
  DrawNavBar(); 

//Captcha Question
    $gen_rand_string=strval(GenRandString(8));
    $captcha_q_arr=array("Type: ".$gen_rand_string);


//Captcha Answers
    $captcha_arr=array($gen_rand_string);
    $RAND_CAPTCHA=rand(0,sizeof($captcha_q_arr)-1);
    $_SESSION["captcha_question"]=$captcha_q_arr[$RAND_CAPTCHA];
    $_SESSION["captcha"]=password_hash($captcha_arr[$RAND_CAPTCHA],PASSWORD_DEFAULT);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <script>
//Client-side Validation


//Get Code
function ValidateEmail(mail) {
  let regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return regex.test(mail);
}

function ValidateGetResetPassword() {
  var form = document.form_post_getResetPasswordCode;

  var email = form.inputEmail.value;

  var emailErrorBox = document.getElementById("userEmailErrorBox");

  var no_error=true;

  //email cannot be empty
  if (email.length<1) {
    no_error=false;
    emailErrorBox.innerHTML="Email Cannot be Empty";
  } else {
    emailErrorBox.innerHTML="";
  }

  //invalid email
  if (!ValidateEmail(email)) {
    no_error=false;
    emailErrorBox.innerHTML="Invalid Email Entered";
  } else {
    emailErrorBox.innerHTML="";
  }

  var captcha = form.captcha.value;
  var captchaErrorBox = document.getElementById("captchaErrorBox1");
  if (captcha.length<1) {
    no_error=false;
    captchaErrorBox.innerHTML="Captcha Cannot Be Empty";
  } else {
    captchaErrorBox.innerHTML="";
  }


  return no_error;
}


function ValidatePassword(pw) {
  let regex=/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
  return regex.test(pw);
}


function ValidateResetPassword() {
  var form=document.form_post_resetPassword;

  var reg_code=form.inputRegCode.value;
  var email=form.inputRegEmail.value;
  var password=form.inputRegPassword.value;
  var confirm_password=form.inputRegRetypePassword.value;

  var regCodeErrorBox=document.getElementById("regRegCodeErrorBox");
  var emailErrorBox=document.getElementById("regEmailErrorBox");
  var passwordErrorBox=document.getElementById("regPasswordErrorBox");
  var confirmPasswordErrorBox=document.getElementById("regRetypePasswordErrorBox");

  var no_error=true;


  //reg code cannot be empty
  if (reg_code.length<1) {
    no_error=false;
    regCodeErrorBox.innerHTML="Registration Code cannot be Empty";
  } else {
    regCodeErrorBox.innerHTML="";
  }


  //invalid email
  if (!ValidateEmail(email)) {
    no_error=false;
    emailErrorBox.innerHTML="Invalid Email Entered";
  } else {
    emailErrorBox.innerHTML="";
  }

  //weak password
  if (!ValidatePassword(password)) {
    no_error=false;
    passwordErrorBox.innerHTML="Password must contain uppercase, lowercase, numerical and special characters";
  } else {
    passwordErrorBox.innerHTML="";
  }

  if (password.length<8) {
    no_error=false;
    passwordErrorBox.innerHTML="Password must be more than 8 or more characters long";
  } else {
    passwordErrorBox.innerHTML="";
  }


  //must be matching with password
  if (password!=confirm_password) {
    no_error=false;
    confirmPasswordErrorBox.innerHTML="Passwords Must Match";
  } else {
    confirmPasswordErrorBox.innerHTML="";
  }

  var captcha = form.captcha.value;
  var captchaErrorBox = document.getElementById("captchaErrorBox2");
  if (captcha.length<1) {
    no_error=false;
    captchaErrorBox.innerHTML="Captcha Cannot Be Empty";
  } else {
    captchaErrorBox.innerHTML="";
  }


  return no_error;
}


  </script>
</head>
<body class="main_body">
<div class="main_body_background"></div>
  <h2>Reset Password Request</h2>
  <form name="form_post_getResetPasswordCode" method="post" action="reset_password.php" onsubmit="return ValidateGetResetPassword()">
    <div>Email
      <p><input id="inputEmail" name="inputEmail" value=""></p>
      <p id="userEmailErrorBox" style="color:red"></p>
    </div>

    <div class="type_captcha">Captcha
    <p><input placeholder="Type Captcha Here" name="captcha">    
<?php
    echo $_SESSION["captcha_question"];
?>
    </p>
    <p id="captchaErrorBox1" style="color:red"></p>
    </div>

    <div>
      <p><input type="submit" id="btnSubmitReqResetPassword" name="btnSubmitReqResetPassword" value="Submit"></p>
    </div>
  </form>
  <br>


  <h2>Reset Password</h2>
  <form name="form_post_resetPassword" method="post" action="reset_password.php" onsubmit="return ValidateResetPassword()">
    <div>Reset Password Request Code
      <p><input id="inputRegCode" name="inputRegCode" value=""></p>
      <p id="regRegCodeErrorBox" style="color:red"></p>
    </div>

    <div>Email
      <p><input id="inputRegEmail" name="inputRegEmail" value=""></p>
      <p id="regEmailErrorBox" style="color:red"></p>
    </div>

    <div>Enter New Password
      <p><input type="password" id="inputRegPassword" name="inputRegPassword" value=""></p>
      <p id="regPasswordErrorBox" style="color:red"></p>
    </div>

    <div>Retype Password
      <p><input type="password" id="inputRegRetypePassword" name="inputRegRetypePassword" value=""></p>
      <p id="regRetypePasswordErrorBox" style="color:red"></p>
    </div>

    <div class="type_captcha">Captcha
    <p><input placeholder="Type Captcha Here" name="captcha">    
<?php
    echo $_SESSION["captcha_question"];
?>
    </p>
    <p id="captchaErrorBox2" style="color:red"></p>
    </div>

    <div>
      <p><input type="submit" id="btnSubmitResetPassword" name="btnSubmitResetPassword" value="Submit"></p>
   </div>
  </form>
  <br>

</body>
</html>
