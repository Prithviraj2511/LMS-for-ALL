<?php

if(isset($_POST['createQuiz'])){
    session_start();
    include "../../../connectDatabase.php";
    $quiz= $db->quiz;
    $result=$quiz->insertOne([
        "Access_id"=>$_SESSION["parent_id"],
        "name"=>$_POST['quizName'],
        "creator"=>$_SESSION['user_id'],
        "contents"=>[],
        "attempt_Counter"=>0,
        "completed"=>false
    ]);
    $_SESSION["quiz_id"]=$result->getInsertedId();
    $folders=$db->folders;
    $result=$folders->insertOne([
        "type"=>"quiz",
        "folder-name"=>$_POST['quizName'],
        "quiz_id"=>$_SESSION["quiz_id"]
    ]);
   
    $folders->updateOne([
        "_id"=>$_SESSION["parent_id"]
    ],[
        '$push' => ["content" => $result->getInsertedId()]
    ]);
    header("Location: quizEdit.php");
}
else{
   echo "Direct Access Not Allowed";
}
?>
