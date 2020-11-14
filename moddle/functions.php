<?php
function render_message()
{
    return 0;
}
function check_user_login()
{
    if (isset($_SESSION["id"]) && isset($_SESSION["email"]))
        return true;
    return false;
}
function get_single_message($row)
{
    $arr = array();
    $arr["avatar"] = $row["avatar"];
    $arr["fname"] = $row["first_name"];
    $arr["lname"] = $row["last_name"];
    $arr["fullname"] = $row["first_name"] . " " . $row["last_name"];
    $arr["user_id"] = $row["user_id"];
    $arr["message_text"] = $row["message_text"];
    $arr["file"] = $row["attachment"];
    $arr["time_sent"] = $row["create_time"];
    $time = new DateTime($row["create_time"]);
    $arr["timestamp"] = $time->format('U');
    if ($_SESSION["id"] == $row["user_send"])
        $arr["ower_user"] = "me";
    else
        $arr["ower_user"] = "other";
    return $arr;
}
function render_messages($room_id)
{
    global $conn;
    $data = array();
    $rs = mysqli_query($conn, "SELECT table_account.id AS user_id, table_account.avatar, table_account.first_name, table_account.last_name, table_messages.* FROM `table_messages` INNER JOIN table_account ON table_messages.user_send = table_account.id WHERE thread_id = $room_id ORDER BY create_time DESC LIMIT 0,10");
    while ($row = mysqli_fetch_array($rs)) {
        $arr = get_single_message($row);
        array_push($data, $arr);
    }
    return $data;
}
function check_user_in_room($room_id)
{
    global $conn;
    $id_user = $_SESSION["id"];
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM table_thread WHERE JSON_SEARCH(member_list,'one', '$id_user') IS NOT NULL AND id = $room_id")))
        return true;
    return false;
}
function send_wss($message)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost:1338/push",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $message,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}
