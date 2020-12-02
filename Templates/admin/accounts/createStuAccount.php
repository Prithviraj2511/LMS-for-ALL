<?php
session_start();
if (isset($_POST['stu_account'])) {
    include "../../../connectDatabase.php";
    //form data

    $pass = $_POST['stu_pass'];
    $name = $_POST['stu_name'];
    $email = $_POST['stu_email'];
    $access = $_POST['stu_access'];
    $phone = $_POST['stu_phone'];
    //password hashing
    $hashedpass = password_hash($pass, PASSWORD_DEFAULT);

    $accounts = $db->studentAccounts;
    // insert to student collection
    $result = $accounts->insertOne([
        "name" => $name,
        "clgname" => $_SESSION['clgname'],
        "clgId"=>$_SESSION["user_id"],
        "email" => $email,
        "phone" => $phone,
        "accessId" => $access,
        "password" => $hashedpass,
    ]);
    $result;
    // add student id to the folders collection
    $folders = $db->folders;
    $res=$folders->findOne(['_id'=> new MongoDB\BSON\ObjectID($access)]);
    $stu_count=$res['stu_count'];
    $result=$folders->updateOne(
        ["_id" => new MongoDB\BSON\ObjectID($access)],
        ['$push' => ["content" => $result->getInsertedId()],
        '$set'=>['stu_count'=>$stu_count+1]
        ]
    );
    header("Location: ./manageAccounts.php");
} else {
    header("Location: ../../404.html");
    exit();
}
