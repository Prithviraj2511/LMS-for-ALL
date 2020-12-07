<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Reset password</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body style="background-color: lightseagreen;">
    <div style="margin: auto; width:fit-content; margin-top:10vh; padding: 25px; background-color:white">
        <div class="nav">
            <h2 class="heading">Reset Password</h2>
        </div>
        <?php

        include '../../connectDatabase.php';
        if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
            $key = $_GET["key"];
            $error = "";
            $email = $_GET["email"];
            $_SESSION['new'] = "$email";
            $curDate = date("Y-m-d H:i:s");

            $temp = $db->temp;
            $cursor = $temp->find();
            $allkeys = array();
            foreach ($cursor as $i) {

                array_push($allkeys, $i['key']);
            }

            if (!array_search(trim($key), $allkeys)) {
                $error .= "<h2>Invalid Link</h2>
                <p>The link is invalid/expired. Either you did not copy the correct link
                from the email, or you have already used the key in which case it is
                deactivated.'" . $curDate . "' '" . $email . "' '" . $key . "' <br>" . $sql . "</p>
                <p><a href='./forget_pass.php'>
                Click here</a> to reset password.</p>";
            } else {

                $everything = array();
                $key = trim($key);

                $newcursor = $temp->findOne(['key' => "$key"]);
                //  print_r($newcursor['expdate']);
                $expDate = $newcursor['expdate'];


                if ($expDate >= $curDate) {


        ?>
                    <br />
                    <form method="post" class="form" action="" name="update">
                        <input type="hidden" name="action" class="login-input" value="update" />
                        <br /><br />
                        <label><strong>Enter New Password:</strong></label><br />
                        <input type="password" name="pass1" class="login-input" maxlength="15" required />
                        <br /><br />
                        <label><strong>Re-Enter New Password:</strong></label><br />
                        <input type="password" name="pass2" class="login-input" maxlength="15" required />
                        <br /><br />
                        <input type="hidden" name="email" class="login-input" value="<?php echo $email; ?>" />
                        <input type="submit" class="login-button" value="Reset Password" />
                    </form>
        <?php
                } else {
                    $error .= "<h2>Link Expired</h2>
                    <p>The link is expired. You are trying to use the expired link which
                    as valid only 24 hours (1 days after request).<br /><br /></p>";
                }
            }
            if ($error != "") {
                echo "<div class='error'>" . $error . "</div><br />";
            }
        } // isset email key validate end


        if (isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
            $error = "";
            $pass1 = $_POST["pass1"];
            $pass2 = $_POST["pass2"];

            $email = $_POST["email"];
            $curDate = date("Y-m-d H:i:s");
            if ($pass1 != $pass2) {
                $error .= "<p>Password do not match, both password should be same.<br /><br /></p>";
            }
            if ($error != "") {
                echo "<div class='error'>" . $error . "</div><br />";
            } else {


                $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
                $acc = $db->accounts;
                $email = trim($email);
                $update = $acc->updateOne(
                    ['email' => "$email"],
                    ['$set' => ['password' => "$pass1"]]
                );
                //printf("Matched %d document(s)\n", $update->getMatchedCount());

                echo '<div class="error"><p>Congratulations! Your password has been updated successfully.</p>
                        <p><a href="signin-signup.php">
                        Click here</a> to Login.</p></div><br />';
            }
        }
        ?>
    </div>
</body>

</html>