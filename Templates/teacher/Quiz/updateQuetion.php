<?php
if (isset($_POST['UpdateQuiz'])) {
    include "../../../connectDatabase.php";
    $quetions = $db->quetions;
    $qid = $_POST['_id'];
    $question = $_POST['statement'];
    $marks=$_POST['marks'];
    if(is_array($_POST['opt'])){
        $options = $_POST['opt'];
    }else{
        $options =[];
    }
    $correctOptionNos = $_POST['arr'];
    $correctOptions = array();
    $newOpt = $_POST['newOpt'];

    for ($i = 0; $i < sizeof($options); $i++) {
        for ($j = 0; $j < sizeof($correctOptionNos); $j++) {
            if ($i == $correctOptionNos[$j]) {
                array_push($correctOptions, $options[$i]);
            }
        }
    }

    if ($newOpt == "") {
        $res = $quetions->updateOne(
            [
                "_id" => new MongoDB\BSON\ObjectID($qid)
            ],
            [
                '$set' => [
                    "statement" => $question,
                    "options" => $options,
                    "correct_option" => $correctOptions,
                    "marks_alloted" => $marks,
                    "attempt_counter" => "",
                    "correct_counter" => "",
                ]
            ]
        );
    } else {
        array_push($options, $newOpt);
        if ($_POST['newOptCB'] == '1') {
            array_push($correctOptions, $newOpt);
        }
        $res = $quetions->updateOne(
            [
                "_id" => new MongoDB\BSON\ObjectID($qid)
            ],
            [
                '$set' => [
                    "statement" => $question,
                    "options" => $options,
                    "correct_option" => $correctOptions,
                    "marks_alloted" => $marks,
                    "attempt_counter" => "",
                    "correct_counter" => "",
                ]
            ]
        );
    }

    header("Location: quizEdit.php");
} else if (isset($_POST['DeleteQue'])) {
    include "../../../connectDatabase.php";
    $quetions = $db->quetions;
    $quiz = $db->quiz;
    $qid = $_POST['_id'];
    $quizid = $_POST['quiz_id'];
    $res = $quetions->deleteOne([
        "_id" => new MongoDB\BSON\ObjectID($qid)
    ]);
    $res = $quiz->updateOne([
        "_id" => new MongoDB\BSON\ObjectID($quizid)
    ], [
        '$pull' => ["contents" => new MongoDB\BSON\ObjectID($qid)]
    ]);
    header("Location: quizEdit.php");
} elseif (isset($_POST['DeleteOpt'])) {
    # code...
    include "../../../connectDatabase.php";
    $quetions = $db->quetions;
    $qid = $_POST['_id'];
    $optNumber = number_format($_POST['DeleteOpt']);
    if(is_array($_POST['opt'])){
        $options = $_POST['opt'];
    }else{
        $options =[];
    }
    $res = $quetions->updateOne([
        "_id" => new MongoDB\BSON\ObjectID($qid)
    ], [
        '$pull' => [
            "options" => $options[$optNumber],
            "correct_option" => $options[$optNumber]
        ]
    ]);
    header("Location: quizEdit.php");
} else {
    echo "No Direct Access Allowed";
}
