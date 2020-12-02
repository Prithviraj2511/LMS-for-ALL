<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$to="prithvirajpatil2511@gmai.com";
$subject="PHP mail";
$message="Hi mail from php";
$from="From: voidpp25@gmail.com";
if(mail($to,$subject,$message,$from)){
    echo "Mail successfully sent";
}
else{
    echo "failed to send mail";
}
?>