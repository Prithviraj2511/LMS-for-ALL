<?php
if (isset($_POST['quizSubmit'])) {
    include "../../../connectDatabase.php";
    $quiz = $db->quiz;
    $res = $quiz->updateOne([
        "_id" => new MongoDB\BSON\ObjectID($_POST['quizid'])
    ], [
        '$set' => ["completed" => true]
    ]);
    header("Location: ../courses/manageCoursesAdmin.php");
} else {
    echo "Direct Access Not Allowed";
}
