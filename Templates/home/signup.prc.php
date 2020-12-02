<?php
if (isset($_POST["signup-submit"])) {
    include "connect.php";
    $pass = $_POST['signup-password'];
    $repeatpass = $_POST['repeat-password'];
    $email = filter_var($_POST["clg-email"], FILTER_SANITIZE_EMAIL);
    $phone=$_POST['phone'];
    $clgname = $_POST['clg-name'];
    if(strlen($pass)>12){
        header("Location: signin-signup.php?error=passwordLenghtexcedeed&clgname=" . $clgname."&email=" . $email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9 ]*$/", $clgname)) {
        header("Location: signin-signup.php?error=invalidclgnameemail");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signin-signup.php?error=invalidemail&clgname=" . $clgname);
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $clgname)) {
        header("Location: signin-signup.php?error=invalidclgname&email=" . $email);
        exit();
    } else if ($pass !== $repeatpass) {
        header("Location: signin-signup.php?error=passwordmismatch&email=" . $email . "&clgname=" . $clgname);
        exit();
    } else {
        $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
        $accounts=$db->newAccounts;
        $result=$accounts->insertOne([
            "name"=>$clgname,
            "email"=>$email,
            "phone"=>$phone,
            "password"=>$hashedpass
        ]);
        header("location: signin-signup.php?signup=success");
        exit();
    }
} else {
    header("location: signin-signup.php?error=somethingWentWrong");
    exit();
}
