<?php
session_start();
if (isset($_POST['teacher_account'])) {
    include "../../../connectDatabase.php";
    //form data

    $pass = $_POST['teacher_pass'];
    $name = $_POST['teacher_name'];
    $email = $_POST['teacher_email'];
    $access = $_POST['teacher_access'];
    $phone = $_POST['teacher_phone'];
    //password hashing
    $hashedpass = password_hash($pass, PASSWORD_DEFAULT);

    $accounts = $db->teacherAccounts;
    // insert to student collection
    $result = $accounts->insertOne([
        "name" => $name,
        "clgname" => $_SESSION['clgname'],
        "clgId"=>$_SESSION["user_id"],
        "email" => $email,
        "phone" => $phone,
        "accessId" => $access,
        "password" => $hashedpass
    ]);
    $result;
    // add student id to the folders collection
    $folders = $db->folders;
    $res=$folders->findOne(['_id'=> new MongoDB\BSON\ObjectID($access)]);
    $teacher_count=$res['teacher_count'];
    $result=$folders->updateOne(
        ["_id" => new MongoDB\BSON\ObjectID($access)],
        ['$push' => ["content" => $result->getInsertedId()],
        '$set'=>['teacher_count'=>$teacher_count+1]
        ]
    );
    header("Location: ./manageAccounts.php");
} else {
    header("Location: ../../404.html");
    exit();
}
