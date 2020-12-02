<?php
session_start();
if (isset($_SESSION["stuid"])) {
    include "../../connectDatabase.php";
    $accessId = $_SESSION['parent_id'];
    $stuAccounts = $db->studentAccounts;
    $teacherAccounts = $db->teacherAccounts;
    $accounts = $db->accounts;
    $folders = $db->folders;
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
        </style>
    </head>

    <body>
        <?php
        if (isset($_POST['exitAccounts'])) {
            header("Location: ./dashboardHome.php");
        }
        ?>
        <form action="manageAccounts.php" method="post">
            <input type="submit" name="exitAccounts" value="Exit">
        </form>
        <table id="users">
            <thead>
                <tr>
                    <td colspan="5" style=" background-color: gray; font-size: 2em;font-family: cursive;color: honeydew; text-align: center;">
                        Students</td>
                </tr>
                <tr>
                    <th>Sr.no.</th>
                    <th>Name</th>
                    <th>Access</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // This array will contain all the folder names and folder ids as key value pair
                $accessChoice = [];
                $cursor = $accounts->find(["_id" => new MongoDB\BSON\ObjectID($_SESSION["clg_id"])]);
                foreach ($cursor as $particularAccount) {
                    foreach ($particularAccount['subjects'] as $subjectid) {
                        $subs = $folders->find(["_id" => new MongoDB\BSON\ObjectID($subjectid)]);
                        foreach ($subs as $sub) {
                            $accessChoice[strval($sub['_id'])] = $sub['folder-name'];
                        }
                    }
                }
                $cursor = $stuAccounts->find(["accessId" => strval($accessId)]);
                $indexCounter = 0;
                foreach ($cursor as $acc) {
                    $indexCounter++;
                ?>
                    <tr>
                        
                            <td><label><?php echo $indexCounter ?></label></td>
                            <td><label><?php echo $acc["name"] ?></label></td>
                            <td>
                            <select>
                                    <?php
                                    foreach ($accessChoice as $key => $value) {
                                        if ($key == $acc['accessId']) {
                                    ?>
                                            <option value=<?php echo $key ?> selected><?php echo $value ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="tel" name="stu_phone" placeholder="1234-567-890" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" value='<?php echo $acc["phone"] ?>' disabled required>
                                <input type="email" name="stu_email" id="" value="<?php echo $acc['email'] ?>" disabled>
                            </td>
                    </tr>

                <?php
                }
                ?>
            </tbody>

        </table>

        <table id="users">
            <thead>
                <tr>
                    <td colspan="5" style=" background-color: gray; font-size: 2em;font-family: cursive;color: honeydew; text-align: center;">
                        Teachers</td>
                </tr>
                <tr>
                    <th>Sr.no.</th>
                    <th>Name</th>
                    <th>Access</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
               
                $cursor = $teacherAccounts->find(["accessId" => strval($accessId)]);

                $indexCounter = 0;
                foreach ($cursor as $acc) {
                    $indexCounter++;
                ?>
                    <tr>
                        <form action="updateTeacherAcc.php" method="post">
                            <td><?php echo $indexCounter ?></td>
                            <td><label><?php echo $acc["name"] ?></label></td>
                            <td>
                                <select name="teacher_access" id="">
                                    <?php
                                    foreach ($accessChoice as $key => $value) {
                                        if ($key == $acc['accessId']) {
                                    ?>
                                            <option value=<?php echo $key ?> selected><?php echo $value ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="tel" name="teacher_phone" placeholder="1234-567-890" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" value='<?php echo $acc["phone"] ?>' disabled required>

                                <input type="email" name="teacher_email" id="" value="<?php echo $acc['email'] ?>" disabled>
                            </td>
                        </form>
                    </tr>
                <?php
                }
                ?>
                
            </tbody>

        </table>


    </body>

    </html>
<?php
} else {
    header("Location: ../home/signin-signup.php");
    exit();
}
?>