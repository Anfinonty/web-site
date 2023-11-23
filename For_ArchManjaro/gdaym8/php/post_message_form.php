
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
 ?>

<html>
<head>
  <script src="/script/globalChatScript.js"></script>
</head>
<body>
  <button id="cleartxt" onclick="ClearTxtButton()">Clear</button><br>
  <form method="post" id="form1" name="form1" action="/php/post_message.php">
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Say Something" onclick="SubmitMsg(this)"></input>
    <textarea onfocus="TxtHereOnFocus()" onblur="TxtHereOnBlur()" id="txthere" name="txthere" rows="4" cols="80" value="" maxlength="9001"></textarea>
    <br><input placeholder="Answer to Say Something" name="captcha"></input>
    <?php
//Captcha Question
    $captcha_q_arr=array(
"Which Australian City was the Band AC/DC formed?",
"Which Australian City was the Band Pendulum formed?",
"What year was the Australian Band Wolfmother formed?",
"What is x when 5x+3=28? Give your answer in english words (i.e. One).",
"<img height='64px' src='/images/kangaroos.jpg'></img>How many kangaroos are in this picture? Give your answer in english words (i.e. One).",
"What is the slang for McDonald's in Australia?",
"This sentense is spelled correctly. True/False",
"<img height='64px' src='/images/paste.jpg'></img>What do Australians put on bread?"
);


//Captcha Answers
    $captcha_arr=array(
"Sydney",
"Perth",
"2004",
"Five",
"Eight",
"Macca's",
"False",
"Vegemite"
);
      $RAND_CAPTCHA=rand(0,sizeof($captcha_q_arr)-1);
      $_SESSION["captcha_question"]=$captcha_q_arr[$RAND_CAPTCHA];
      $_SESSION["captcha"]=password_hash($captcha_arr[$RAND_CAPTCHA],PASSWORD_DEFAULT);
      //$_SESSION["captcha"]=$captcha_arr[$RAND_CAPTCHA];
      echo $_SESSION["captcha_question"]."<br>";
      //echo $_SESSION["captcha"];
    ?>


  </form>
</html>
