<?php
$to_email = $_POST['email'];
$subject = "Contact from website".$_POST['name'];
$body = $_POST['message'];
$headers = "From: prithvirajpatil2511@gmail.com";

if (mail($to_email, $subject, $body, $headers)) {
    header("Location: index.html?email=success");
} else {
    header("Location: index.html?email=failure");
}