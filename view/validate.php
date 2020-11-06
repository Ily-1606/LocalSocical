<?php
session_start();
if(isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"]) {
    echo "Correct Code Entered";
} else {
    die("Wrong Code Entered");
}
?>