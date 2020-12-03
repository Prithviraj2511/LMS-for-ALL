<?php
session_start();
if (isset($_SESSION['quiz_id'])) {
    include "../../../connectDatabase.php";
    $quiz = $db->quiz;
    $quetions = $db->quetions;
    
    // Every time we enter in quiz edit then quiz completed status will be false
    $res = $quiz->updateOne([
        "_id" => new MongoDB\BSON\ObjectID($_SESSION['quiz_id'])
    ], [
        '$set' => ["completed" => false]
    ]);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                box-sizing: border-box;
            }

            html {
                background-color: rgba(191, 202, 202, 0.795);
            }

            body {
                width: 100%;
                height: 100%;
            }

            .container {
                position: relative;
                width: 100%;
                height: 100%;
            }

            .Quiz {
                position: absolute;
                background-color: rgb(233, 228, 219);
                width: 70%;
                right: 15%;
                left: 15%;
                top: 10%;
            }

            .quetionBlock {
                margin: 5% 5%;
            }

            .deleteOpt {
                display: none;
            }

            .deleteOpticon {
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
                vertical-align: middle;
            }

            .deleteOpticon:hover {

                transform: scale(1.2);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
            }

            .deleteQue {
                display: none;
            }

            .deleteQueicon {
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
                vertical-align: middle;
            }

            .deleteQueicon:hover {
                transform: scale(1.2);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
            }


            .belowQueContent {
                margin-left: 43px;
                width: 100%;
            }

            .quetionArea {
                padding: 8px;
                margin: 10px 10px;
                width: 65%;
            }

            .optionArea {
                padding: 8px;
                margin: 10px 10px;
                width: 80%;
            }

            .updateQuetion {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 8px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 1em;
                margin-left: 15px;
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
            }

            .updateQuetion:hover {
                transform: scale(1.07);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
            }

            .optionCheckbox {
                height: 20px;
                width: 20px;
                vertical-align: middle;
                cursor: pointer;
                background-color: #eee;
            }

            .addOption {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 8px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 1em;
                margin-left: 15px;
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
            }

            .addOption:hover {
                transform: scale(1.07);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
            }
            .newQuetion{
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 8px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 1em;
                margin-left: 15px;
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
            }

            .newQuetion:hover {
                transform: scale(1.07);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
            }

            .marksAlloted{
                width: 20px;
                height: 30px;
                text-align: center;
                max-width: fit-content;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="Quiz">
               
                
                <?php
                if (isset($_POST['enterNewQuetion'])) {
                    $statement = $_POST['quest'];
                    if (isset($_POST['opt'])) {
                        $options = $_POST['opt'];
                    } else {
                        $options = [];
                    }
                    if (isset($_POST['arr'])) {
                        $correctOptionNos = $_POST['arr'];
                    } else {
                        $correctOptionNos = [];
                    }
                    $correctOptions = array();

                    for ($i = 0; $i < sizeof($options); $i++) {
                        for ($j = 0; $j < sizeof($correctOptionNos); $j++) {
                            if ($i == $correctOptionNos[$j]) {
                                array_push($correctOptions, $options[$i]);
                            }
                        }
                    }
                    $res = $quetions->insertOne([
                        "statement" => $statement,
                        "options" => $options,
                        "correct_option" => $correctOptions,
                        "marks_alloted" => $_POST['marks'],
                        "attempt_counter" => "",
                        "correct_counter" => "",
                    ]);
                    $qid = $res->getInsertedId();
                    $res = $quiz->updateOne([
                        "_id" => new MongoDB\BSON\ObjectID($_SESSION['quiz_id'])
                    ], [
                        '$push' => ["contents" => $qid]
                    ]);
                }
                $particularQuiz = $quiz->findOne(["_id" => new MongoDB\BSON\ObjectID($_SESSION['quiz_id'])]);
                ?>
                <h2 style="text-align: center; margin-top:30px"><?php echo $particularQuiz['name']?></h2>
                <?php
                    foreach ($particularQuiz['contents'] as $qids) {
                        $cursor2 = $quetions->find(["_id" => new MongoDB\BSON\ObjectID($qids)]);
                        foreach ($cursor2 as $qno => $eachQuetion) {
                ?>
                            <form action="updateQuetion.php" method="post">
                                <input type="hidden" name="_id" value=<?php echo "'" . $eachQuetion['_id'] . "'" ?>>
                                <input type="hidden" name="quiz_id" value=<?php echo "'" . $_SESSION['quiz_id'] . "'" ?>>
                                <div class="quetionBlock">
                                    Q. <input class="quetionArea" type="text" name="statement" value=<?php echo "'" . $eachQuetion['statement'] . "'" ?>>
                                    <input class="marksAlloted" type="text" name="marks" value=<?php echo "'" . $eachQuetion['marks_alloted'] . "'" ?>>
                                    <label>
                                        <svg class="deleteQueicon" xmlns="http://www.w3.org/2000/svg" height="14pt" viewBox="-57 0 512 512" width="14pt">
                                            <path d="m156.371094 30.90625h85.570312v14.398438h30.902344v-16.414063c.003906-15.929687-12.949219-28.890625-28.871094-28.890625h-89.632812c-15.921875 0-28.875 12.960938-28.875 28.890625v16.414063h30.90625zm0 0" />
                                            <path d="m344.210938 167.75h-290.109376c-7.949218 0-14.207031 6.78125-13.566406 14.707031l24.253906 299.90625c1.351563 16.742188 15.316407 29.636719 32.09375 29.636719h204.542969c16.777344 0 30.742188-12.894531 32.09375-29.640625l24.253907-299.902344c.644531-7.925781-5.613282-14.707031-13.5625-14.707031zm-219.863282 312.261719c-.324218.019531-.648437.03125-.96875.03125-8.101562 0-14.902344-6.308594-15.40625-14.503907l-15.199218-246.207031c-.523438-8.519531 5.957031-15.851562 14.472656-16.375 8.488281-.515625 15.851562 5.949219 16.375 14.472657l15.195312 246.207031c.527344 8.519531-5.953125 15.847656-14.46875 16.375zm90.433594-15.421875c0 8.53125-6.917969 15.449218-15.453125 15.449218s-15.453125-6.917968-15.453125-15.449218v-246.210938c0-8.535156 6.917969-15.453125 15.453125-15.453125 8.53125 0 15.453125 6.917969 15.453125 15.453125zm90.757812-245.300782-14.511718 246.207032c-.480469 8.210937-7.292969 14.542968-15.410156 14.542968-.304688 0-.613282-.007812-.921876-.023437-8.519531-.503906-15.019531-7.816406-14.515624-16.335937l14.507812-246.210938c.5-8.519531 7.789062-15.019531 16.332031-14.515625 8.519531.5 15.019531 7.816406 14.519531 16.335937zm0 0" />
                                            <path d="m397.648438 120.0625-10.148438-30.421875c-2.675781-8.019531-10.183594-13.429687-18.640625-13.429687h-339.410156c-8.453125 0-15.964844 5.410156-18.636719 13.429687l-10.148438 30.421875c-1.957031 5.867188.589844 11.851562 5.34375 14.835938 1.9375 1.214843 4.230469 1.945312 6.75 1.945312h372.796876c2.519531 0 4.816406-.730469 6.75-1.949219 4.753906-2.984375 7.300781-8.96875 5.34375-14.832031zm0 0" />
                                        </svg>
                                        <input class="deleteQue" type="submit" value="Delete" name="DeleteQue">
                                    </label>
                                    <input class="updateQuetion" type="submit" value="Update" name="UpdateQuiz">
                                    <br>

                                    <div class="belowQueContent">
                                        <?php
                                        $eachQuetionOpts = array();
                                        $eachQuetionCorrectopts = array();
                                        foreach ($eachQuetion['options'] as $opt) {
                                            array_push($eachQuetionOpts, $opt);
                                        }
                                        foreach ($eachQuetion['correct_option'] as $correctopt) {
                                            array_push($eachQuetionCorrectopts, $correctopt);
                                        }
                                        foreach ($eachQuetionOpts as $key => $value) {
                                            if (in_array($value, $eachQuetionCorrectopts)) {
                                        ?>
                                                <input class="optionCheckbox" type="checkbox" name="arr[]" value=<?php echo "'" . $key . "'" ?> checked>
                                                <input class="optionArea" type="text" name="opt[]" value=<?php echo "'" . $value . "'" ?>>
                                                <label>
                                                    <svg class="deleteOpticon" xmlns="http://www.w3.org/2000/svg" height="14pt" viewBox="0 0 512 512" width="14pt">
                                                        <path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 0" fill="#f44336" />
                                                        <path d="m350.273438 320.105469c8.339843 8.34375 8.339843 21.824219 0 30.167969-4.160157 4.160156-9.621094 6.25-15.085938 6.25-5.460938 0-10.921875-2.089844-15.082031-6.25l-64.105469-64.109376-64.105469 64.109376c-4.160156 4.160156-9.621093 6.25-15.082031 6.25-5.464844 0-10.925781-2.089844-15.085938-6.25-8.339843-8.34375-8.339843-21.824219 0-30.167969l64.109376-64.105469-64.109376-64.105469c-8.339843-8.34375-8.339843-21.824219 0-30.167969 8.34375-8.339843 21.824219-8.339843 30.167969 0l64.105469 64.109376 64.105469-64.109376c8.34375-8.339843 21.824219-8.339843 30.167969 0 8.339843 8.34375 8.339843 21.824219 0 30.167969l-64.109376 64.105469zm0 0" fill="#fafafa" /></svg>
                                                    <input class="deleteOpt" type="submit" value=<?php echo "'" . $key . "'" ?> name="DeleteOpt"><br>
                                                </label>
                                            <?php
                                            } else {
                                            ?>
                                                <input class="optionCheckbox" type="checkbox" name="arr[]" value=<?php echo "'" . $key . "'" ?>>
                                                <input class="optionArea" type="text" name="opt[]" value=<?php echo "'" . $value . "'" ?>>
                                                <label>
                                                    <svg class="deleteOpticon" xmlns="http://www.w3.org/2000/svg" height="14pt" viewBox="0 0 512 512" width="14pt">
                                                        <path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 0" fill="#f44336" />
                                                        <path d="m350.273438 320.105469c8.339843 8.34375 8.339843 21.824219 0 30.167969-4.160157 4.160156-9.621094 6.25-15.085938 6.25-5.460938 0-10.921875-2.089844-15.082031-6.25l-64.105469-64.109376-64.105469 64.109376c-4.160156 4.160156-9.621093 6.25-15.082031 6.25-5.464844 0-10.925781-2.089844-15.085938-6.25-8.339843-8.34375-8.339843-21.824219 0-30.167969l64.109376-64.105469-64.109376-64.105469c-8.339843-8.34375-8.339843-21.824219 0-30.167969 8.34375-8.339843 21.824219-8.339843 30.167969 0l64.105469 64.109376 64.105469-64.109376c8.34375-8.339843 21.824219-8.339843 30.167969 0 8.339843 8.34375 8.339843 21.824219 0 30.167969l-64.109376 64.105469zm0 0" fill="#fafafa" /></svg>
                                                    <input class="deleteOpt" type="submit" value=<?php echo "'" . $key . "'" ?> name="DeleteOpt"><br>
                                                </label>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <input class="optionCheckbox" type="checkbox" name="newOptCB" value="1">
                                        <input type="text" class="optionArea" name="newOpt" placeholder="add option.." value=""><br>
                                    </div>
                                </div>
                            </form>
                <?php
                        }
                    }
                ?>
                <form action="quizEdit.php" method="post">
                    <div class="quetionBlock">
                        <label for="Question">Q . &nbsp;</label>
                        <input class="quetionArea" type="text" name="quest" placeholder="Enter statement here....">
                        <input class="marksAlloted" type="text" name="marks">
                        <input class="addOption" type="button" value="Add option" onClick="addOption('dynamicOpt');">
                        <div class="belowQueContent">
                            <div id="dynamicOpt">
                                <input class="optionCheckbox" type="checkbox" name="arr[]" value="0">
                                <input class="optionArea" type="text" name="opt[]" /><br>
                            </div>
                            <input class="newQuetion" type="submit" name="enterNewQuetion" value="Enter New Question">
                        </div>
                    </div>
                </form>
                <form action="./quizSubmit.php" method="post" style="width: 100%; display:flex; justify-content: center; margin-bottom:40px">
                    <input type="hidden" name="quizid" value="<?php echo $_SESSION['quiz_id']?>">
                    <input class="newQuetion" name="quizSubmit" type="submit" value="Submit">
                </form>
            </div>
        </div>
        <script>
            var Counter = 0;
            var limit = 5;

            function addOption(divName) {
                if (Counter == limit) {
                    alert("You have reached the limit of adding " + (Counter + 1) + " options ");
                } else {
                    Counter++;
                    var newdiv = document.createElement('div');
                    newdiv.innerHTML = "<input class='optionCheckbox' type='checkbox' name='arr[]' value='" + Counter + "'><input class='optionArea' type='text' name='opt[]' /><br>";
                    document.getElementById(divName).appendChild(newdiv);
                }
            }
        </script>
    </body>

    </html>
<?php
} else {
    echo "Direct Access Not Allowed";
}
?>