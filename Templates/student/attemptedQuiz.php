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
        <title>Document</title>
    </head>

    <body>
        <?php
        echo $_POST['marks'];
        $attempt = json_decode($_POST['attempt']);
        $quizFolder = $folders->findOne(['_id' => new MongoDB\BSON\ObjectID($_POST["clickedQuiz_id"])]);
        $_SESSION['quiz_id'] = $quizFolder['quiz_id'];
        $particularQuiz = $quiz->findOne(["_id" => $quizFolder['quiz_id']]);


        ?>
        <h1><?php echo $particularQuiz['name'] ?></h1>
        <?php
        foreach ($particularQuiz['contents'] as $qids) {
            // particularQue contains whole info about the quetion

            $particularQue = $quetions->findOne(["_id" => new MongoDB\BSON\ObjectID($qids)]);
            $intersectCount = count(array_intersect(iterator_to_array($particularQue['correct_option']), $attempt->$qids));
            $isCorrect = $intersectCount == count(iterator_to_array($particularQue['correct_option'])) && $intersectCount != 0;
            if ($isCorrect) {


        ?>
                <div class="correct">
                    <p><?php echo $particularQue['statement'] ?></p>
                    <?php
                    $correctOptCount = count(iterator_to_array($particularQue['correct_option']));
                    // if there are multiple options correct then we will display it as checkboxes
                    $optIdx = 0;
                    if ($correctOptCount != 1) {
                        foreach ($particularQue['options'] as $key => $value) {
                            if ($value == $particularQue['correct_option'][$optIdx]) {
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
                    } else {
                        foreach ($particularQue['options'] as $key => $value) {
                            if ($value == $particularQue['correct_option'][$optIdx]) {
                                $optIdx++;
                            ?>

                                <input class="choices" type="radio" checked>
                                <label><?php echo $value ?></label>
                            <?php
                            } else {
                            ?>

                                <input class="choices" type="radio">
                                <label><?php echo $value ?></label>
                            <?php
                            }
                            ?>

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
                        $optIdx = 0;
                        if ($correctOptCount != 1) {
                            foreach ($particularQue['options'] as $key => $value) {
                                if ($value == $particularQue['correct_option'][$optIdx]) {
                                    $optIdx++;
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
                        } else {
                            foreach ($particularQue['options'] as $key => $value) {
                                if ($value == $particularQue['correct_option'][$optIdx]) {
                                    $optIdx++;
                                ?>

                                    <input class="choices" type="radio" checked>
                                    <label><?php echo $value ?></label>
                                <?php
                                } else {
                                ?>

                                    <input class="choices" type="radio">
                                    <label><?php echo $value ?></label>
                                <?php
                                }
                                ?>

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