<?php
if (isset($_POST['createFolder'])) {
    if (empty($_POST['folder_name'])) {
        echo "Please enter folder_name";
    } else {
        $insertResult = $folders->insertOne([
            "type" => "folder",
            "folder-name" => $_POST['folder_name'],
            "content" => [],
            "stu_count"=>0,
            "teacher_count"=>0,
            "announcements"=>[]
        ]);
        $id = $insertResult->getInsertedId();
        $insertResult = $folders->updateOne(
            ["_id" => $parentFolderId],
            ['$push' => ["content" => $id]]
        );
        $insertResult = $accounts->updateOne(
            ["_id" => new MongoDB\BSON\ObjectID($_SESSION["adminid"])],
            ['$push' => ["subjects" => $id]]
        );
    }
}
?>