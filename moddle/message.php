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
                    $mark_message = null;
                    if (isset($_GET["next_page"])) {
                        $mark_message = mysqli_real_escape_string($conn, base64_decode($_GET["next_page"]));
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
                            $data["data"] = render_messages($rs["id"], $mark_message);
                            $_SESSION["thread_id"] = $rs["id"];
                        } else {
                            $list_member = json_encode(array($id_user, $room_id));
                            $rs = mysqli_query($conn, "INSERT INTO table_thread (`member_list`) VALUES ('$list_member')");
                            $data["room_id"] = mysqli_insert_id($conn);
                            $_SESSION["thread_id"] = $data["room_id"];
                        }
                    } else {
                        $rs = mysqli_query($conn, "SELECT * FROM table_thread WHERE id = $room_id");
                        $rs = mysqli_fetch_assoc($rs);
                        $data["data"] = render_messages($room_id, $mark_message);
                        $data["room_id"] = $room_id;
                        if ($rs["type"] == "per_to_per") {
                            $list_member = json_decode($rs["member_list"]);
                            for ($i = 0; $i < count($list_member); $i++) {
                                $id = $list_member[$i];
                                if ($id != $id_user) {
                                    $rs = mysqli_query($conn, "SELECT * FROM table_account WHERE id = $id");
                                    $rs = mysqli_fetch_assoc($rs);
                                    $data["name_room"] = $rs["first_name"] . " " . $rs["last_name"];
                                }
                            }
                        } else {
                            $data["name_room"] = $rs["name_room"];
                        }
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
    } elseif ($action == "get_list_thread") {
        include_once("../_connect.php");
        $id_user = $_SESSION["id"];
        if (check_user_login()) {
            $mark_message = null;
            if (isset($_GET["next_page"])) {
                $mark_message = mysqli_real_escape_string($conn, base64_decode($_GET["next_page"]));
            }
            $data["status"] = true;
            $data["data"] = array();
            $data["data"] = render_list_thread($id_user, $mark_message);
        } else {
            $data["status"] = false;
            $data["msg"] = "Please login againt.";
        }
    } elseif ($action == "send_message") {
        if (isset($_POST["room_id"]) && isset($_POST["message"])) {
            $room_id = $_POST["room_id"];
            if (is_numeric($room_id)) {
                include_once("../_connect.php");
                include_once("functions.php");
                $room_id = mysqli_real_escape_string($conn, $room_id);
                $message = mysqli_real_escape_string($conn, htmlspecialchars($_POST["message"]));
                if (check_user_login()) {
                    $id_user = $_SESSION["id"];
                    $info_thread = mysqli_query($conn, "SELECT * FROM table_thread WHERE id = $room_id");
                    if (mysqli_num_rows($info_thread)) {
                        $rs = mysqli_query($conn, "INSERT INTO table_messages (`thread_id`,`message_text`,`user_send`) VALUES ($room_id,'$message',$id_user)");
                        if ($rs) {
                            $id_message = mysqli_insert_id($conn);
                            update_last_thread($room_id);
                            $rs = mysqli_query($conn, "SELECT table_account.id AS user_id, table_account.avatar, table_account.first_name, table_account.last_name, table_messages.* FROM `table_messages` INNER JOIN table_account ON table_messages.user_send = table_account.id WHERE table_messages.id = $id_message");
                            $rs = mysqli_fetch_assoc($rs);
                            $array_m = array();
                            $info_thread = mysqli_fetch_assoc($info_thread);
                            $array_m["info_user"] = get_single_message($rs);
                            $array_m["send_to_user"] = json_decode($info_thread["member_list"]);
                            $array_m["type"] = "show_message";
                            $array_m["room_id"] = $room_id;
                            send_wss(json_encode($array_m));
                            $data["status"] = true;
                            $data["msg"] = "Message sent.";
                        } else {
                            $data["status"] = false;
                            $data["msg"] = "Wrong send message.";
                        }
                    } else {
                        $data["status"] = false;
                        $data["msg"] = "Room id not exist.";
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
                                update_last_thread($data["room_id"]);
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
    } elseif ($action == "ping_typing") {
        if (isset($_POST["room_id"])) {
            if (check_user_login()) {
                include_once("../_connect.php");
                $room_id = mysqli_real_escape_string($conn, $_POST["room_id"]);
                $array_m = array();
                $id = $_SESSION["id"];
                $info_user = mysqli_query($conn, "SELECT * FROM table_account WHERE id = $id");
                $info_user = mysqli_fetch_assoc($info_user);
                $array_m["info_user"] = array("user_id" => $info_user["id"], "fullname" => $info_user["first_name"] . " " . $info_user["last_name"], "avatar" => $info_user["avatar"]);
                $array_m["type"] = "typing";
                $array_m["room_id"] = $room_id;
                $info_thread = mysqli_query($conn, "SELECT * FROM table_thread WHERE id = $room_id");
                if (mysqli_num_rows($info_thread)) {
                    $info_thread = mysqli_fetch_assoc($info_thread);
                    $array_m["send_to_user"] = json_decode($info_thread["member_list"]);
                    send_wss(json_encode($array_m));
                }
            } else {
                $data["msg"] = "Please login againt.";
                $data["status"] = false;
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "Unknow room id.";
        }
    } elseif ($action == "delete_message") {
        if (isset($_POST["id_message"])) {
            if (check_user_login()) {
                include_once("../_connect.php");
                $id_message = mysqli_real_escape_string($conn, $_POST["id_message"]);
                $array_m = array();
                $id = $_SESSION["id"];
                $rs = mysqli_query($conn, "SELECT * FROM table_messages WHERE id = $id_message AND user_send = $id");
                if (mysqli_num_rows($rs)) {
                    if (mysqli_query($conn, "UPDATE table_messages SET hidden = 1 WHERE id = $id_message")) {
                        $rs = mysqli_fetch_assoc($rs);
                        $array_m["type"] = "delete_message";
                        $array_m["room_id"] = $rs["thread_id"];
                        $array_m["message_id"] = $id_message;
                        update_last_thread($rs["thread_id"]);
                        $info_thread = mysqli_query($conn, "SELECT * FROM table_thread WHERE id = " . $rs["thread_id"]);
                        if (mysqli_num_rows($info_thread)) {
                            $info_thread = mysqli_fetch_assoc($info_thread);
                            $array_m["send_to_user"] = json_decode($info_thread["member_list"]);
                            $data["status"] = true;
                            $data["msg"] = "Message deleted.";
                            send_wss(json_encode($array_m));
                        }
                    } else {
                        $data["msg"] = "Error while delete message.";
                        $data["status"] = false;
                    }
                } else {
                    $data["msg"] = "Message not exist.";
                    $data["status"] = false;
                }
            } else {
                $data["msg"] = "Please login againt.";
                $data["status"] = false;
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "Unknow message id.";
        }
    } else {
        $data["status"] = false;
        $data["msg"] = "Unknow this action.";
    }
}
echo json_encode($data);
