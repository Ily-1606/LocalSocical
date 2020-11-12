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
            $id_user = $_SESSION["id"];
            $rs = mysqli_query($conn, "SELECT * FROM table_account WHERE id != $id_user LIMIT 0,10");
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
    } elseif ($action == "search_user") {
        if (isset($_POST["email"])) {
            include_once("../_connect.php");
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            if (check_user_login()) {
                $id_user = $_SESSION["id"];
                $rs = mysqli_query($conn, "SELECT * FROM table_account WHERE id != $id_user AND email = '$email' LIMIT 1");
                if (mysqli_num_rows($rs)) {
                    $data["status"] = true;
                    $data["data"] = array();
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
                    $data["msg"] = "Not found user.";
                }
            } else {
                $data["status"] = false;
                $data["msg"] = "Please login againt.";
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "Email is invalid.";
        }
    }
} else {
    $data["status"] = false;
    $data["msg"] = "Unknow this action.";
}
echo json_encode($data);
