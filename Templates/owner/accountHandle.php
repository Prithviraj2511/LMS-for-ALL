<?php
if (isset($_POST["confirm"])) {
    include "connect.php";
    $result=$db->folders->insertOne([
        "type"=>"folder",
        "folder-name"=>"general",
        "content"=>[]
    ]);
    $id=$result->getInsertedId();
    $cursor = $db->accounts->insertOne([
        "accessId"=>$id,
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "phone"=>$_POST['phone'],
        "password" => $_POST['password'],
        "subjects"=>[]
    ]);
    $cursor = $db->newAccounts->deleteOne([
        "_id" => new MongoDB\BSON\ObjectId($_POST['id'])
    ]);
    header("Location: owner.php");
    exit();
}
elseif(isset($_POST["reject"])){
    include "connect.php";
    $cursor = $db->newAccounts->deleteOne([
        "_id" => new MongoDB\BSON\ObjectId($_POST['id'])
    ]);
    header("Location: owner.php");
    exit();
} 
elseif (isset($_POST["deleteAccount"])) {
    include "connect.php";
    header("Location: owner.php");
    exit();
} elseif (isset($_POST["updateAccount"])) {
    include "connect.php";
    $cursor = $db->accounts->updateOne([
        "_id" => new MongoDB\BSON\ObjectId($_POST['id'])
    ], ['$set' => ["name" => $_POST['name'], "email" => $_POST['email'],"phone"=>$_POST['phone']]
    ]);
    header("Location: owner.php");
    exit();
} else {
    header("Location: owner.php");
    exit();
}
