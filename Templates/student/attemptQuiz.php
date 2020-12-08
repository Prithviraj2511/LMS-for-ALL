<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/attemptQuiz.css">
</head>

<body>
    <?php
    session_start();

    // accessing collections from the database
    include "../../connectDatabase.php";
    $quiz = $db->quiz;
    $quetions = $db->quetions;
    $folders = $db->folders;

    // id of the quiz in quiz collection
    $quizFolder = $folders->findOne(['_id' => new MongoDB\BSON\ObjectID($_POST["clickedQuiz_id"])]);
    $_SESSION['quiz_id'] = $quizFolder['quiz_id'];
    $particularQuiz = $quiz->findOne(["_id" => $quizFolder['quiz_id']]);
    ?>
    <div class="quizOuterClass">
        <h1><?php echo $particularQuiz['name'] ?></h1>

        <?php
        foreach ($particularQuiz['contents'] as $key => $qids) {
            // particularQue contains whole info about the quetion
            $particularQue = $quetions->findOne(["_id" => new MongoDB\BSON\ObjectID($qids)]);
        ?>
            <div class="quizContent">

                <div class="quizQue">
                    <span>Q<?php echo $key + 1 ?>. </span>
                    <span><?php echo $particularQue['statement'] ?></span>
                </div>

            </div>
            <?php
            $correctOptCount = count(iterator_to_array($particularQue['correct_option']));
            // if there are multiple options correct then we will display it as checkboxes
            if ($correctOptCount != 1) {
                foreach ($particularQue['options'] as $key => $value) {
            ?>
                    <div class="quizOpt">
                        <div>
                            <input class="choices" data-key=<?php echo $particularQue['_id'] ?> type="checkbox" value="<?php echo $value ?>">
                            <label><?php echo $value ?></label>
                        </div>

                    </div>

                <?php
                }
            } else {
                foreach ($particularQue['options'] as $key => $value) {
                ?>
                    <div class="quizOpt">
                        <div>
                            <input class="choices" data-key=<?php echo $particularQue['_id'] ?> type="radio" value="<?php echo $value ?>" name=<?php echo $particularQue['_id'] ?>>
                            <label><?php echo $value ?></label>
                        </div>

                    </div>

            <?php
                }
            }
            ?>
        <?php
        }
        ?>
        <div class="quizSubmit">
            <button onclick="submitTest()" class="button"><span>Submit </span></button>
        </div>
    </div>
    <script>
        const ips = document.querySelectorAll('.choices');
        const submitButton = document.querySelector('#submitTest');
        let attemptArr = {};

        function updateAns() {
            // if there is radio button then we will replace previous answer in the attempArr
            if (this.type == 'radio') {
                attemptArr[this.dataset.key] = [this.value];
            } else {
                if (this.checked == true) {
                    // if one checkbox is already checked
                    if (this.dataset.key in attemptArr) {
                        attemptArr[this.dataset.key].push(this.value);
                    } else {
                        attemptArr[this.dataset.key] = [this.value];
                    }
                } else {
                    // pop values if checkbox is not checked
                    attemptArr[this.dataset.key].splice(attemptArr[this.dataset.key].indexOf(this.value), 1);
                }
            }
            console.log(JSON.stringify(attemptArr));
        }

        function submitTest() {
            // instanstiate xhr object
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const websiteLink = document.URL
                    if (websiteLink.includes('localhost')) {
                        window.location.replace("http://localhost/LMS%20for%20ALL/Templates/student/dashboardHome.php");
                    }
                    else{
                        window.location.replace("void-lms-for-all.herokuapp.com/Templates/student/dashboardHome.php")
                    }
                }
            };
            var params = JSON.stringify(attemptArr);
            // send the request
            xhr.open("GET", "evaluateQuiz.php?q=" + params);
            // function is done with given task

            xhr.send();

        }
        ips.forEach(ip => ip.addEventListener('click', updateAns));
    </script>

</body>

</html>