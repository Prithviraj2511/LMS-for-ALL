<?php
if (isset($_POST["confirm"])) {
    include "connect.php";
    $result = $db->folders->insertOne([
        "type" => "folder",
        "folder-name" => "general",
        "content" => []
    ]);
    $id = $result->getInsertedId();
    $cursor = $db->accounts->insertOne([
        "accessId" => $id,
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "phone" => $_POST['phone'],
        "password" => $_POST['password'],
        "subjects" => []
    ]);
    $cursor = $db->newAccounts->deleteOne([
        "_id" => new MongoDB\BSON\ObjectId($_POST['id'])
    ]);
    // mail sending code
    $to_email = $_POST['email'];
    $subject = "Welcome ".$_POST['name']." !";
    $body = "Your account is ready to use. Now you can manage all your LMS activities via this account. This moodle will be benefitial to all teachers and students. If any suggestions then please contact us.";
    $headers = "From: prithvirajpatil2511@gmail.com";

    if (mail($to_email, $subject, $body, $headers)) {
        header("Location: owner.php?email=success");
    } else {
        header("Location: owner.php?email=failure");
    }
    exit();
} elseif (isset($_POST["reject"])) {
    include "connect.php";
    $cursor = $db->newAccounts->deleteOne([
        "_id" => new MongoDB\BSON\ObjectId($_POST['id'])
    ]);
    header("Location: owner.php");
    exit();
} elseif (isset($_POST["deleteAccount"])) {
    include "connect.php";
    header("Location: owner.php");
    exit();
} elseif (isset($_POST["updateAccount"])) {
    include "connect.php";
    $cursor = $db->accounts->updateOne([
        "_id" => new MongoDB\BSON\ObjectId($_POST['id'])
    ], ['$set' => ["name" => $_POST['name'], "email" => $_POST['email'], "phone" => $_POST['phone']]]);
    header("Location: owner.php");
    exit();
} else {
    header("Location: owner.php");
    exit();
}
