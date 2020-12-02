<?php

if ($_POST["sign-in"]) {

    include "connect.php";
    $pass = $_POST['pass'];
    $email = $_POST["email"];
    $authority = $_POST['authority'];
    if ($authority == "student") {
        
        if ($db->studentAccounts->count(["email" => $email]) == 0) {
            header("Location: signin-signup.php?error=accountDoesnotExist");
            exit();
        } else {
            $cursor = $db->studentAccounts->find(["email" => $email]);
            foreach ($cursor as $users) {
                $pwdCheck = password_verify($pass, $users['password']);
                if ($pwdCheck == false) {
                    header("Location: signin-signup.php?error=wrongPassword&email=".$email);
                    exit();
                } elseif ($pwdCheck == true) {
                    $db->studentAccounts->updateOne([
                        '_id'=>$users['_id']
                    ],[
                        '$set'=>['lastSeen'=>new MongoDB\BSON\UTCDateTime()]
                    ]);
                    session_start();
                    $_SESSION['stuid'] = $users['_id'];
                    $_SESSION['username'] = $users['name'];
                    $_SESSION['clg_id']=$users['clgId'];
                    $_SESSION['clgname'] = $users['clgname'];
                    $_SESSION['accessId']=$users['accessId'];
                    $_SESSION['userEmail']=$users['email'];
                    header("Location: ../student/dashboardHome.php?login=success");
                    exit();
                } else {
                    header("Location: signin-signup.php?error=wrongPassword&email=".$email);
                    exit();
                }
            }
        }
    } elseif ($authority == "teacher") {
       
        if ($db->teacherAccounts->count(["email" => $email]) == 0) {
            header("Location: signin-signup.php?error=accountDoesnotExist");
            exit();
        } else {
            $cursor = $db->teacherAccounts->find(["email" => $email]);
            foreach ($cursor as $users) {
                $pwdCheck = password_verify($pass, $users['password']);
                if ($pwdCheck == false) {
                    header("Location: signin-signup.php?error=wrongPassword&email=".$email);
                    exit();
                } elseif ($pwdCheck == true) {
                    $db->teacherAccounts->updateOne([
                        '_id'=>$users['_id']
                    ],[
                        '$set'=>['lastSeen'=>new MongoDB\BSON\UTCDateTime()]
                    ]);
                    session_start();
                    $_SESSION['teacherid'] = $users['_id'];
                    $_SESSION['username'] = $users['name'];
                    $_SESSION['clg_id']=$users['clgId'];
                    $_SESSION['clgname'] = $users['clgname'];
                    $_SESSION['accessId']=$users['accessId'];
                    $_SESSION['userEmail']=$users['email'];
                    header("Location: ../teacher/dashboardHome.php?login=success");
                    exit();
                } else {
                    header("Location: signin-signup.php?error=wrongPassword&email=".$email);
                    exit();
                }
            }
        }
    } elseif ($authority == "admin") {
        
        if ($db->accounts->count(["email" => $email]) == 0) {
            header("Location: signin-signup.php?error=accountDoesnotExist");
            exit();
        } else {
            $cursor = $db->accounts->find(["email" => $email]);
            foreach ($cursor as $users) {
                $pwdCheck = password_verify($pass, $users['password']);
                if ($pwdCheck == false) {
                    header("Location: signin-signup.php?error=wrongPassword&email=".$email);
                    exit();
                } elseif ($pwdCheck == true) {
                    session_start();
                    $_SESSION['adminid'] = $users['_id'];
                    $_SESSION['clgname'] = $users['name'];
                    $_SESSION['accessId']=$users['accessId'];
                    header("Location: ../admin/dashboardHome.php?login=success");
                    exit();
                } else {
                    header("Location: signin-signup.php?error=wrongPassword&email=".$email);
                    exit();
                }
            }
        }
    }
} else {
    header("Location: signin-signup.php");
    exit();
}
