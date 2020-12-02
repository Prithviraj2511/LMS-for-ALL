<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .forms {
            margin: 10vh 30vw;
            display: flex;
            flex-direction: column;
        }

        .forms input {
            margin: 3vh;
        }

        div {
            text-align: center;
        }
    </style>
</head>

<body>
    <div>
        <?php
        if(isset($_GET['error'])){
            if($_GET['error']=="invalidclgnameemail"){
                echo "<p>clgname and email not valid</p>";
            }
            elseif($_GET['error']=="invalidemail"){
                echo "<p>Email is not valid</p>";
            }
            elseif($_GET['error']=="invalidclgname"){
                echo "<p>college name is not valid</p>";
            }
            elseif($_GET['error']=="passwordmismatch"){
                echo "<p>password is not matching</p>";
            }
        }
        ?>
        <form class="forms" action="signup.prc.php" method="post">
            <?php
            if(isset($_GET['clgname'])){
                echo "<input type='text' name='clg-name' placeholder='college name...' value=".$_GET['clgname']." required>";
            }
            else{
                echo "<input type='text' name='clg-name' placeholder='college name...' required>";
            }
            if(isset($_GET['email'])){
                echo "<input type='email' name='clg-email' placeholder='E-mail...' value=".$_GET['email']." required>";
            }
            else{
                echo "<input type='email' name='clg-email' placeholder='E-mail...' required>";
            }
            
            ?>
            <input type="tel" name="phone" placeholder="123-45-678" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" required>
            <input type="password" name="signup-password" placeholder="Password..." required>
            <input type="password" name="repeat-password" placeholder="Repeat Password..." required>
            <input type="submit" name="signup-submit" value="Sign up">
        </form>
    </div>
</body>

</html>