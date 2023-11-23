<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("PHPMailer/src/Exception.php");
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");


$mail = new PHPMailer(true);

$mail->IsSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true;
//$mail->Username="my@gmail.com";
//$mail->Password="mypassword";
$mail->SMTPSecure="ssl";
$mail->Port=465;

$mail->setFrom("my@gmail.com");

$mail->addAddress("targetaddress@gmail.com");

$mail->isHTML(true);

$mail->Subject="My Subject";

$mail->Body="My message";


//$mail->send();


echo "Mail Sent!";
?>
