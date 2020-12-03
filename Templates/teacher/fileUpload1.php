<?php
session_start();
$parentFolderId=$_SESSION['parent_id'];
include "../../connectDatabase.php";
$files = $db->folders;
// if button of upload file is clicked following block will execute
    if (isset($_POST['uploadFile'])) {
        // $_FILES['fileUploaded'] will return key=>value pairs of some properties of file
        $fileUploaded = $_FILES['fileUploaded'];
        if(!isset($_FILES['fileUploded'])){
            header("Location: dashboardHome.php?error=FileNotChoosen");
        }
        // when the file gets uploaded its name,type and size with some id will be stored in database
        $insertResult = $files->insertOne([
            "type" => "file",
            "folder-name" => $fileUploaded['name'],
            "size" => $fileUploaded['size']
        ]);
        // fetching id of inserted file 
        $unique_id = $insertResult->getInsertedId();
        $insertResult = $files->updateOne(
            ["_id" => $parentFolderId],
            ['$push' => ["content" => $unique_id]]
        );
        // extension of the file is checked
        $splitName = explode(".", $fileUploaded['name']);
        $fileUploadedExt = strtolower(end($splitName));
        $allowedExt = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'zip');
        if (in_array($fileUploadedExt, $allowedExt)) {
            if ($fileUploaded['error'] == 0) {
                if ($fileUploaded['size'] < 2e+7) {
                    $fileNewName = $unique_id . "." . $fileUploadedExt;
                    $fileDestination = '../../../uploads/' . $fileNewName;
                    move_uploaded_file($fileUploaded['tmp_name'], $fileDestination);
                    echo "file Uploaded successfully";
                } else {
                    echo "Your file is too big!";
                }
            } else {
                echo "There was an error uploading your file!";
            }
        } else {
            echo "You cannot upload file of this type";
        }
    }
    if(isset($_POST['clickedfile'])){
        $splitName = explode(".",$_POST['clickedfile_name']);
        $fileUploadedExt = strtolower(end($splitName));
        $file_location='uploads/'.$_POST['clickedfile_id'].".".$fileUploadedExt;
        header('content-disposition: attachment; filename='.$_POST['clickedfile_name']);
        $fb=fopen($file_location,"r");
        while(!feof($fb)){
            echo fread($fb,8000);
            flush();
        }
        fclose($fb);
    }
    if(isset($_POST['deleteFile'])){
        $files->deleteOne(["_id" => new MongoDB\BSON\ObjectID($_POST['clickedfile_id'])]);
        $splitName = explode(".",$_POST['clickedfile_name']);
        $fileUploadedExt = strtolower(end($splitName));
        unlink("../../../uploads/".$_POST['clickedfile_id'].".".$fileUploadedExt);
        $files->updateOne(
            ["_id"=>  $_SESSION['parent_id']],
            ['$pull'=> [ "content"=>new MongoDB\BSON\ObjectID($_POST["clickedfile_id"])]]
        );   
    }

    header("Location: dashboardHome.php");
    exit();
?>