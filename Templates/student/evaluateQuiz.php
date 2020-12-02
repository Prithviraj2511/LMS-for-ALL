<?php

session_start();

include "../../connectDatabase.php";
$quiz = $db->quiz;
$quetions = $db->quetions;
$grades=$db->grades;
$studentAccounts=$db->studentAccounts;

$record=json_decode($_GET['q']);
$marks=0;

foreach ($record as $qid => $opt) {
    $quetionContent = $quetions->findOne(["_id" => new MongoDB\BSON\ObjectID($qid)]);
    $intersectCount=count(array_intersect(iterator_to_array($quetionContent['correct_option']), $opt));
    $isCorrect= $intersectCount== count(iterator_to_array($quetionContent['correct_option'])) && $intersectCount!=0;
    if($isCorrect){
        $marks=$marks+$quetionContent['marks_alloted'];
    }
}

$grades->insertOne([
    'quiz_id'=>$_SESSION['quiz_id'],
    'stu_id'=>$_SESSION['user_id'],
    'marks'=>$marks,
    'attempt'=>$_GET['q']
]);