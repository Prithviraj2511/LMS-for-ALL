<!DOCTYPE html>
<html>

<head>
  <title>Sign In & Sign Up </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../../CSS/signin-signup.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
</head>

<body>
  <div class="cont">
    <div class="form sign-in">
      <h2>Sign In</h2>

      <form action="signin.prc.php" method="post">
        <br>
        <span class="chooseAuthority">
          <input type="radio" id="student" name="authority" value="student" checked style="width: fit-content; margin:0px;">
          <label for="student" style="margin: 0px 2vw; width:fit-content;">Student</label>
          <input type="radio" id="teacher" name="authority" value="teacher" style="width: fit-content; margin:0px;">
          <label for="teacher"  style="margin: 0px 2vw; width:fit-content;">Teacher</label>
          <input type="radio" id="admin" name="authority" value="admin" style="width: fit-content; margin:0px;">
          <label for="admin"  style="margin: 0px 2vw; width:fit-content;">Admin</label>
        </span>
        <label>
          <span>Email</span>
          <?php

          if (isset($_GET['email'])) {
          ?>
            <input type="email" name="email" value=<?php echo $_GET['email'] ?> required>
          <?php
          } else {
          ?>
            <input type="email" name="email" required>
          <?php
          }
          ?>
        </label>

        <label>
          <span>Password</span>
          <input type="password" name="pass" required maxlength="12">
        </label>
        <button class="submit" type="submit" name="sign-in" value="Sign In">Sign In</button>
        <p class="forgot-pass"><a href="send_link_forget_pass.php">Forgot Password ?</a></p>
      </form>
      <label>
      <?php
      if (isset($_GET['error'])) {
        if ($_GET['error'] == "accountDoesnotExist") {
          echo "<p class='error-message'>No account exist with entered email or id</p>";
        }
        elseif ($_GET['error']=="wrongPassword") {
          echo "<p class='error-message'>Incorrect Password</p>";
        }
      }
      if(isset($_GET['signup'])){
        if($_GET["signup"]=="success"){
          echo "<p class='success-message'>After confirmation you will be able to login</p>";
        }
      }
      ?>
      </label>


    </div>

    <div class="sub-cont">
      <div class="img">
        <div class="img-text m-up">
          <h2>New here?</h2>
          <p>Sign up and discover great amount of new opportunities!</p>
        </div>
        <div class="img-text m-in">
          <h2>One of us?</h2>
          <p>If you already has an account, just sign in. We've missed you!</p>
        </div>
        <div class="img-btn">
          <span class="m-up">Sign Up</span>
          <span class="m-in">Sign In</span>
        </div>
      </div>
      <div class="form sign-up">
        <h2>Sign Up</h2>
        <form action="signup.prc.php" method="post">


          <label>
            <span>College Name</span>
            <?php
            if (isset($_GET['clgname'])) {
              echo "<input type='text' name='clg-name'  value=" . $_GET['clgname'] . " required>";
            } else {
              echo "<input type='text' name='clg-name'  required>";
            }
            ?>
          </label>
          <label>
            <span>Email</span>
            <?php
            if (isset($_GET['email'])) {
              echo "<input type='email' name='clg-email'  value=" . $_GET['email'] . " required>";
            } else {
              echo "<input type='email' name='clg-email'  required>";
            }

            ?>
          </label>
          <label>
            <span>Mobile No</span>
            <input type="tel" name="phone" placeholder="1234-567-890" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" required>
          </label>
          <label>
            <span>Password</span>
            <input type="password" name="signup-password" required>
          </label>
          <label>
            <span>Confirm Password</span>
            <input type="password" name="repeat-password" required>
          </label>
          <label>
          <?php
          if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidclgnameemail") {
              echo "<p class='error-message'>clgname and email not valid</p>";
            } elseif ($_GET['error'] == "invalidemail") {
              echo "<p class='error-message'>Email is not valid</p>";
            } elseif ($_GET['error'] == "invalidclgname") {
              echo "<p class='error-message'>college name is not valid</p>";
            } elseif ($_GET['error'] == "passwordmismatch") {
              echo "<p class='error-message'>password is not matching</p>";
            }
          }
          
          ?>
          </label>
          <button type="submit" class="submit" name="signup-submit">Sign Up Now</button>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="../../JS/signin-signup.js"></script>
</body>

</html>