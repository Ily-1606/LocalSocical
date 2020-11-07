<?php
session_start();
if(isset($_SESSION["id"]) && isset($_SESSION["email"])){
    $id = $_SESSION["id"];
    $email = $_SESSION["email"];
    echo $email;
}
else{
    header("Location: /view/login.php");
}
