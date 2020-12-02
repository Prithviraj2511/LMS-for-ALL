<?php
session_start();
if(isset($_SESSION['teacherid'])){
    echo $_SESSION["teacherid"];
    echo "<h1>Hi ".$_SESSION['clgname']."</h1>";
    echo "<h1>Hi ".$_SESSION['username']."</h1>";
    echo "<h1>Hi ".$_SESSION['userEmail']."</h1>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Teacher <?php echo $_SESSION['teacherid'];?>
</body>
</html>

<?php
}
else{
    header("Location: ../home/signin-signup.php");
    exit();
}
?>