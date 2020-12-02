<?php
if (isset($_POST['clickedQuiz'])) {
    session_start();

    // accessing collections from the database
    include "../../connectDatabase.php";
    $quiz = $db->quiz;
    $quetions = $db->quetions;
    $folders = $db->folders;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Attempted Quiz</title>
        <style>
            .correct{
                background-color: rgb(0, 230, 77);
            }

            .wrong{
                background-color:rgb(255, 77, 77);
            }
        </style>
    </head>

    <body>
        <?php
        $attempt = json_decode($_POST['attempt']);
        $quizFolder = $folders->findOne(['_id' => new MongoDB\BSON\ObjectID($_POST["clickedQuiz_id"])]);
        $_SESSION['quiz_id'] = $quizFolder['quiz_id'];
        $particularQuiz = $quiz->findOne(["_id" => $quizFolder['quiz_id']]);
        

        ?>
        <h1><?php echo $particularQuiz['name'] ?></h1>
        <h1>You Got <?php echo $_POST['marks']?> marks</h1>
        <?php
        foreach ($particularQuiz['contents'] as $qids) {
            // particularQue contains whole info about the quetion
            $particularQue = $quetions->findOne(["_id" => new MongoDB\BSON\ObjectID($qids)]);
            if (isset($attempt->$qids)) {
                $intersectCount = count(array_intersect(iterator_to_array($particularQue['correct_option']), $attempt->$qids));
                $isCorrect = $intersectCount == count(iterator_to_array($particularQue['correct_option'])) && $intersectCount != 0;
            } else {
                $isCorrect = false;
            }
            if ($isCorrect) {
        ?>
                <div class="correct">
                    <p><?php echo $particularQue['statement'] ?></p>
                    <?php
                    $correctOptCount = count(iterator_to_array($particularQue['correct_option']));
                    // if there are multiple options correct then we will display it as checkboxes


                    foreach ($particularQue['options'] as $key => $value) {
                        if (in_array($value, iterator_to_array($particularQue['correct_option']))) {
                    ?>

                            <input class="choices" type="checkbox" checked>
                            <label><?php echo $value ?></label>
                        <?php
                        } else {
                        ?>

                            <input class="choices" type="checkbox">
                            <label><?php echo $value ?></label>
                    <?php
                        }
                    }
                    echo '</div>';
                } else {
                    ?>
                    <div class="wrong">
                        <p><?php echo $particularQue['statement'] ?></p>
                        <?php
                        $correctOptCount = count(iterator_to_array($particularQue['correct_option']));
                        // if there are multiple options correct then we will display it as checkboxes
    
    
                        foreach ($particularQue['options'] as $key => $value) {
                            if (in_array($value, iterator_to_array($particularQue['correct_option']))) {
                        ?>
    
                                <input class="choices" type="checkbox" checked>
                                <label><?php echo $value ?></label>
                            <?php
                            } else {
                            ?>
    
                                <input class="choices" type="checkbox">
                                <label><?php echo $value ?></label>
                        <?php
                            }
                        }
                        echo '</div>';
                    }
                }
                ?>
    </body>

    </html>

<?php
} else {
    header("Location: ../404.html");
    exit();
}
?>