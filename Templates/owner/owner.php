<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner</title>
</head>
<body>
    <?php
        include "connect.php";
    ?>
    <h1>Panding Requests</h1>
    <?php
    $cursor=$db->newAccounts->find([]);
    foreach ($cursor as $acc) {
        ?>
        <form action="accountHandle.php" method="post">
        <p>Name : <?php echo $acc["name"]?></p>
        <p>Email : <?php echo $acc["email"]?></p>
        <p>Phone No. : <?php echo $acc["phone"]?></p>
        <input type="hidden" name="id" value=<?php echo $acc["_id"]?>>
        <input type="hidden" name="email" value=<?php echo $acc["email"]?>>
        <input type="hidden" name="name" value=<?php echo  "'".$acc["name"]."'"?>>
        <input type="hidden" name="phone" value=<?php echo  $acc["phone"]?>>
        <input type="hidden" name="password" value=<?php echo $acc["password"]?>>
        <input type="submit" name="confirm" value="Confirm">
        <input type="submit" name="reject" value="Reject">
        </form>
        <?php
    }
    ?>
    <h1>Accounts</h1>
    <?php
    $cursor=$db->accounts->find([]);
    foreach ($cursor as $acc) {
        ?>
        <form action="accountHandle.php" method="post">
        <input type="hidden" name="id" value=<?php echo $acc["_id"]?>>
        <input type="email" name="email" value=<?php echo $acc["email"]?>>
        <input type="text" name="name" value=<?php echo "'".$acc["name"]."'"?>>
        <input type="tel" name="phone" placeholder="123-45-678" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" value=<?php echo $acc["phone"]?>>
        <input type="submit" name="deleteAccount" value="Delete">
        <input type="submit" name="updateAccount" value="Update">
        </form>
        <?php
    }
    ?>
</body>
</html>