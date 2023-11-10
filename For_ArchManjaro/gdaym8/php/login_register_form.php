<?php
  //kick out logged in user
  //session_start();
  //$is_logged_in = $_SESSION["username"];
  //echo $is_logged_in;


  /*if ($is_logged_in!=false) {
    header("Location: https://gdaym8.site");
    exit;
  }*/

  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
  DrawNavBar(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Join In!</title>
  <script>
//Client-side Validation
//Login
function ValidateLoginInput() {
  var form = document.form_post_login;
  var user_name = form.inputUsername.value;
  var user_password = form.inputPassword.value;
  var userNameErrorBox = document.getElementById("userNameErrorBox");
  var userPasswordErrorBox = document.getElementById("userPasswordErrorBox");

  var no_error=true;
  //username is empty
  if (user_name.length<1) {
    no_error=false;
    userNameErrorBox.innerHTML="Username Cannot Be Empty";
  } else {
    userNameErrorBox.innerHTML="";
  }

  //password is empty
  if (user_password.length<1) {
    no_error=false;
    userPasswordErrorBox.innerHTML="Password Cannot Be Empty";
  } else {
    userPasswordErrorBox.innerHTML="";
  }

  return no_error;
}


//Get Code
function ValidateEmail(mail) {
  let regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return regex.test(mail);
}

function ValidatePassword(pw) {
  let regex=/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
  return regex.test(pw);
}

function ValidateGetRegisterCode() {
  var form=document.form_post_get_code;
  var email=form.inputGetCodeEmail.value;
  var password=form.inputGetCodePassword.value;
  var confirm_password=form.inputGetCodeRetypePassword.value;
  var emailErrorBox=document.getElementById("getCodeEmailErrorBox");
  var passwordErrorBox=document.getElementById("getCodePasswordErrorBox");
  var confirmPasswordErrorBox=document.getElementById("getCodeRetypePasswordErrorBox");

  var no_error=true;

  //invalid email
  if (!ValidateEmail(email)) {
    no_error=false;
    emailErrorBox.innerHTML="Invalid Email Entered";
  } else {
    emailErrorBox.innerHTML="";
  }

  //weak password
  if (!ValidatePassword(password)) {
    isError=false;
    passwordErrorBox.innerHTML="Password must contain uppercase, lowercase, numerical and special characters";
  } else {
    passwordErrorBox.innerHTML="";
  }

  if (password.length<8) {
    isError=false;
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

  return no_error;
}



//Register
function ValidateUsername(name) {
  let regex=/^[A-Za-z0-9_]{1,16}$/;
  return regex.test(name);
}



function ValidateRegistration() {
  var no_error=true;
  var form=document.form_post_register;
  var reg_code=form.inputRegCode.value;
  var email=form.inputRegEmail.value;
  var username=form.inputRegUsername.value;
  var password=form.inputRegPassword.value;
  var regCodeErrorBox=document.getElementById("regRegCodeErrorBox");
  var emailErrorBox=document.getElementById("regEmailErrorBox");
  var usernameErrorBox=document.getElementById("regUsernameErrorBox");
  var passwordErrorBox=document.getElementById("regPasswordErrorBox");

  //reg code cannot be empty
  if (reg_code.length<1) {
    no_error=false;
    regCodeErrorBox.innerHTML="Registration Code cannot be Empty";
  } else {
    regCodeErrorBox.innerHTML="";
  }

  //email cannot be empty
  if (email.length<1) {
    no_error=false;
    emailErrorBox.innerHTML="Email Cannot be Empty";
  } else {
    emailErrorBox.innerHTML="";
  }


  //username regex
  if (!ValidateUsername(username)) {
    no_error=false;
    usernameErrorBox.innerHTML="Username must be alphanumeric, up to 16 characters, and could contain underscores('_')"
  } else {
    usernameErrorBox.innerHTML="";
  }


  //password cannot be empty
  if (password.length<1) {
    no_error=false;
    passwordErrorBox.innerHTML="Password Cannot Be Empty";
  } else {
    passwordErrorBox.innerHTML="";
  }

  return no_error;
}


  </script>
</head>
<body>
  <h2>Login</h2>
  <form name="form_post_login" method="post" action="login_register.php" onsubmit="return ValidateLoginInput()">
    <div>Username or Email
      <p><input id="inputUsername" name="inputUsername" value=""></p>
      <p id="userNameErrorBox" style="color:red"></p>
    </div>

    <div>Password
      <p><input type="password" id="inputPassword" name="inputPassword" value=""></p>
      <p id="userPasswordErrorBox" style="color:red"></p>
    </div>

    <div>
      <p><input type="submit" id="btnSubmitLogin" name="btnSubmitLogin" value="Submit"></p>
    </div>
  </form>
  <br>

  <h2>Get Registration Code</h2>
  <form name="form_post_get_code" method="post" action="login_register.php" onsubmit="return ValidateGetRegisterCode()">
    <div>Email
      <p><input id="inputGetCodeEmail" name="inputGetCodeEmail" value=""></p>
      <p id="getCodeEmailErrorBox" style="color:red"></p>
    </div>

    <div>Enter New Password
      <p><input type="password" id="inputGetCodePassword" name="inputGetCodePassword" value=""></p>
      <p id="getCodePasswordErrorBox" style="color:red"></p>
    </div>

    <div>Retype Password
      <p><input type="password" id="inputGetCodeRetypePassword" name="inputGetCodeRetypePassword" value=""></p>
      <p id="getCodeRetypePasswordErrorBox" style="color:red"></p>
    </div>

    <div>
      <p><input type="submit" id="btnSubmitGetCode" name="btnSubmitGetCode" value="Submit"></p>
    </div>
  </form>
  <br>

  <h2>Registration</h2>
  <form name="form_post_register" method="post" action="login_register.php" onsubmit="return ValidateRegistration()">
    <div>Registration Code
      <p><input id="inputRegCode" name="inputRegCode" value=""></p>
      <p id="regRegCodeErrorBox" style="color:red"></p>
    </div>

    <div>Email
      <p><input id="inputRegEmail" name="inputRegEmail" value=""></p>
      <p id="regEmailErrorBox" style="color:red"></p>
    </div>

    <div>Enter New Username
      <p><input id="inputRegUsername" name="inputRegUsername" value=""></p>
      <p id="regUsernameErrorBox" style="color:red"></p>
    </div>

    <div>Password
      <p><input type="password" id="inputRegPassword" name="inputRegPassword" value=""></p>
      <p id="regPasswordErrorBox" style="color:red"></p>
    </div>

    <div>
      <p><input type="submit" id="btnSubmitRegister" name="btnSubmitRegister" value="Submit"></p>
   </div>
  </form>
  <br>

</body>
</html>
