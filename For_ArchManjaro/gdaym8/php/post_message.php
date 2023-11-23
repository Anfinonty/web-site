<?php
//Posting
  include $_SERVER['DOCUMENT_ROOT']."/php/user_header.php";
  if (isset($_POST['btnSubmit'])){
    session_start();
    //user credentials
    $date_time_now=gmdate("Y/m/d H:i:s");
    $user_post_msg=$_POST["txthere"];
    $entered_captcha=$_POST["captcha"];
    $enter="\n";
    $user_post_msg=preg_replace("/{$enter}/i","<br>",$user_post_msg);
    $user_post_msg=ChatShortcuts($user_post_msg);
    $user_msg=$SELF_USER_NAME."\n".$date_time_now."\n".$user_post_msg."\r";//ensures no incomplete html overflow

    if (strlen($user_post_msg)>0) {//not blank
      if (password_verify($entered_captcha,$_SESSION["captcha"])) {
//      if ($entered_captcha==$_SESSION["captcha"]) {
        $fp=fopen($GLOBAL_CHAT_DIR."/".time().".txt","a"); //open in write mode
        if  (fwrite($fp, $user_msg)) {
          echo "Posted!";
        } else {
          echo "Post Unsuccessful :(";
        }
       fclose($fp);
     } else {
       echo "Captcha is incorrect D:";
     }
    }
  }
  header("Location: post_message_form.php");
?>
