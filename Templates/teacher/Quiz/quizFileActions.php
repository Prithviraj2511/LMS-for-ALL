<?php
session_start();
if (isset($_POST['clickedQuiz'])) {
    include "../../../connectDatabase.php";
    $folders = $db->folders;
    $cursor = $folders->findOne(["_id" => new MongoDB\BSON\ObjectID($_POST['clickedQuiz_id'])]);
    $_SESSION['quiz_id'] = $cursor['quiz_id'];
    header("Location: ./quizEdit.php");
} elseif (isset($_POST['deleteQuiz'])) {
    $id = $_POST['clickedQuiz_id'];
    $parentid = $_SESSION['parent_id'];

    include "../../../connectDatabase.php";
    $quiz = $db->quiz;
    $folders = $db->folders;
    $quetions = $db->quetions;

    // pull id of the folder from the parent folder content 
    $result = $folders->updateOne(
        ["_id" => $parentid],
        ['$pull' => ["content" => new MongoDB\BSON\ObjectID($id)]]
    );

    $cursor = $folders->findOne(["_id" => new MongoDB\BSON\ObjectID($id)]);
    $cursor2 = $quiz->findOne(["_id" => new MongoDB\BSON\ObjectID($cursor['quiz_id'])]);
    foreach ($cursor2['contents'] as $qids) {
        $quetions->deleteOne(["_id" => new MongoDB\BSON\ObjectID($qids)]);
    }

    $quiz->deleteOne(["_id" => new MongoDB\BSON\ObjectID($cursor['quiz_id'])]);

    $folders->deleteOne(["_id" => new MongoDB\BSON\ObjectID($id)]);

    header("Location: ../dashboardHome.php");
} elseif (isset($_POST['quiz_stats'])) {
    # code...
    include "../../../connectDatabase.php";
    $grades = $db->grades;
    $studentAccounts = $db->studentAccounts;


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                background-color: rgb(238, 200, 94);
            }

            #users {
                font-family: Arial, Helvetica, sans-serif;
                display: block;
                border-collapse: collapse;
                max-width: fit-content;
                margin: 30px auto;
                background-color: white;
                white-space: nowrap;
                height: fit-content;
                max-height: 600px;
                overflow: scroll;
                -ms-overflow-style: none;
                scrollbar-width: none;
                border-radius: 30px;
            }

            #users::-webkit-scrollbar {
                display: none;
            }

            #users td,
            #users th {

                border: 1px solid #ddd;
                padding: 15px;
            }

            #users tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            #users tr:hover {
                background-color: #ddd;
            }

            #users th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
                position: sticky;
                top: 0;
            }


            input[name="teacher_name"] {
                border: none;
                outline: none;
                background-color: transparent;
                resize: none;
                /*remove the resize handle on the bottom right*/
            }

            input[type="tel"] {
                border: none;
                outline: none;
                background-color: transparent;
                resize: none;
                /*remove the resize handle on the bottom right*/
            }

            .accountButtons {
                border-style: none;
                border-radius: 20%;
                font-size: 12px;
                padding: 7px;
                color: white;
                background-color: #4CAF50;
                font-weight: 700;
                transition: transform 0.5s;
                vertical-align: middle;
            }

            .accountButtons[value="UPDATE"] {
                background-color: #4CAF50;
                margin-left: 20px;
            }

            .accountButtons[value="DELETE"] {
                background-color: rgb(248, 108, 108);
                margin-left: 20px;
                margin-right: 20px;
            }

            .accountButtons:hover {
                cursor: pointer;
                transform: scale(1.1);
            }

            select {
                cursor: pointer;
            }

            #partitionHeadings {
                background-color: gray;
                font-size: 2em;
                font-family: cursive;
                color: honeydew;
                text-align: center;
            }

            .grades {
                margin: auto;
            }
        </style>
    </head>


    <body>
        <div class="grades">
            <table id="users">
                <thead>
                    <tr>
                        <td colspan="5" style=" background-color: gray; font-size: 2em;font-family: cursive;color: honeydew; text-align: center;">
                            Grades</td>
                    </tr>
                    <tr>
                        <th>Sr.no.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cursor = $grades->find(['quiz_id' => new MongoDB\BSON\ObjectID($_POST['quiz_id'])]);
                    foreach ($cursor as $key => $attempt_details) {
                        # code...
                        $student = $studentAccounts->findOne(['_id' => $attempt_details['stu_id']]);
                    ?>
                        <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td><?php echo $attempt_details['marks']; ?></td>

                        </tr>
                    <?php

                    }
                    ?>




                </tbody>

            </table>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: ../../404.html");
}

?>