<?php
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "localsocical";
$conn = new mysqli($servername,$username,$password,$databasename);
if($conn->connect_error){
    die("Có lỗi khi kết nối với máy chủ CSDL!");
}
date_default_timezone_set("Asia/Ho_Chi_Minh");
?>