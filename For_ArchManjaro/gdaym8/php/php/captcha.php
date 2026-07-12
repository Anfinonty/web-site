<?php
  //include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";



//Captcha Question
    $captcha_q_arr=array(
"Which Australian City was the Band AC/DC formed?",
"Which Australian City was the Band Pendulum formed?",
"What year was the Australian Band Wolfmother formed?",
"What is x when 5x+3=28? Give your answer in english words (i.e. one).",
"<img src='images/kangaroos.jpg'></img><br>How many kangaroos are in this picture? Give your answer in english words (i.e. one)."
);



//Captcha Answers
    $captcha_arr=array(
"Sydney",
"Perth",
"2004",
"five",
"eight"
);

  session_start();
  $RAND_CAPTCHA=rand(0,sizeof($captcha_q_arr)-1);
  $_SESSION["captcha_question"]=$captcha_q_arr[$RAND_CAPTCHA];
  //$_SESSION["captcha"]=password_hash($captcha_arr[$RAND_CAPTCHA],PASSWORD_DEFAULT);
  $_SESSION["captcha"]=$captcha_arr[$RAND_CAPTCHA];

  echo $_SESSION["captcha_question"]."<br>";
//  echo $_SESSION["captcha"];
?>
