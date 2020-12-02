<?php
if (isset($_POST['teacher_update'])) {
    session_start();
    include "../../../connectDatabase.php";
    $id = $_POST['teacher_id'];
    $access = $_POST['teacher_access'];
    $name = $_POST['teacher_name'];
    $email = $_POST['teacher_email'];
    $phone=$_POST['teacher_phone'];

    $accounts = $db->teacherAccounts;
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
} elseif (isset($_POST['teacher_delete'])) {
    session_start();
    include "../../../connectDatabase.php";
    $id = $_POST['teacher_id'];
    $access = $_POST['teacher_access'];
    $accounts = $db->teacherAccounts;
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
