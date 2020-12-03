<?php
session_start();
if(isset($_POST['clickedQuiz'])){
    include "../../../connectDatabase.php";
    $folders=$db->folders;
    $cursor=$folders->findOne(["_id" => new MongoDB\BSON\ObjectID($_POST['clickedQuiz_id'])]);
    $_SESSION['quiz_id']=$cursor['quiz_id'];
    header("Location: ./quizEdit.php");
}
elseif (isset($_POST['deleteQuiz'])) {
    $id=$_POST['clickedQuiz_id'];
    $parentid=$_SESSION['parent_id'];

    include "../../../connectDatabase.php";
    $quiz= $db->quiz;
    $folders=$db->folders;
    $quetions=$db->quetions;

    // pull id of the folder from the parent folder content 
    $result=$folders->updateOne(
        ["_id"=> $parentid],
        ['$pull'=> ["content"=>new MongoDB\BSON\ObjectID($id)]]
    );

    $cursor=$folders->findOne(["_id" => new MongoDB\BSON\ObjectID($id)]);
    $cursor2=$quiz->findOne(["_id" => new MongoDB\BSON\ObjectID($cursor['quiz_id'])]);
    foreach ($cursor2['contents'] as $qids) {
        $quetions->deleteOne(["_id" => new MongoDB\BSON\ObjectID($qids)]);
    }

    $quiz->deleteOne(["_id" => new MongoDB\BSON\ObjectID($cursor['quiz_id'])]);
    
    $folders->deleteOne(["_id" => new MongoDB\BSON\ObjectID($id)]);
    
    header("Location: ../courses/manageCoursesAdmin.php");
}
else{
    echo "nothing";
}

?>