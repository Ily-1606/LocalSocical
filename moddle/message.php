<?php
session_start();
$data = array();
include_once("functions.php");
if (isset($_GET["action"])) {
    $action = $_GET["action"];
    if ($action == "get_list_message") {
        if (isset($_GET["room_id"]) && isset($_GET["type"])) {
            $room_id = $_GET["room_id"];
            if (is_numeric($room_id)) {
                include_once("../_connect.php");
                $room_id = mysqli_real_escape_string($conn, $room_id);
                $type = mysqli_real_escape_string($conn, $_GET["type"]);
                $id_user = $_SESSION["id"];
                if (check_user_login()) {
                    if (isset($_GET["next"])) {
                        //   $next =
                    }
                    $data["status"] = true;
                    $data["data"] = array();
                    if ($type == "user") {
                        $rs = mysqli_query($conn, "SELECT * FROM table_account WHERE id = $room_id LIMIT 1");
                        $rs = mysqli_fetch_assoc($rs);
                        $data["name_room"] = $rs["first_name"] . " " . $rs["last_name"];
                        $rs = mysqli_query($conn, "SELECT * FROM table_thread WHERE JSON_SEARCH(member_list,'one', '$id_user') IS NOT NULL AND JSON_SEARCH(member_list,'one', '$room_id') IS NOT NULL");
                        if (mysqli_num_rows($rs)) {
                            $rs = mysqli_fetch_assoc($rs);
                            $data["room_id"] = $rs["id"];
                            $data["data"] = render_messages($rs["id"]);
                            $_SESSION["thread_id"] = $rs["id"];
                        } else {
                            $list_member = json_encode(array($id_user, $room_id));
                            $rs = mysqli_query($conn, "INSERT INTO table_thread (`member_list`) VALUES ('$list_member')");
                            $data["room_id"] = mysqli_insert_id($conn);
                            $_SESSION["thread_id"] = $data["room_id"];
                        }
                    } else {
                        $data["data"] = render_messages($room_id);
                        $data["room_id"] = $room_id;
                        $_SESSION["thread_id"] = $room_id;
                    }
                } else {
                    $data["status"] = false;
                    $data["msg"] = "Please login againt.";
                }
            } else {
                $data["status"] = false;
                $data["msg"] = "Room id is invalid.";
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "Unknow room id or type.";
        }
    } elseif ($action == "send_message") {
        if (isset($_POST["room_id"]) && isset($_POST["message"])) {
            $room_id = $_POST["room_id"];
            if (is_numeric($room_id)) {
                include_once("../_connect.php");
                $room_id = mysqli_real_escape_string($conn, $room_id);
                $message = mysqli_real_escape_string($conn, htmlspecialchars($_POST["message"]));
                if (check_user_login()) {
                    $id_user = $_SESSION["id"];
                    $rs = mysqli_query($conn, "INSERT INTO table_messages (`thread_id`,`message_text`,`user_send`) VALUES ($room_id,'$message',$id_user)");
                    if ($rs) {
                        $data["status"] = true;
                        $data["msg"] = "Message sent.";
                    } else {
                        $data["status"] = false;
                        $data["msg"] = "Wrong send message.";
                    }
                } else {
                    $data["status"] = false;
                    $data["msg"] = "Please login againt.";
                }
            } else {
                $data["status"] = false;
                $data["msg"] = "Room id is invalid.";
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "Unknow room id.";
        }
    } elseif ($action == "create_room") {
        if (isset($_POST["list_user"]) && isset($_POST["name_group"]) && isset($_POST["captcha"])) {
            if ($_SESSION["captcha"] == $_POST["captcha"]) {
                unset($_SESSION["captcha"]);
                if (check_user_login()) {
                    include_once("../_connect.php");
                    $id_user = $_SESSION["id"];
                    $list_user = json_decode($_POST["list_user"]);
                    if (count($list_user)) {
                        array_push($list_user, $id_user);
                        $list_user = array_unique($list_user);
                        $big_query = "SELECT id FROM table_account WHERE id = " . $list_user[0];
                        for ($i = 1; $i < count($list_user); $i++) {
                            $big_query .= " OR id = " . $list_user[$i];
                        }
                        $list_user = array();
                        $rs = mysqli_query($conn, $big_query);
                        while ($row = mysqli_fetch_assoc($rs)) {
                            array_push($list_user, $row["id"]);
                        }
                        if (count($list_user)) {
                            $admin = array($id_user);
                            $name_room = mysqli_real_escape_string($conn, htmlspecialchars($_POST["name_group"]));
                            $rs = mysqli_query($conn, "INSERT INTO table_thread (`type`,`member_list`,`adminnitranstor`,`name_room`) VALUES ('group','" . json_encode($list_user) . "','" . json_encode($admin) . "','$name_room')");
                            if ($rs) {
                                $data["status"] = true;
                                $data["room_id"] = mysqli_insert_id($conn);
                                $_SESSION["thread_id"] = $data["room_id"];
                                $data["msg"] = "Create room success.";
                            } else {
                                $data["msg"] = "Error when create group chat.";
                                $data["status"] = false;
                            }
                        } else {
                            $data["msg"] = "List user not be empty.";
                            $data["status"] = false;
                        }
                    } else {
                        $data["msg"] = "List user not be empty.";
                        $data["status"] = false;
                    }
                } else {
                    $data["msg"] = "Please login againt.";
                    $data["status"] = false;
                }
            } else {
                $data["status"] = false;
                $data["msg"] = "Captcha wrong.";
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "List users not be empty.";
        }
    } else {
        $data["status"] = false;
        $data["msg"] = "Unknow this action.";
    }
}
echo json_encode($data);
