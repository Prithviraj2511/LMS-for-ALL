<?php

session_start();
session_unset();
session_destroy();
header("Location: Templates/home/signin-signup.php");