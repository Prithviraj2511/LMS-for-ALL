<?php
if (isset($_POST['stu_update'])) {
    session_start();
    include "../../../connectDatabase.php";
    $id = $_POST['stu_id'];
    $access = $_POST['stu_access'];
    $name = $_POST['stu_name'];
    $email = $_POST['stu_email'];
    $phone=$_POST['stu_phone'];

    $accounts = $db->studentAccounts;
    $result = $accounts->updateOne(
        ["_id" => new MongoDB\BSON\ObjectID($id)],
        ['$set' =>
            [
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "accessId" => $access,
            ]
        ]
    );
} elseif (isset($_POST['stu_delete'])) {
    session_start();
    include "../../../connectDatabase.php";
    $id = $_POST['stu_id'];
    $access = $_POST['stu_access'];
    $accounts = $db->studentAccounts;
    $result = $accounts->deleteOne(["_id" => new MongoDB\BSON\ObjectID($id)]);
    $folders = $db->folders;
    $result=$folders->updateOne(
        ["_id" => new MongoDB\BSON\ObjectID($access)],
        ['$pull' => ["content" => $id]]
    );
} else {
    header("Location: ../../404.html");
    exit();
}
