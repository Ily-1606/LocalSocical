<?php
session_start();
$data = array();
include_once("functions.php");
if (isset($_GET["action"])) {
    $action = $_GET["action"];
    if ($action == "get_list_user") {
        if (check_user_login()) {
            if (isset($_GET["next"])) {
                //   $next =
            }
            include_once("../_connect.php");
            $data["status"] = true;
            $data["data"] = array();
            $rs = mysqli_query($conn, "SELECT * FROM table_account LIMIT 0,10");
            while ($row = mysqli_fetch_array($rs)) {
                $arr = array();
                $arr["avatar"] = $row["avatar"];
                $arr["fname"] = $row["first_name"];
                $arr["lname"] = $row["last_name"];
                $arr["fullname"] = $row["first_name"] . " " . $row["last_name"];
                $arr["id"] = $row["id"];
                array_push($data["data"], $arr);
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "Please login againt.";
        }
    }
} else {
    $data["status"] = false;
    $data["msg"] = "Unknow this action.";
}
echo json_encode($data);
